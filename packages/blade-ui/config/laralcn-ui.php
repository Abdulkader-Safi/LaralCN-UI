<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Components path
    |--------------------------------------------------------------------------
    |
    | Directory (relative to the app's base path) where `ui:add` writes
    | component files. This is your code once written — edit freely.
    |
    */

    "components_path" => "resources/views/components/ui",

    /*
    |--------------------------------------------------------------------------
    | Tag prefix
    |--------------------------------------------------------------------------
    |
    | Components render as <x-{prefix}.{name}>. With the default they are
    | used as <x-ui.button>. Changing this only affects how you reference
    | them in Blade; it does not rename files.
    |
    */

    "prefix" => "ui",

    /*
    |--------------------------------------------------------------------------
    | Theming strategy
    |--------------------------------------------------------------------------
    |
    | Only "css-variables" is supported in v1. Theme tokens are injected as
    | CSS custom properties into the app stylesheet by `ui:init`.
    |
    */

    "theme" => "css-variables",

    /*
    |--------------------------------------------------------------------------
    | Registry URL
    |--------------------------------------------------------------------------
    |
    | Base location of the registry. Defaults to the public raw GitHub base.
    | Override for a fork or a private registry. For local monorepo
    | development this may be an absolute filesystem path to /registry.
    |
    */

    "registry_url" => env(
        "LARALCN_UI_REGISTRY_URL",
        "https://raw.githubusercontent.com/Abdulkader-Safi/LaralCN-UI/main/registry",
    ),

    /*
    |--------------------------------------------------------------------------
    | JavaScript / interactivity strategy
    |--------------------------------------------------------------------------
    |
    | "alpine" or "none". Interactive components use Alpine.js inline. Alpine
    | is never bundled or installed for you; `ui:init` only detects it and
    | prints guidance.
    |
    */

    "js" => "alpine",

    /*
    |--------------------------------------------------------------------------
    | App CSS file
    |--------------------------------------------------------------------------
    |
    | The Tailwind v4 entry stylesheet `ui:init` injects theme variables into,
    | between idempotent sentinel markers. Matches a fresh `laravel new`.
    |
    */

    "css_path" => "resources/css/app.css",
];
