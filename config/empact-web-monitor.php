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
        ]
    ]
];
