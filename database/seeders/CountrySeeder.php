<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'France',
                'flag' => 'flags/fr.png',
                'code' => 'FR',
                'active' => true,
                'lang' => 'fr',
            ],
            [
                'name' => 'Côte d\'Ivoire',
                'flag' => 'flags/ci.png',
                'code' => 'CI',
                'active' => true,
                'lang' => 'fr',
            ],
            [
                'name' => 'Togo',
                'flag' => 'flags/tg.png',
                'code' => 'TG',
                'active' => true,
                'lang' => 'fr',
            ],
            [
                'name' => 'United States',
                'flag' => 'flags/us.png',
                'code' => 'US',
                'active' => true,
                'lang' => 'en',
            ],
            [
                'name' => 'Canada',
                'flag' => 'flags/ca.png',
                'code' => 'CA',
                'active' => true,
                'lang' => 'en',
            ],
            [
                'name' => 'Germany',
                'flag' => 'flags/de.png',
                'code' => 'DE',
                'active' => true,
                'lang' => 'de',
            ],
            [
                'name' => 'Spain',
                'flag' => 'flags/es.png',
                'code' => 'ES',
                'active' => true,
                'lang' => 'es',
            ],
            [
                'name' => 'Italy',
                'flag' => 'flags/it.png',
                'code' => 'IT',
                'active' => true,
                'lang' => 'it',
            ],
            [
                'name' => 'United Kingdom',
                'flag' => 'flags/gb.png',
                'code' => 'GB',
                'active' => true,
                'lang' => 'en',
            ],
            [
                'name' => 'Netherlands',
                'flag' => 'flags/nl.png',
                'code' => 'NL',
                'active' => true,
                'lang' => 'nl',
            ],
            [
                'name' => 'Belgium',
                'flag' => 'flags/be.png',
                'code' => 'BE',
                'active' => true,
                'lang' => 'fr',
            ],
            [
                'name' => 'Switzerland',
                'flag' => 'flags/ch.png',
                'code' => 'CH',
                'active' => true,
                'lang' => 'de',
            ],
            [
                'name' => 'Bénin',
                'flag' => 'flags/bj.png',
                'code' => 'BJ',
                'active' => true,
                'lang' => 'fr',
            ],
            [
                'name' => 'Burkina Faso',
                'flag' => 'flags/bf.png',
                'code' => 'BF',
                'active' => true,
                'lang' => 'fr',
            ],
        ];

        foreach ($countries as $countryData) {
            Country::updateOrCreate(
                ['code' => $countryData['code']],
                $countryData
            );
        }
    }
}
