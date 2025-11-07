<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer quelques catégories de forum
        $categories = [
            [
                'name' => 'Questions Générales',
                'slug' => 'questions-generales',
                'description' => 'Posez toutes vos questions générales sur Laravel ici.',
                'color' => '#dc2626',
                'icon' => 'question-mark-circle',
                'sort_order' => 1,
            ],
            [
                'name' => 'Développement Laravel',
                'slug' => 'developpement-laravel',
                'description' => 'Discussions autour du développement avec Laravel, Eloquent, Blade, etc.',
                'color' => '#ea580c',
                'icon' => 'code-bracket',
                'sort_order' => 2,
            ],
            [
                'name' => 'Frontend (Vue.js, Alpine.js)',
                'slug' => 'frontend',
                'description' => 'Vue.js, Alpine.js, Inertia.js et autres frameworks frontend.',
                'color' => '#059669',
                'icon' => 'computer-desktop',
                'sort_order' => 3,
            ],
            [
                'name' => 'DevOps & Déploiement',
                'slug' => 'devops-deploiement',
                'description' => 'Docker, CI/CD, déploiement, serveurs et infrastructure.',
                'color' => '#7c3aed',
                'icon' => 'cloud',
                'sort_order' => 4,
            ],
            [
                'name' => 'Offres d\'Emploi',
                'slug' => 'offres-emploi',
                'description' => 'Offres d\'emploi et opportunités pour développeurs Laravel au Sénégal.',
                'color' => '#0891b2',
                'icon' => 'briefcase',
                'sort_order' => 5,
            ],
            [
                'name' => 'Présentations & Projets',
                'slug' => 'presentations-projets',
                'description' => 'Présentez vos projets Laravel et partagez vos créations.',
                'color' => '#be185d',
                'icon' => 'presentation-chart-bar',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $categoryData) {
            ForumCategory::create($categoryData);
        }

        $this->command->info('Forum categories created successfully!');
    }
}