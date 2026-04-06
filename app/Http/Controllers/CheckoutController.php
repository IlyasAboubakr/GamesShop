<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Exception;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Order;

class CheckoutController extends Controller
{
    protected CheckoutService $checkoutService;
    protected CartService $cartService;

    public function __construct(CheckoutService $checkoutService, CartService $cartService) {
        $this->checkoutService = $checkoutService;
        $this->cartService = $cartService;
    }

    public function index() {
        $cart = $this->cartService->getCart();
        if (empty($cart)) {
            return redirect()->route('store.browse')->with('error', 'Your cart is empty.');
        }
        $total = $this->cartService->getTotal();
        return view('store.checkout', compact('total', 'cart'));
    }

    public function store(Request $request) {
        $request->validate([
            'card_number' => 'required|string|min:16|max:19',
            'cvc' => 'required|string|min:3|max:4',
            'expiry' => 'required|string|regex:/^\d{2}\/\d{2}$/',
        ]);

        try {
            $order = $this->checkoutService->processCheckout(auth()->user(), $request->all());
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        // Send receipt email — silently fail so a mail error never breaks checkout
        try {
            $keys = \App\Models\GameKey::with('game')->where('order_id', $order->id)->get();
            \Illuminate\Support\Facades\Mail::to(auth()->user()->email)->send(new \App\Mail\OrderReceipt($order, $keys));
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Order receipt email failed: ' . $e->getMessage());
        }

        return redirect()->route('checkout.success', $order)->with('success', 'Payment successful!');
    }

    public function success(Order $order) {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->load(['items.game']);
        $keys = \App\Models\GameKey::with('game')->where('order_id', $order->id)->get();
        return view('store.success', compact('order', 'keys'));
    }

    public function downloadPdf(Order $order) {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $filename = 'order_receipt_' . $order->id . '.pdf';
        $storagePath = storage_path('app/public/receipts/' . $filename);

        $order->load(['items.game', 'user']);
        $keys = \App\Models\GameKey::with('game')->where('order_id', $order->id)->get();

        $html = view('pdf.receipt', compact('order', 'keys'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Get binary output
        $output = $dompdf->output();

        // Ensure directory exists
        if (!is_dir(dirname($storagePath))) {
            mkdir(dirname($storagePath), 0755, true);
        }

        // Save permanently
        file_put_contents($storagePath, $output);

        // Ensure no extra output corrupts the PDF
        if (ob_get_length()) {
            ob_end_clean();
        }

        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
