<x-mail::message>
# Order Receipt

Thank you for your purchase! 
Here are the keys to your new games for Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}.

@foreach($keys as $key)
## {{ $key->game->title }}
Platform: {{ $key->game->platform ?? 'Platform' }}
Key: `{{ $key->key_code }}`
@endforeach

<x-mail::button :url="route('checkout.success', $order)">
View Order Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
