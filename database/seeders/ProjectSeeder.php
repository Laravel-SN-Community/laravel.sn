<?php

namespace Database\Seeders;

use App\Enums\ProjectStatus;
use App\Enums\UserRole;
use App\Models\Project;
use App\Models\ProjectReview;
use App\Models\ProjectVote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some test users if they don't exist
        $admin = User::firstOrCreate(
            ['email' => 'admin@laravel.sn'],
            [
                'name' => 'Admin User',
                'email' => 'admin@laravel.sn',
                'role' => UserRole::ADMIN,
                'password' => bcrypt('password'),
            ]
        );

        $user1 = User::firstOrCreate(
            ['email' => 'john@laravel.sn'],
            [
                'name' => 'John Doe',
                'email' => 'john@laravel.sn',
                'role' => UserRole::USER,
                'password' => bcrypt('password'),
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'jane@laravel.sn'],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@laravel.sn',
                'role' => UserRole::USER,
                'password' => bcrypt('password'),
            ]
        );

        $user3 = User::firstOrCreate(
            ['email' => 'bob@laravel.sn'],
            [
                'name' => 'Bob Wilson',
                'email' => 'bob@laravel.sn',
                'role' => UserRole::USER,
                'password' => bcrypt('password'),
            ]
        );

        // Project 1: Laravel E-commerce Platform
        $project1 = Project::create([
            'user_id' => $user1->id,
            'title' => 'Laravel E-commerce Platform',
            'slug' => Str::slug('Laravel E-commerce Platform'),
            'description' => "# Laravel E-commerce Platform

Une plateforme e-commerce complète construite avec Laravel 12 et Livewire 3.

## Fonctionnalités principales

- 🛒 Panier d'achat en temps réel avec Livewire
- 💳 Intégration de paiement (Stripe, PayPal)
- 📦 Gestion des commandes et des stocks
- 👥 Espace client avec historique des commandes
- 🎨 Interface admin avec Filament
- 📧 Notifications par email
- 🔍 Recherche avancée avec filtres
- ⭐ Système d'avis et de notes

## Technologies utilisées

- **Backend**: Laravel 12, Livewire 3
- **Frontend**: TailwindCSS, Alpine.js
- **Base de données**: MySQL
- **Admin**: Filament v4
- **Paiement**: Stripe API

## Installation

```bash
composer install
npm install
php artisan migrate --seed
php artisan serve
```

## Captures d'écran

Le projet inclut une interface moderne et responsive avec un design épuré.",
            'github_url' => 'https://github.com/johndoe/laravel-ecommerce',
            'demo_url' => 'https://demo-ecommerce.laravel.sn',
            'status' => ProjectStatus::Approved,
            'votes_count' => 15,
            'average_rating' => 4.5,
            'approved_at' => now()->subDays(7),
        ]);

        // Project 2: Laravel Blog CMS
        $project2 = Project::create([
            'user_id' => $user2->id,
            'title' => 'Laravel Blog CMS',
            'slug' => Str::slug('Laravel Blog CMS'),
            'description' => "# Laravel Blog CMS

Un système de gestion de contenu (CMS) moderne pour créer et gérer des blogs professionnels.

## Fonctionnalités

- ✍️ Éditeur Markdown avec prévisualisation en direct
- 📝 Gestion des articles et catégories
- 🏷️ Système de tags
- 💬 Commentaires avec modération
- 👤 Gestion multi-utilisateurs avec rôles
- 📊 Statistiques et analytics
- 🔍 SEO optimisé
- 📱 Responsive design

## Stack technique

- Laravel 12
- Livewire 3 pour l'interactivité
- Filament pour l'administration
- TailwindCSS pour le design
- Spatie Media Library pour les images
- League CommonMark pour le Markdown

## Points forts

Ce CMS se distingue par sa simplicité d'utilisation et ses performances. L'éditeur Markdown intégré permet une rédaction fluide avec prévisualisation instantanée.

## Configuration

```bash
git clone https://github.com/janesmith/laravel-blog-cms
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Parfait pour les développeurs qui veulent un blog simple mais puissant!",
            'github_url' => 'https://github.com/janesmith/laravel-blog-cms',
            'demo_url' => 'https://demo-blog.laravel.sn',
            'status' => ProjectStatus::Approved,
            'votes_count' => 23,
            'average_rating' => 4.8,
            'approved_at' => now()->subDays(3),
        ]);

        // Add votes for project 1
        ProjectVote::create(['user_id' => $user2->id, 'project_id' => $project1->id]);
        ProjectVote::create(['user_id' => $user3->id, 'project_id' => $project1->id]);
        ProjectVote::create(['user_id' => $admin->id, 'project_id' => $project1->id]);

        // Add votes for project 2
        ProjectVote::create(['user_id' => $user1->id, 'project_id' => $project2->id]);
        ProjectVote::create(['user_id' => $user3->id, 'project_id' => $project2->id]);
        ProjectVote::create(['user_id' => $admin->id, 'project_id' => $project2->id]);

        // Add reviews for project 1
        ProjectReview::create([
            'user_id' => $user2->id,
            'project_id' => $project1->id,
            'rating' => 5,
            'comment' => 'Excellent projet! Le code est très bien structuré et la documentation est claire. Je l\'utilise pour mon propre site e-commerce.',
        ]);

        ProjectReview::create([
            'user_id' => $user3->id,
            'project_id' => $project1->id,
            'rating' => 4,
            'comment' => 'Très bon projet, facile à installer et à personnaliser. Quelques petites améliorations à apporter sur l\'interface mobile.',
        ]);

        // Add reviews for project 2
        ProjectReview::create([
            'user_id' => $user1->id,
            'project_id' => $project2->id,
            'rating' => 5,
            'comment' => 'Le meilleur CMS Laravel que j\'ai utilisé! L\'éditeur Markdown est génial et l\'admin Filament est très intuitive.',
        ]);

        ProjectReview::create([
            'user_id' => $user3->id,
            'project_id' => $project2->id,
            'rating' => 5,
            'comment' => 'Projet de qualité professionnelle. Parfait pour démarrer un blog rapidement. Bravo!',
        ]);

        ProjectReview::create([
            'user_id' => $admin->id,
            'project_id' => $project2->id,
            'rating' => 4,
            'comment' => 'Très bonne base pour un blog. Le système de catégories et de tags est bien pensé.',
        ]);

        $this->command->info('✅ 2 projets créés avec succès!');
        $this->command->info('✅ Votes et avis ajoutés!');
        $this->command->info('');
        $this->command->info('Utilisateurs de test créés:');
        $this->command->info("- Admin: admin@laravel.sn / password");
        $this->command->info("- User 1: john@laravel.sn / password");
        $this->command->info("- User 2: jane@laravel.sn / password");
        $this->command->info("- User 3: bob@laravel.sn / password");
    }
}
