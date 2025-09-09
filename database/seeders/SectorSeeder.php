<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Agriculture et Agroalimentaire
            'Agriculture et Agroalimentaire' => [
                'Agriculture',
                'Élevage',
                'Pêche',
                'Sylviculture',
                'Transformation agroalimentaire',
                'Commerce de produits agricoles',
            ],

            // Mines et Énergie
            'Mines et Énergie' => [
                'Exploitation minière',
                'Pétrole et gaz',
                'Énergie renouvelable',
                'Production d\'électricité',
                'Distribution d\'énergie',
            ],

            // Commerce et Distribution
            'Commerce et Distribution' => [
                'Commerce de détail',
                'Commerce de gros',
                'E-commerce',
                'Import-Export',
                'Logistique et transport',
            ],

            // Services Financiers
            'Services Financiers' => [
                'Banque',
                'Assurance',
                'Microfinance',
                'Investissement',
                'Services comptables',
            ],

            // Télécommunications et Technologies
            'Télécommunications et Technologies' => [
                'Télécommunications',
                'Développement logiciel',
                'Services informatiques',
                'Téléphonie mobile',
                'Internet et connectivité',
            ],

            // Construction et Immobilier
            'Construction et Immobilier' => [
                'Construction',
                'Promotion immobilière',
                'Gestion immobilière',
                'Architecture',
                'BTP',
            ],

            // Santé et Pharmacie
            'Santé et Pharmacie' => [
                'Hôpitaux et cliniques',
                'Pharmacie',
                'Médecine traditionnelle',
                'Équipements médicaux',
                'Services de santé',
            ],

            // Éducation et Formation
            'Éducation et Formation' => [
                'Enseignement primaire',
                'Enseignement secondaire',
                'Enseignement supérieur',
                'Formation professionnelle',
                'Centres de formation',
            ],

            // Tourisme et Hôtellerie
            'Tourisme et Hôtellerie' => [
                'Hôtellerie',
                'Restauration',
                'Agences de voyage',
                'Tourisme culturel',
                'Écotourisme',
            ],

            // Industrie Manufacturière
            'Industrie Manufacturière' => [
                'Textile et habillement',
                'Chimie et plastiques',
                'Métallurgie',
                'Automobile',
                'Électronique',
            ],

            // Services Publics
            'Services Publics' => [
                'Administration publique',
                'Services municipaux',
                'Organisations internationales',
                'ONG et associations',
                'Services sociaux',
            ],

            // Médias et Communication
            'Médias et Communication' => [
                'Presse écrite',
                'Audiovisuel',
                'Publicité',
                'Relations publiques',
                'Édition',
            ],
        ];

        foreach ($categories as $parentCategory => $subCategories) {
            // Create parent sector
            $parent = Sector::create([
                'name' => $parentCategory,
                'slug' => Str::slug($parentCategory),
            ]);

            // Create sub-sectors
            foreach ($subCategories as $subCategory) {
                Sector::create([
                    'name' => $subCategory,
                    'slug' => Str::slug($subCategory),
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
