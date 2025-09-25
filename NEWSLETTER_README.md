# Système de Newsletter 

Ce document décrit l'implémentation complète du système de souscription à la newsletter pour le site Laravel Sénégal.



## Architecture

### Backend
- **Modèle** : `NewsletterSubscription` - Gestion des abonnements en base de données
- **Contrôleur** : `NewsletterController` - API REST pour les opérations CRUD
- **Composant Livewire** : `WelcomePage` - Interface utilisateur intégrée
- **Package** : `spatie/laravel-newsletter` - Intégration services externes
- **Notifications** : `masmerise/livewire-toaster` - Toast notifications

### Base de données
Table `newsletter_subscriptions` :
```sql
- id (bigint, primary key)
- email (string, unique)
- status (string, default: 'subscribed')
- subscribed_at (timestamp, nullable)
- unsubscribed_at (timestamp, nullable)
- list_name (string, default: 'subscribers')
- tags (json, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

## Installation et Configuration

### 1. Packages installés
```bash
composer require spatie/laravel-newsletter
composer require masmerise/livewire-toaster
```

### 2. Configuration
```bash
php artisan vendor:publish --tag=newsletter-config
php artisan vendor:publish --tag=toaster-config
```

### 3. Migration de base de données
```bash
php artisan migrate
```

### 4. Configuration des variables d'environnement
```env
# Newsletter Configuration
NEWSLETTER_DRIVER=log  # ou 'mailcoach' en production
NEWSLETTER_API_KEY=your_api_key
NEWSLETTER_ENDPOINT=your_endpoint
NEWSLETTER_LIST_ID=your_list_id
```

## Fonctionnalités

### Interface Utilisateur
- **Formulaire d'abonnement** intégré dans la page d'accueil
- **Notifications toast** avec Livewire Toaster
- **Validation en temps réel** des adresses email
- **Gestion des doublons** automatique
- **États de chargement** pour une meilleure UX

### API REST
Endpoints disponibles :

#### POST `/api/newsletter/subscribe`
Abonne un utilisateur à la newsletter.
```json
{
  "email": "user@example.com",
  "list_name": "subscribers"
}
```

**Réponse succès (201) :**
```json
{
  "success": true,
  "message": "Merci pour votre abonnement !",
  "data": {
    "id": 1,
    "email": "user@example.com",
    "status": "subscribed",
    "subscribed_at": "2025-09-25T15:30:00.000000Z",
    "list_name": "subscribers"
  }
}
```

#### POST `/api/newsletter/unsubscribe`
Désabonne un utilisateur de la newsletter.
```json
{
  "email": "user@example.com",
  "list_name": "subscribers"
}
```

#### GET `/api/newsletter/status`
Vérifie le statut d'abonnement d'un email.
```
GET /api/newsletter/status?email=user@example.com&list_name=subscribers
```

## Code Principal

### Modèle NewsletterSubscription
```php
class NewsletterSubscription extends Model
{
    protected $fillable = [
        'email', 'status', 'subscribed_at',
        'unsubscribed_at', 'list_name', 'tags'
    ];

    public function isSubscribed(): bool
    {
        return $this->status === 'subscribed';
    }

    public function subscribe() { /* ... */ }
    public function unsubscribe() { /* ... */ }
}
```

### Composant Livewire (WelcomePage)
```php
use Masmerise\Toaster\Toaster;

public function subscribe()
{
    $this->validate();

    // Créer l'abonnement
    $subscription = NewsletterSubscription::updateOrCreate(...);

    // Synchroniser avec le service externe
    Newsletter::subscribeOrUpdate($this->email, [], $this->list_name);

    // Afficher la notification
    Toaster::success('Merci pour votre abonnement !');

    $this->reset('email');
}
```

### Interface (Blade Template)
```blade
<form wire:submit="subscribe" class="space-y-4">
    <div>
        <input
            type="email"
            wire:model="email"
            placeholder="Votre adresse email"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
            required
        >
        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button
        type="submit"
        class="w-full bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors"
        wire:loading.attr="disabled"
    >
        <span wire:loading.remove>S'abonner à la newsletter</span>
        <span wire:loading>Inscription en cours...</span>
    </button>
</form>
```

## Configuration Avancée

### Configuration Toaster (`config/toaster.php`)
```php
return [
    'alignment' => 'top',      // Position verticale
    'position' => 'right',     // Position horizontale
    'duration' => 3000,        // Durée d'affichage (ms)
    'closeable' => true,       // Bouton de fermeture
    'replace' => false,        // Remplacer les toasts similaires
];
```

### Configuration Newsletter (`config/newsletter.php`)
```php
return [
    'driver' => env('NEWSLETTER_DRIVER', 'log'),
    'driver_arguments' => [
        'api_key' => env('NEWSLETTER_API_KEY'),
        'endpoint' => env('NEWSLETTER_ENDPOINT'),
    ],
    'default_list_name' => 'subscribers',
    'lists' => [
        'subscribers' => [
            'id' => env('NEWSLETTER_LIST_ID'),
        ],
    ],
];
```

## Tests

### Test API avec cURL
```bash
# Test d'abonnement
curl -X POST http://localhost:8000/api/newsletter/subscribe \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"test@example.com"}'

# Test de statut
curl -X GET "http://localhost:8000/api/newsletter/status?email=test@example.com"

# Test de désabonnement
curl -X POST http://localhost:8000/api/newsletter/unsubscribe \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com"}'
```

### Test Interface Web
1. Ouvrir `http://localhost:8000`
2. Aller à la section Newsletter
3. Saisir une adresse email
4. Cliquer sur "S'abonner"
5. Vérifier l'apparition du toast de confirmation

## Sécurité

### Validation des données
- **Email requis** et format validé
- **Unicité** des abonnements par liste
- **Protection CSRF** avec Livewire
- **Sanitisation** des entrées utilisateur

### Gestion des erreurs
- **Try-catch** complets dans le contrôleur
- **Logging** des erreurs en mode debug
- **Messages d'erreur** localisés en français
- **Fallback** en cas d'échec du service externe

## Monitoring

### Logs
Les erreurs sont enregistrées dans `storage/logs/laravel.log` :
```php
logger()->error('Newsletter subscription error: ' . $e->getMessage());
```

### Base de données
Toutes les opérations sont trackées avec :
- Timestamps de création/modification
- Statut des abonnements
- Historique des abonnements/désabonnements

## Production

### Passage en production
1. **Configurer le service email** (Mailcoach/MailChimp) :
```env
NEWSLETTER_DRIVER=mailcoach
NEWSLETTER_API_KEY=your_production_api_key
NEWSLETTER_ENDPOINT=https://your-mailcoach-instance.com
NEWSLETTER_LIST_ID=your_production_list_id
```

2. **Optimiser les performances** :
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. **Compiler les assets** :
```bash
npm run build
```

## Maintenance

### Commandes utiles
```bash
# Voir les abonnements récents
php artisan tinker
>>> NewsletterSubscription::latest()->limit(10)->get();

# Nettoyer les abonnements expirés
php artisan make:command CleanupNewsletterSubscriptions

# Synchroniser avec le service externe
php artisan make:command SyncNewsletterSubscriptions
```

