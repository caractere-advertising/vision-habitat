# Vision Habitat — Thème WordPress (2026)

Objectif : installer le thème, compiler les assets et comprendre le workflow.

## Table des matières

- [Prérequis](#prérequis)
- [Installation](#installation)
- [Scripts disponibles](#scripts-disponibles-packagejson)
- [Structure du thème](#structure-du-thème)
- [Workflow de développement](#workflow-de-développement)
- [Architecture WordPress](#architecture-wordpress-conventions-du-thème)
- [Gestion CSS / SCSS](#gestion-css--scss)
- [Cache-busting](#cache-busting)
- [Dépendances principales](#dépendances-principales)
- [Dépannage](#dépannage)
- [Bonnes pratiques](#bonnes-pratiques)
- [Contact](#contact)

## Prérequis

- WordPress local (LocalWP / MAMP / Docker / etc.)
- Node.js + npm (version LTS recommandée)
- Git
- VS Code

## Installation

1. Cloner le thème dans le dossier `wp-content/themes/`

```bash
cd /path/to/wordpress/wp-content/themes
git clone https://github.com/caractere-advertising/vision-habitat.git vision-habitat
cd vision-habitat
```

2. Installer les dépendances

```bash
npm install
```

3. Lancer le mode développement

```bash
npm run dev
```

4. Activer le thème dans WordPress
   Admin → Apparence → Thèmes → **Vision Habitat**

## Scripts disponibles (package.json)

### Développement

```bash
npm run dev
```

- Watch actif
- Recompile automatique
- Sourcemaps activées
- CSS injecté via JS (rapide pour le dev)

### Production

```bash
npm run build
```

- JS minifié
- CSS extrait automatiquement
- Optimisé pour livraison

## Structure du thème

```
vision-habitat/
│
├── src/                 → Sources JS / SCSS (à modifier)
├── assets/dist/         → Fichiers compilés (générés)
├── functions.php        → Enqueue + setup WordPress
├── style.css            → Header du thème WordPress
├── webpack.config.js    → Configuration Webpack
├── package.json         → Dépendances + scripts
├── node_modules/        → Dépendances (généré)
└── README.md            → Documentation
```

## Workflow de développement

Règle principale :

> On modifie `src/`, jamais `assets/dist/`.

Étapes classiques :

1. Modifier JS ou SCSS dans `src/`
2. Lancer `npm run dev`
3. Vérifier le rendu
4. Avant livraison : `npm run build`

## Architecture WordPress PHP (conventions du thème)

Objectif : garder un thème maintenable et structuré.

### Structure recommandée (mais pas obligatoire)

```
vision-habitat/
├── functions.php
├── includes/
│   ├── setup.php
│   ├── assets.php
│   ├── helpers.php
│   ├── cpt/
│   │   └── cpt-project.php
│   ├── ajax/
│   │   └── search.php
│   └── hooks/
│       └── filters.php
│
├── template-parts/
│   ├── components/
│   └── sections/
│
├── page-template.php
├── src/
```

### Règles importantes

- `functions.php` doit rester minimal (afin de pouvoir le maintenir facilement)
- 1 fichier par CPT
- Logique métier dans `includes/`
- HTML réutilisable dans `template-parts/`
- Préfixer les fonctions avec `vh_`

Exemple d’inclusion propre :

```php
require_once get_template_directory() . '/includes/setup.php';
require_once get_template_directory() . '/includes/assets.php';

foreach (glob(get_template_directory() . '/includes/cpt/*.php') as $file) {
    require_once $file;
}
```

## Gestion CSS / SCSS

- Sass supporté
- Autoprefixer actif
- CSS extrait en production

Le fichier `src/style.js` doit importer le SCSS principal :

```js
import "./scss/main.scss";
```

## Gestion images et fonts

Webpack copie automatiquement les images et fonts importées vers :

```
assets/dist/media/
```

Exemple SCSS :

```scss
.hero {
  background-image: url("../images/hero.jpg");
}
```

Exemple JS :

```js
import heroImg from "./images/hero.jpg";
```

## Cache-busting

Le thème utilise `filemtime()` dans `functions.php`.

À chaque build :

- WordPress ajoute `?ver=TIMESTAMP`
- Le navigateur recharge automatiquement le fichier
- Aucun hash de filename nécessaire

## Dépendances principales

- Swiper → [https://swiperjs.com/](https://swiperjs.com/)
- GSAP → [https://gsap.com/docs/v3/](https://gsap.com/docs/v3/)
- Isotope → [https://isotope.metafizzy.co/](https://isotope.metafizzy.co/)
- fslightbox → [https://fslightbox.com/javascript/](https://fslightbox.com/javascript/)
- Lodash -> [https://lodash.com/docs/4.17.23](https://lodash.com/docs/4.17.23)
- in-view → [https://github.com/camwiegert/in-view](https://github.com/camwiegert/in-view)

## Dépannage

### Les changements ne s’affichent pas

- Vérifier que `npm run dev` tourne
- Relancer `npm run build`
- Vider cache navigateur
- Vérifier que `assets/dist/` contient les fichiers

### `npm install` échoue

```bash
rm -rf node_modules package-lock.json
npm install
```

### Les assets ne se chargent pas

- Vérifier les chemins dans `functions.php`
- Vérifier que les bundles existent

## Bonnes pratiques

- Ne jamais modifier `assets/dist/`
- Commits courts et explicites
- Séparer logique JS et templates PHP
- Tester en responsive
- Vérifier la console navigateur avant livraison

## Contact

Caractere Advertising & Communication
Repo maintenu par : Claudia Capuana & Benoit Londero
