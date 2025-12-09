<?php

return [
    /*
    |--------------------------------------------------------------------------
    | UI Direction
    |--------------------------------------------------------------------------
    |
    | This value determines the text direction of the UI.
    | Set to 'rtl' for right-to-left languages (like Farsi/Arabic)
    | Set to 'ltr' for left-to-right languages (like English)
    |
    */

    'direction' => env('UI_DIRECTION', 'rtl'),

    /*
    |--------------------------------------------------------------------------
    | UI Language
    |--------------------------------------------------------------------------
    |
    | This value determines the default language for the UI.
    | Options: 'en', 'fa' (Farsi)
    |
    */

    'language' => env('UI_LANGUAGE', 'fa'),
];

