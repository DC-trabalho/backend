<?php

return [
    'name' => 'e-DC',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'e-DC',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/icon-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images/icons/icon-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images/icons/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/icons/icon-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/icons/icon-384x384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/icons/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'custom' => [
            'id' => '?pwa',
            'description' => 'Mergulhe no mundo dos super-heróis com a loja da DC Comics!',

            'shortcuts' => [
                [
                    'name' => 'Carrinho',
                    'description' => 'Acesse seu carrinho de compras',
                    'url' => '/cart',
                    'icons' => [
                        [
                            'src' => '/images/icons/icon-96x96.png',
                            'type' => 'image/png',
                            'sizes' => '96x96',
                            'purpose' => 'any'
                        ]
                    ]
                ]
            ],
            'screenshots' => [
                [
                    'src' => '/images/icons/icon-384x384.png',
                    'sizes' => '384x384',
                    'type' => 'image/png',
                    'form_factor' => 'narrow',
                ],
                [
                    'src' => '/images/icons/icon-512x512.png',
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'form_factor' => 'wide',
                ]
            ]


        ]
    ]
];
