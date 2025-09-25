# Configuration du Pipeline CI/CD

## Vue d'ensemble
Ce pipeline CI/CD utilise GitHub Actions pour automatiser les tests, la sécurité et le déploiement de Laravel.sn sur DigitalOcean via Laravel Forge.

## Secrets GitHub requis

Pour que le pipeline fonctionne correctement, vous devez configurer les secrets suivants dans votre repository GitHub (`Settings > Secrets and variables > Actions`):

### Secrets Laravel Forge
- `FORGE_API_TOKEN`: Token API de Laravel Forge (généré dans Forge > Account > API)
- `FORGE_PRODUCTION_SERVER_ID`: ID du serveur de production dans Forge
- `FORGE_PRODUCTION_SITE_ID`: ID du site de production dans Forge
- `FORGE_STAGING_SERVER_ID`: ID du serveur de staging dans Forge (optionnel)
- `FORGE_STAGING_SITE_ID`: ID du site de staging dans Forge (optionnel)

### Comment obtenir les IDs Forge

1. **Token API Forge**:
   - Connectez-vous à Laravel Forge
   - Allez dans `Account > API`
   - Créez un nouveau token API

2. **Server ID et Site ID**:
   - Dans l'URL de votre site Forge: `https://forge.laravel.com/servers/{SERVER_ID}/sites/{SITE_ID}`
   - Ou utilisez l'API Forge: `curl -H "Authorization: Bearer YOUR_TOKEN" https://forge.laravel.com/api/v1/servers`

## Workflow du Pipeline

### 1. Job `test`
- Se déclenche sur push vers `main` et `develop`, et sur les pull requests
- Configure PHP 8.2 avec toutes les extensions nécessaires
- Installe les dépendances Composer et NPM
- Exécute les tests PHPUnit
- Vérifie le style de code avec Laravel Pint
- Construit les assets avec Vite

### 2. Job `security`
- Exécute un audit de sécurité avec `composer audit`
- Vérifie les vulnérabilités connues dans les dépendances

### 3. Job `deploy-staging`
- Se déclenche uniquement sur push vers `develop`
- Utilise l'API Laravel Forge pour déclencher un déploiement staging

### 4. Job `deploy-production`
- Se déclenche uniquement sur push vers `main`
- Utilise l'API Laravel Forge pour déclencher un déploiement production
- Attend la fin du déploiement et affiche les logs

### 5. Job `notify`
- Notifie le statut du déploiement

## Configuration Laravel Forge

### Script de déploiement Forge recommandé

```bash
cd /home/forge/laravel.sn

git pull origin $FORGE_SITE_BRANCH

$FORGE_COMPOSER install --no-interaction --prefer-dist --optimize-autoloader --no-dev

( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service $FORGE_PHP_FPM reload ) 9>/tmp/fpmlock

if [ -f artisan ]; then
    $FORGE_PHP artisan migrate --force
    $FORGE_PHP artisan config:cache
    $FORGE_PHP artisan route:cache
    $FORGE_PHP artisan view:cache
    $FORGE_PHP artisan queue:restart
fi

npm ci --production=false
npm run build
```

### Variables d'environnement Forge

Assurez-vous que ces variables sont configurées dans Forge:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://laravel.sn`
- Configuration de base de données
- Configuration de cache (Redis recommandé)
- Configuration de queue

## Utilisation

1. **Développement**: Poussez vers `develop` pour déclencher les tests et déploiement staging
2. **Production**: Poussez vers `main` pour déclencher les tests et déploiement production
3. **Pull Requests**: Les tests s'exécutent automatiquement sur toutes les PR vers `main`

## Personnalisation

Vous pouvez personnaliser le workflow selon vos besoins:
- Modifier les branches de déclenchement
- Ajouter des notifications (Slack, Discord, etc.)
- Ajouter des tests supplémentaires (analyse statique, tests E2E)
- Configurer des environnements de déploiement supplémentaires

## Dépannage

- Vérifiez que tous les secrets sont configurés correctement
- Consultez les logs GitHub Actions pour identifier les erreurs
- Vérifiez la configuration du script de déploiement dans Laravel Forge
- Assurez-vous que les permissions API Forge sont correctement configurées