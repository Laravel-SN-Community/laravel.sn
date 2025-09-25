# Configuration du Pipeline CI

## Vue d'ensemble
Ce pipeline CI utilise GitHub Actions pour automatiser les tests Pest sur toutes les branches du projet Laravel.sn.

## Déclencheurs
Le pipeline s'exécute automatiquement :
- À chaque push sur **toute branche** (`branches: [ '*' ]`)
- À chaque pull request vers **toute branche**

## Workflow du Pipeline

### Job `test` - Tests Pest et Vérifications
1. **Configuration de l'environnement**:
   - Ubuntu latest
   - PHP 8.2 avec toutes les extensions Laravel nécessaires
   - Node.js 18 avec cache NPM

2. **Installation des dépendances**:
   - Installation des packages Composer
   - Installation des dépendances NPM
   - Construction des assets avec Vite

3. **Préparation de l'application**:
   - Copie du fichier `.env.example` vers `.env`
   - Génération de la clé d'application Laravel
   - Configuration des permissions des dossiers
   - Création d'une base de données SQLite pour les tests

4. **Exécution des tests**:
   - **Tests Pest** : `./vendor/bin/pest`
   - **Vérification du style de code** : `./vendor/bin/pint --test`

## Configuration requise

### Composer
Le projet doit avoir Pest installé. Vérifiez que `composer.json` contient :
```json
{
  "require-dev": {
    "pestphp/pest": "^2.0",
    "pestphp/pest-plugin-laravel": "^2.0"
  },
  "config": {
    "allow-plugins": {
      "pestphp/pest-plugin": true
    }
  }
}
```

### Tests
Les tests doivent être dans le dossier `tests/` avec la structure standard Laravel :
- `tests/Feature/` - Tests fonctionnels
- `tests/Unit/` - Tests unitaires

## Utilisation

1. **Push sur n'importe quelle branche** : Les tests s'exécutent automatiquement
2. **Création d'une PR** : Les tests s'exécutent pour valider les changements
3. **Consultation des résultats** : Allez dans l'onglet "Actions" de votre repository GitHub

## Statut des tests

- ✅ **Succès** : Tous les tests passent et le code respecte les standards
- ❌ **Échec** : Au moins un test échoue ou le style de code n'est pas conforme

## Commandes locales

Pour exécuter les mêmes vérifications en local :

```bash
# Tests Pest
./vendor/bin/pest

# Vérification du style de code
./vendor/bin/pint --test

# Correction automatique du style de code
./vendor/bin/pint
```

## Personnalisation

Vous pouvez modifier le workflow selon vos besoins :
- **Branches spécifiques** : Changez `branches: [ '*' ]` vers `branches: [ 'main', 'develop' ]`
- **PHP version** : Modifiez `php-version: '8.2'`
- **Tests avec couverture** : Ajoutez `coverage: xdebug` dans la configuration PHP
- **Notifications** : Ajoutez des étapes pour Slack, Discord, etc.