<?php
return [
    'api_key' => env('API_KEY', null),
    'wa_host' => env('WA_HOST', null),
    'wa_session' => env('WA_SESSION', null),
    "page" => env('TTE_PAGE',1),
    "originX" => env('TTE_ORIGINX',380),
    "originY" => env('TTE_ORIGINY',700),
    "width" => env('TTE_WIDTH',180),
    "height" => env('TTE_HEIGHT',70),
];