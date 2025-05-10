# JavaScript and CSS Injector for Shopware 6

This plugin for [Shopware 6](https://www.shopware.com) lets you manage custom JavaScript and CSS/SCSS snippets through the admin interface. It simplifies the process of injecting code into your storefront without needing to modify theme files directly.

## Features

- Create unlimited containers for JavaScript and/or CSS code
- Assign code snippets to specific sales channels
- Define which pages should include each snippet
- Set a date and time range for snippet activation
- Available in English, German, Italian, and French

## Requirements

- Shopware 6.6 or higher

## Installation

```bash
composer require swcommerce/javascript-css-injector
bin/console plugin:refresh
bin/console plugin:install -a SwCommerceJavascriptCSSInjector