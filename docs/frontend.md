# Frontend and UI Layer

The frontend layer is built without frontend frameworks.

Technologies used:

- Smarty templates
- SCSS
- jQuery

---

## Frontend Architecture

Frontend rendering is fully server-side.

Flow:

```text
Controller
→ Smarty template
→ HTML
→ Browser
```

JavaScript is used only for UI interactions.

---

## Templates Structure

Templates are stored in:

```
templates/
```

Structure:

```
templates/
├── layouts/
├── partials/
├── home/
├── category/
├── post/
└── error/
```

---

## Base Layout

Main layout:

```
templates/layouts/base.tpl
```
Responsibilities:

* common HTML structure
* meta tags
* CSS/JS includes
* page wrapper
* shared layout blocks

All pages extend the base layout:

```smarty
{extends file="layouts/base.tpl"}
```

---

## Partials

Reusable template parts are stored in:

```templates/partials/```

Current partials:

* header.tpl
* footer.tpl

---

## Header Navigation

Header automatically displays categories.

Data source:

```php
navCategories
```

Provided globally through:

`
App\Controller\BaseController
`

---

## Footer

Footer is always pinned to the bottom of the page.

Implementation:

```css
body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

main.page {
    flex: 1;
}
```

---

## SCSS Structure

SCSS files are stored in:

```assets/scss/```

Structure:

```text
assets/scss/
├── app.scss
│
├── base/
│   ├── _variables.scss
│   ├── _reset.scss
│   ├── _typography.scss
│   └── _responsive.scss
│
├── layout/
│   ├── _container.scss
│   ├── _header.scss
│   └── _footer.scss
│
├── components/
│   ├── _button.scss
│   ├── _post-card.scss
│   ├── _pagination.scss
│   ├── _filter-bar.scss
│   └── _hero-slider.scss
│
└── pages/
    ├── _home.scss
    ├── _category.scss
    ├── _post.scss
    └── _error.scss
```

---

## SCSS Philosophy

Styles are separated by responsibility:

* base → global styles
* layout → page structure
* components → reusable UI blocks
* pages → page-specific styles

---

## Main SCSS Entry

Main SCSS file:

`assets/scss/app.scss`

This file imports all partials.

---

## CSS Build Output

Compiled CSS output:

`public/assets/css/app.css`

Included in layout:

```html
<link rel="stylesheet" href="/assets/css/app.css">
```

Important:

`/public is not used in URLs`

because Apache uses `public/` as DocumentRoot.

---

## SCSS Build Commands

Build styles once:

```shell
npm run scss:build
```

Watch SCSS changes:

```shell
npm run scss:watch
```

---

## package.json Scripts

Current scripts:

```json
{
  "scss:build": "...",
  "scss:watch": "..."
}
```

Used package:

- sass

---

## JavaScript

Main JS file:

```public/assets/js/app.js```

Included globally:

```html
<script src="/assets/js/app.js"></script>
```

jQuery CDN:

```html
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
```

---

## Hero Slider

Homepage contains a custom hero slider.

Features:

* autoplay
* next/previous buttons
* navigation dots
* pause on hover
* fade transition

---

## Slider Backend Logic

Slider data is loaded from:

```php
PostRepository::findLeastViewedPostsByCategories()
```

Logic:

* one least-viewed post per category

---

## Slider Frontend Logic

Slider behavior is implemented in:

`public/assets/js/app.js`

Uses jQuery for:

* DOM interactions
* autoplay interval
* transitions
* navigation controls

---

## Category Page

Category page supports:

* pagination
* sorting
* responsive cards layout

Posts per page:

`6`

Sorting options:

* published_at
* views
* title

---

## Pagination Component

Pagination styles:

`assets/scss/components/_pagination.scss`

Pagination logic handled in:

`CategoryController`

---

Post Cards

Reusable post card styling:

`assets/scss/components/_post-card.scss`

Used on:

* homepage
* category page
* related posts section

---

## Related Posts

Single post page displays related posts.

Logic:

* posts sharing the same category
* current post excluded

---

## Responsive Design

Responsive helpers are stored in:

`assets/scss/base/_responsive.scss`

Approach:

* mobile-friendly layout
* flexible grids
* responsive typography

---

## 404 Page

Custom 404 page:

`templates/error/404.tpl`

Controller:

`App\Controller\NotFoundController`

Used automatically by Router.

---

Frontend Assets

Assets structure:

```text
public/assets/
├── css/
├── js/
└── images/
```

---

## Images

Post images:

`public/assets/images/posts/`

Used by seeded demo posts.

---

Current Frontend Status

Implemented:

* base layout
* reusable partials
* responsive SCSS structure
* homepage UI
* category page UI
* post page UI
* hero slider
* pagination
* sorting UI
* sticky footer
* custom 404 page
* reusable post cards
* jQuery interactions
* SCSS build pipeline

---

[To top](#frontend-and-ui-layer)

[Back to Main](../README.md)