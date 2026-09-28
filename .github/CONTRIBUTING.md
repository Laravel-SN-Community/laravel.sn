# Contribuer à Laravel Sénégal

Merci de l'intérêt que tu portes au projet ! Ce guide explique comment contribuer efficacement au code, à la documentation et au contenu de la plateforme.

## Table des matières

- [Code de conduite](#code-de-conduite)
- [Comment contribuer](#comment-contribuer)
- [Setup du projet en local](#setup-du-projet-en-local)
- [Workflow de développement](#workflow-de-développement)
- [Convention de commits](#convention-de-commits)
- [Convention de branches](#convention-de-branches)
- [Pull Requests](#pull-requests)
- [Tests](#tests)
- [Style de code](#style-de-code)
- [Signaler un bug](#signaler-un-bug)
- [Proposer une fonctionnalité](#proposer-une-fonctionnalité)
- [Documentation et traductions](#documentation-et-traductions)

## Code de conduite

Toute participation à ce projet est régie par notre [Code de conduite](CODE_OF_CONDUCT.md). En contribuant, tu acceptes de t'y conformer.

## Comment contribuer

Plusieurs façons d'aider la communauté :

- **Code** : corriger des bugs, ajouter des fonctionnalités, améliorer l'existant
- **Design** : proposer des améliorations UI/UX via des issues ou des Figma
- **Documentation** : améliorer le README, CONTRIBUTING, les guides
- **Articles** : écrire des articles techniques pour la plateforme (cf. notre [guide d'auteur](https://laravel-senegal.com/contribuer/articles))
- **Tests** : ajouter des tests manquants, améliorer la couverture
- **Bugs** : signaler des bugs avec des reproductions claires
- **Traductions** : aider à maintenir la version anglaise du site

Si c'est ta première contribution open source, regarde les issues taguées [`good-first-issue`](https://github.com/laravel-sn/laravel.sn/issues?q=is%3Aopen+is%3Aissue+label%3Agood-first-issue). Elles sont pensées pour être abordables.

## Setup du projet en local

Voir le [README](../README.md#installation) pour les instructions complètes (pré-requis : PHP 8.4+, Composer 2, Node 22+ — aucun service externe, la base de données est SQLite). En résumé :

```bash
git clone https://github.com/laravel-sn/laravel.sn.git
cd laravel.sn
composer run setup  # install, .env, clé, migrations + seed, build
composer run dev    # serveur de dev (Laravel + Vite + queue + logs)
```

## Workflow de développement

### 1. Trouve ou ouvre une issue

Avant d'écrire du code, **assure-toi qu'il existe une issue** correspondant à ton travail :

- **Bug** : ouvre une issue de type `bug` si elle n'existe pas
- **Fonctionnalité** : ouvre une issue de type `feature` et **attends qu'elle soit validée** avant de coder. Cela évite que tu travailles plusieurs heures sur quelque chose qui ne sera pas mergé.
- **Petit fix évident** (typo, doc) : tu peux ouvrir directement une PR sans issue.

### 2. Fork et clone

Si tu n'es pas mainteneur, fork le repo, puis clone ton fork :

```bash
git clone git@github.com:TON-USERNAME/laravel.sn.git
cd laravel.sn
git remote add upstream https://github.com/laravel-sn/laravel.sn.git
```

### 3. Crée une branche

Toujours partir de `main` à jour :

```bash
git checkout main
git pull upstream main
git checkout -b feat/podcast-page
```

Voir [Convention de branches](#convention-de-branches) pour le nommage.

### 4. Code, commit, push

```bash
# code, code, code...

# vérifie que la qualité est bonne
npm run check
php artisan test

# commit
git add .
git commit -m "feat(podcast): add episode list page"

# push sur ton fork
git push origin feat/podcast-page
```

### 5. Ouvre une Pull Request

Sur GitHub, ouvre une PR depuis ta branche vers `main` du repo principal. Voir [Pull Requests](#pull-requests) pour les détails.

## Convention de commits

Nous utilisons [Conventional Commits](https://www.conventionalcommits.org/fr/v1.0.0/). Format :

```
<type>(<scope>): <description courte en minuscules>

[corps optionnel]

[footer optionnel]
```

### Types autorisés

- `feat` — nouvelle fonctionnalité
- `fix` — correction de bug
- `docs` — documentation uniquement
- `style` — formatage, espaces, virgules (pas de changement de code)
- `refactor` — refactoring sans nouvelle feature ni fix
- `perf` — amélioration de performance
- `test` — ajout ou correction de tests
- `chore` — maintenance, deps, configs
- `build` — changements liés au build
- `ci` — changements de configuration CI

### Scopes courants

- `articles`, `events`, `podcast`, `resources`, `sponsors`
- `auth`, `members`, `dashboard`
- `ui`, `layout`, `theme`
- `deps`, `config`, `db`

### Exemples

```
feat(articles): add tag filtering on index page
fix(auth): correct password reset token expiration
docs: update CONTRIBUTING with branch naming convention
chore(deps): bump tailwindcss to 4.0.5
refactor(events): extract date formatting to utility
```

### Breaking changes

Pour signaler un changement cassant, utilise un `!` :

```
feat(api)!: remove v1 endpoints
```

Ou un footer :

```
feat(api): redesign articles endpoint

BREAKING CHANGE: the /api/articles endpoint now returns paginated results.
Update your clients to handle the new response shape.
```

## Convention de branches

```
<type>/<description-courte-en-kebab-case>
```

Types autorisés (mêmes que pour les commits) :

- `feat/podcast-page`
- `fix/article-slug-encoding`
- `docs/contributing-update`
- `refactor/event-card-component`
- `chore/upgrade-tailwind`

Règles :

- En minuscules, séparés par des tirets
- Pas d'espaces, pas de caractères spéciaux
- Concis : 4-6 mots max après le slash
- Une seule fonctionnalité ou correction par branche

## Pull Requests

### Avant d'ouvrir la PR

Checklist :

- [ ] Le code respecte le style ([voir plus bas](#style-de-code))
- [ ] Les tests passent (`php artisan test` et `npm run check`)
- [ ] J'ai ajouté des tests pour les nouvelles fonctionnalités ou corrections
- [ ] J'ai mis à jour la documentation si nécessaire
- [ ] Mon titre de PR suit Conventional Commits
- [ ] La PR fait référence à une issue (`Closes #42` dans la description)

### Le titre de la PR

**Critique** : le titre de la PR devient le message de commit final dans `main` (mode squash). Il doit donc :

- Suivre Conventional Commits
- Être descriptif et clair
- Commencer par une minuscule après le `:`

✅ Bon : `feat(podcast): add episode player with progress bar`
❌ Mauvais : `Update podcast page` ou `feat: stuff`

### Description de la PR

Le template de PR te guidera. En résumé :

- Décris **ce que ça fait** et **pourquoi**
- Lie l'issue avec `Closes #42` ou `Fixes #42`
- Si UI : mets une capture ou un GIF
- Mentionne les breaking changes éventuels
- Liste les points d'attention pour le reviewer

### Taille de la PR

Garde tes PRs **focused et raisonnablement petites**. Une PR qui touche 50 fichiers est presque impossible à reviewer correctement.

Cible : **moins de 400 lignes modifiées**. Si tu dois faire plus, découpe en plusieurs PRs successives.

### Review et merge

- Au moins **un mainteneur** doit approuver
- La CI doit être verte
- Les conversations doivent être résolues
- Le merge se fait en **squash uniquement** (configuration du repo)
- Les branches sont supprimées automatiquement après merge

## Tests

### Couverture attendue

- **Toute nouvelle feature** : au moins un test feature
- **Tout bug fix** : un test de régression qui aurait échoué avant le fix
- **Composant React complexe** : test de rendu avec Testing Library (à introduire plus tard)

### Lancer les tests

```bash
# Tous les tests
php artisan test

# En parallèle
./vendor/bin/pest --parallel

# Un fichier
./vendor/bin/pest tests/Feature/HomeTest.php

# Un test précis
./vendor/bin/pest --filter "renders the home page"

# Avec coverage
./vendor/bin/pest --coverage --min=80
```

### Bonnes pratiques de tests

- Un test = un comportement
- Nom descriptif : `it('shows the latest 3 published articles')`
- Utilise les factories, pas de données en dur
- Reset la DB entre les tests (`RefreshDatabase` est dans `Pest.php`)
- Évite de tester l'implémentation, teste le comportement

## Style de code

### PHP

- Suit le preset [Laravel Pint](https://laravel.com/docs/pint)
- Strict types obligatoires : `declare(strict_types=1);` en haut de chaque fichier
- Type hints partout (paramètres, retours, propriétés)
- PHPStan level 6 minimum (`./vendor/bin/phpstan analyse`)
- Classes finales par défaut (`final class`)
- Pas de Facades dans la logique métier (sauf `auth()`, `route()`, `now()`)

### TypeScript / React

- TypeScript strict (déjà configuré)
- Pas de `any`, sauf justification commentée
- Composants fonctionnels uniquement
- Props typées explicitement avec `interface`
- Hooks React : suivre les règles d'ESLint
- Imports triés (Prettier le fait automatiquement)

### CSS / Tailwind

- Utilitaires Tailwind d'abord, CSS custom seulement si nécessaire
- Pas de `style={{}}` inline sauf valeurs dynamiques
- Variables de couleur via tokens Tailwind v4 (`bg-primary`, `text-fg`)
- Mobile-first : commence par les classes mobiles, ajoute les `md:`, `lg:` ensuite

### Lint et format

Avant chaque commit :

```bash
# Auto-format
./vendor/bin/pint
npm run format

# Lint
npm run lint
./vendor/bin/phpstan analyse

# Tout d'un coup
npm run check
```

## Signaler un bug

Avant d'ouvrir une issue :

1. **Cherche** dans les issues existantes (ouvertes et fermées)
2. **Reproduis** le bug sur la dernière version de `main`
3. **Réduis** la reproduction au minimum

Puis ouvre une issue avec le template `Bug report` et fournis :

- Une description claire du comportement attendu vs observé
- Étapes pour reproduire (numérotées)
- Environnement : OS, navigateur, version PHP, version Node
- Captures d'écran ou logs si pertinent

## Proposer une fonctionnalité

1. **Cherche** dans les issues existantes pour éviter les doublons
2. **Ouvre** une issue avec le template `Feature request`
3. **Attends** la validation d'un mainteneur avant de commencer à coder

Décris clairement :

- Le problème que ça résout (pas la solution)
- Pour qui c'est utile
- Une proposition de solution si tu en as une
- Les alternatives considérées

## Documentation et traductions

La documentation principale vit dans :

- `README.md` — vue d'ensemble du projet
- `.github/CONTRIBUTING.md` — ce fichier
- `.github/CODE_OF_CONDUCT.md` — règles communautaires
- `docs/` — documentation technique approfondie (à venir)

Les contenus du site (articles, pages institutionnelles) sont gérés via l'admin et sortent du périmètre de ce dépôt.

Si tu veux contribuer à la version anglaise du site, regarde les issues taguées `i18n`.

## Questions

Si quelque chose n'est pas clair :

- Rejoins la [communauté WhatsApp](https://chat.whatsapp.com/JwITxALLv0uJIGNu7AsVnx)
- Écris à `contact@laravel.sn`

---

Merci de contribuer à faire grandir la communauté Laravel au Sénégal 🇸🇳
