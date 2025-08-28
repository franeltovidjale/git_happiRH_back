<?php

namespace Database\Seeders;

use App\Models\Langue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LangueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $langues = [
            [
                'name' => 'French',
                'code' => 'fr',
                'country_code' => 'FR',
                'active' => true,
            ],
            [
                'name' => 'English',
                'code' => 'en',
                'country_code' => 'US',
                'active' => true,
            ],
            [
                'name' => 'German',
                'code' => 'de',
                'country_code' => 'DE',
                'active' => true,
            ],
            [
                'name' => 'Spanish',
                'code' => 'es',
                'country_code' => 'ES',
                'active' => true,
            ],
            [
                'name' => 'Italian',
                'code' => 'it',
                'country_code' => 'IT',
                'active' => true,
            ],
            [
                'name' => 'Dutch',
                'code' => 'nl',
                'country_code' => 'NL',
                'active' => true,
            ],
            [
                'name' => 'English (UK)',
                'code' => 'en-gb',
                'country_code' => 'GB',
                'active' => true,
            ],
            [
                'name' => 'French (Belgium)',
                'code' => 'fr-be',
                'country_code' => 'BE',
                'active' => true,
            ],
            [
                'name' => 'German (Switzerland)',
                'code' => 'de-ch',
                'country_code' => 'CH',
                'active' => true,
            ],
            [
                'name' => 'English (Canada)',
                'code' => 'en-ca',
                'country_code' => 'CA',
                'active' => true,
            ],
            [
                'name' => 'French (Canada)',
                'code' => 'fr-ca',
                'country_code' => 'CA',
                'active' => true,
            ],
            [
                'name' => 'Portuguese',
                'code' => 'pt',
                'country_code' => null,
                'active' => true,
            ],
            [
                'name' => 'Russian',
                'code' => 'ru',
                'country_code' => null,
                'active' => true,
            ],
            [
                'name' => 'Chinese',
                'code' => 'zh',
                'country_code' => null,
                'active' => true,
            ],
            [
                'name' => 'Japanese',
                'code' => 'ja',
                'country_code' => null,
                'active' => true,
            ],
        ];

        foreach ($langues as $langueData) {
            Langue::updateOrCreate(
                ['code' => $langueData['code']],
                $langueData
            );
        }
    }
}
