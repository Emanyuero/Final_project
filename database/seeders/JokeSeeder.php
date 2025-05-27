<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Joke;

class JokeSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $response = Http::get('https://v2.jokeapi.dev/joke/Any');

            if ($response->ok()) {
                $data = $response->json();

                Joke::create([
                    'type' => $data['type'],
                    'joke' => $data['type'] === 'single' ? $data['joke'] : null,
                    'setup' => $data['type'] === 'twopart' ? $data['setup'] : null,
                    'delivery' => $data['type'] === 'twopart' ? $data['delivery'] : null,
                ]);
            }
        }
    }
}
