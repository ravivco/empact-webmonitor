<?php

return [
    'twitter' => [
        'consumer_key' => env('TWITTER_CONSUMER_KEY'),
        'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
        'access_token' => env('TWITTER_ACCESS_TOKEN'),
        'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET')
    ],
    'google' => [
        'api_key' => env('GOOGLE_API_KEY'),
        'search_engine_id' => env('GOOGLE_SEARCH_ENGINE_ID'),
        'search_count' => 3
    ],
    'vigo' => [
        'token' => env('VIGO_TOKEN'),
        'media_map' => [
            'Internet'  => 1, // Regular & News
            'Blog'      => 2, // Blogs
            'Forum'     => 3, // Forums and discussions
            'Twitter'   => 5, // Twitter
            'Facebook'  => 6, // Facebook
            'Instagram' => 7, // Instagram
            'TB'        => 8, // Talk back
            'Youtube'   => 9, // Youtube
        ],
        'interface' => [
            'search' => 'startingIndex',
            'map' => 'db'
        ]
    ],
    'empactai' => [
        'api_endpoint' => env('AI_API_ENDPOINT'),
        'api_token' => env('AI_API_BEARER_TOKEN'),
        'interface' => [
            'search' => [
                'byDate' => ['key' => 'conversation_details.updated_at', 'condition' => 'gte', 'active' => true],
                'byBrand' => ['key' => 'client_details.brand_id', 'condition' => null, 'active' => true],
                'byApiItemId' => ['key' => 'conversation_id', 'condition' => 'gte', 'active' => false],
            ],
            'map' => 'self'
        ]
    ]
];
