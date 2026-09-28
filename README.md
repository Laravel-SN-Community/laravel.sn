<div align="center">

<img src="public/images/logo.svg" alt="Laravel Sénégal" width="120" />

# Laravel Sénégal

Le portail de la communauté des développeurs PHP & Laravel au Sénégal.

[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4)](https://php.net)

[Site](https://laravel.sn) · [WhatsApp](https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx) · [Contribuer](.github/CONTRIBUTING.md)

</div>

---

## À propos

Ce dépôt contient le code source de [laravel.sn](https://laravel.sn), le portail de la communauté Laravel Sénégal.

Le projet est **open source** et entretenu par la communauté. Toute contribution est la bienvenue, qu'il s'agisse de code, de design, de documentation ou de signalement de bugs.

## Stack

- **Backend** : Laravel 13, PHP 8.4
- **Frontend** : Inertia.js 3, React 19, TypeScript
- **Styling** : Tailwind CSS v4, shadcn/ui
- **Base de données** : SQLite (dev), PostgreSQL (production)
- **Cache / Files** : database (dev), Redis (production)
- **Recherche** : Laravel Scout — driver `collection` (dev), Typesense (production)
- **Tests** : Pest 4
- **CI/CD** : GitHub Actions, Laravel Cloud

## Pré-requis

- **PHP 8.4+** avec les extensions `pdo_sqlite`, `sqlite3`, `mbstring`, `intl`, `gd` (avec support WebP), `zip`, `bcmath`, `exif`, `pcntl`
- **Composer 2**
- **Node.js 22+** et **npm**

Aucun service externe n'est nécessaire en dev : SQLite fait office de base de données, la recherche utilise le driver `collection` de Scout, et les emails sont écrits dans les logs.

## Installation

```bash
git clone git@github.com:laravel-sn/laravel.sn.git
cd laravel.sn
composer run setup
```

Lance le serveur de développement :

```bash
composer run dev
```

Ouvre [http://localhost:8000](http://localhost:8000).

Compte de test créé par le seeder :
- Email : `admin@laravel.sn`
- Mot de passe : `password`

Les emails envoyés par l'application sont écrits dans `storage/logs/laravel.log` (`MAIL_MAILER=log`).

## Commandes utiles

| Commande | Description |
|----------|-------------|
| `composer run setup` | Premier démarrage — install, migrate:fresh, seed, build |
| `composer run dev` | Lance le serveur de dev (Laravel + Vite + queue + logs) |
| `php artisan migrate:fresh --seeder=DevSeeder` | Réinitialise la base de données |
| `composer run ci:check` | Lance la suite CI complète (pint, phpstan, rector, eslint, prettier, tsc, tests) |

## Tests et qualité du code

```bash
# Suite CI complète (pint, phpstan, rector, eslint, prettier, tsc, tests)
composer run ci:check

# Un test spécifique
php artisan test --compact --filter=NomDuTest
```

Pour lancer les outils individuellement :

```bash
./vendor/bin/pint               # Formatage PHP
./vendor/bin/phpstan analyse    # Analyse statique
./vendor/bin/rector process     # Refactoring automatique
npm run lint                    # Lint TypeScript
npm run types:check             # Type-check TypeScript
```

## Parité production (optionnel)

La production tourne sur PostgreSQL, Redis et Typesense. Si tu travailles sur une fonctionnalité sensible au moteur de base de données ou à la recherche, un bloc commenté en bas de `.env.example` documente la configuration locale équivalente.

## Structure du projet

```
laravel.sn/
├── app/                       # Code applicatif Laravel
│   ├── Actions/               # Logique métier réutilisable
│   ├── Concerns/              # Traits partagés
│   ├── Enums/                 # Enums PHP 8
│   ├── Http/
│   │   ├── Controllers/       # Controllers Inertia
│   │   ├── Middleware/
│   │   └── Requests/          # Form requests
│   ├── Models/                # Models Eloquent
│   ├── Policies/              # Policies d'autorisation
│   ├── Providers/
│   └── Support/               # Classes utilitaires
├── resources/
│   ├── css/                   # Tailwind v4 + tokens
│   └── js/
│       ├── actions/           # Wayfinder (généré)
│       ├── components/        # Composants React
│       │   ├── site/          # Composants métier
│       │   └── ui/            # shadcn/ui customisés
│       ├── hooks/             # React hooks
│       ├── layouts/           # Layouts Inertia
│       ├── lib/               # Utilitaires JS
│       ├── pages/             # Pages Inertia
│       ├── routes/            # Wayfinder routes (généré)
│       ├── types/             # Types TypeScript
│       └── wayfinder/         # Config Wayfinder
├── routes/
│   ├── web.php                # Routes principales
│   └── settings.php           # Routes paramètres
└── tests/
    ├── Feature/               # Tests fonctionnels
    └── Unit/                  # Tests unitaires
```

## Contribuer

Les contributions sont chaleureusement accueillies. Avant de proposer une modification, lis [CONTRIBUTING.md](.github/CONTRIBUTING.md) et le [code de conduite](.github/CODE_OF_CONDUCT.md).

Pour signaler un bug ou proposer une fonctionnalité, ouvre une [issue](https://github.com/laravel-sn/laravel.sn/issues/new/choose).

Pour les questions générales, rejoins la [communauté WhatsApp](https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx).

## Sécurité

Si tu découvres une faille de sécurité, **ne crée pas d'issue publique**. Envoie un email à `security@laravel.sn`. Plus de détails dans [SECURITY.md](SECURITY.md).

## Sponsors

Merci aux entreprises qui soutiennent la communauté. Pour devenir sponsor, contacte `partenaires@laravel.sn` ou consulte [/sponsors](https://laravel-senegal.com/sponsors).

## Licence

[MIT](LICENSE) © 2021–2026 Laravel Sénégal et ses contributeurs.

---
