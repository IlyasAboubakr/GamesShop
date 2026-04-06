<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Game;
use App\Models\GameKey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::firstOrCreate(
            ['email' => 'admin@gamesshop.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Client User
        User::firstOrCreate(
            ['email' => 'client@gamesshop.com'],
            [
                'name' => 'Client User',
                'password' => Hash::make('password'),
                'role' => 'client',
            ]
        );

        // Categories
        $categories = ['Action', 'RPG', 'Strategy', 'Sports', 'Simulation'];
        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat] = Category::firstOrCreate([
                'name' => $cat,
                'slug' => strtolower($cat),
            ]);
        }

        // Create games directory if doesn't exist
        Storage::disk('public')->makeDirectory('games');

        $gamesToSeed = [
            [
                'title' => 'Cyberpunk 2077',
                'description' => "Cyberpunk 2077 is an open-world, action-adventure story set in Night City, a megalopolis obsessed with power, glamour and body modification. \n\nYou play as V, a mercenary outlaw going after a one-of-a-kind implant that is the key to immortality.",
                'price' => 59.99,
                'platform' => 'PC',
                'category_name' => 'RPG',
                'stock' => 15,
                'image_seed' => 'cyberpunk'
            ],
            [
                'title' => 'God of War Ragnarök',
                'description' => "Join Kratos and Atreus on a mythic journey for answers before Ragnarök arrives.\n\nTogether, father and son must put everything on the line as they journey to each of the Nine Realms.",
                'price' => 69.99,
                'platform' => 'PlayStation',
                'category_name' => 'Action',
                'stock' => 20,
                'image_seed' => 'kratos'
            ],
            [
                'title' => 'EA SPORTS FC 24',
                'description' => "EA SPORTS FC™ 24 welcomes you to The World’s Game: the most true-to-football experience ever with HyperMotionV, PlayStyles optimised by Opta, and an enhanced Frostbite™ Engine.",
                'price' => 69.99,
                'platform' => 'PlayStation',
                'category_name' => 'Sports',
                'stock' => 30,
                'image_seed' => 'football'
            ],
            [
                'title' => 'Cities: Skylines II',
                'description' => "Build a city from the ground up and transform it into the thriving metropolis only you can imagine. \n\nYou've never experienced building on this scale. With deep simulation and a living economy, this is world-building without limits.",
                'price' => 49.99,
                'platform' => 'PC',
                'category_name' => 'Simulation',
                'stock' => 10,
                'image_seed' => 'city'
            ],
            [
                'title' => 'Age of Empires IV',
                'description' => "One of the most beloved real-time strategy games returns to glory with Age of Empires IV, putting you at the center of epic historical battles that shaped the world.",
                'price' => 39.99,
                'platform' => 'PC',
                'category_name' => 'Strategy',
                'stock' => 25,
                'image_seed' => 'empire'
            ]
        ];

        $this->command->info('Seeding Games... This might take a moment to download images.');

        foreach ($gamesToSeed as $gameData) {
            // Check if game already exists
            $existingGame = Game::where('title', $gameData['title'])->first();
            if ($existingGame) {
                $this->command->line("Skipped {$gameData['title']} - already exists");
                continue;
            }

            // Download image
            $imageName = 'games/' . Str::slug($gameData['title']) . '-' . uniqid() . '.jpg';
            // Use Picsum to get an image, redirecting via seed so it's consistent
            // But we'll just download directly using file_get_contents
            try {
                $imgData = @file_get_contents("https://picsum.photos/seed/{$gameData['image_seed']}/600/800");
                if ($imgData) {
                    Storage::disk('public')->put($imageName, $imgData);
                } else {
                    $imageName = null; // fallback if network fails
                }
            } catch (\Exception $e) {
                $imageName = null;
            }

            // Create game
            $game = Game::create([
                'title' => $gameData['title'],
                'description' => $gameData['description'],
                'price' => $gameData['price'],
                'platform' => $gameData['platform'],
                'category_id' => $categoryModels[$gameData['category_name']]->id,
                'stock' => $gameData['stock'],
                'cover_image' => $imageName
            ]);

            // Generate Keys
            for ($i = 0; $i < $gameData['stock']; $i++) {
                $keyGroups = [
                    Str::upper(Str::random(4)),
                    Str::upper(Str::random(4)),
                    Str::upper(Str::random(4)),
                    Str::upper(Str::random(4))
                ];
                
                GameKey::create([
                    'game_id' => $game->id,
                    'key_code' => implode('-', $keyGroups),
                    'is_used' => false
                ]);
            }

            $this->command->info("Seeded: {$game->title} with {$game->stock} keys.");
        }

        $this->command->info('Database seeding complete!');
    }
}
