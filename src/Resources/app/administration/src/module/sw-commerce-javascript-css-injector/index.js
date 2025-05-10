import enGB from './snippet/en-GB.json';
import deDE from './snippet/de-DE.json';
import frFR from './snippet/fr-FR.json';
import itIT from './snippet/it-IT.json';

import './page/sw-commerce-javascript-css-injector-list';
import './page/sw-commerce-javascript-css-injector-detail';
import './page/sw-commerce-javascript-css-injector-create';

const { Module } = Shopware;


Shopware.Service('searchTypeService')?.upsertType('sw_commerce_code_snippet', {
    entityName: 'sw_commerce_code_snippet',
    placeholderSnippet: 'sw.commerce.javascript.css.injector.list',
    listingRoute: 'sw.commerce.javascript.css.injector.list',
});

Module.register('sw-commerce-javascript-css-injector', {
    type: 'plugin',
    name: 'JS/CSS Injector',
    entity: 'sw_commerce_code_snippet',
    color: '#54c2ff',
    icon: 'regular-shopping-bag',
    title: 'swcommerce-javascript-css-injector.general.title',
    description: 'Manage custom Javascript and CSS injections.',

    snippets: {
        'en-GB': enGB,
        'de-DE': deDE,
        'fr-FR': frFR,
        'it-IT': itIT
    },

    routes: {
        list: {
            component: 'sw-commerce-javascript-css-injector-list',
            path: 'list',
        },

        detail: {
            component: 'sw-commerce-javascript-css-injector-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'sw.commerce.javascript.css.injector.list',
            },
        },

        create: {
            component: 'sw-commerce-javascript-css-injector-create',
            path: 'create',
            meta: {
                parentPath: 'sw.commerce.javascript.css.injector.list',
            }
        }
    },

    navigation: [{
        label: 'swcommerce-javascript-css-injector.general.menuTitle',
        id: 'sw-commerce-javascript-css-injector-index',
        path: 'sw.commerce.javascript.css.injector.list',
        parent: 'sw-content',
        position: 110
    }],

    defaultSearchConfiguration: {
        _searchable: true,
        name: {
            _searchable: true,
            _score: 500,
        },
        css: {
            _searchable: true,
            _score: 500,
        },
        js: {
            _searchable: true,
            _score: 500,
        }
    }
});