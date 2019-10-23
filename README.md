# empact-web-monitor
a Laravel package to fetch data from resources monitoring the web based on keywords

## Installation

To install this package in a laravel project, since it isn't hosted anywhere currently, you'll have to clone the repo and add the relative path to
the `composer.json` file in your laravel project. So add the following code to the `composer.json` file in the laravel project you want to use the
package in:

```bash
   "repositories": [
        {
            "type": "path",
            "url" : "../empact-web-monitor"
        }
    ]
```
The `url` is the relative path to the folder where you cloned the repo.

Next, we install the package using composer, run the following command:

```bash
composer require empact/empact-web-monitor
```

From Laravel 5.5 and above, the service provider will automatically be registered by Laravel


## Configuration
To publish the `config` file, run:
```bash
php artisan vendor:publish --provider="Empact\WebMonitor\EmpactServiceProvider"
```
This will publish a `empact-web-monitor.php` file to the config directory with the following content:

```php
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
        'search_engine_id' => env('GOOGLE_SEARCH_ENGINE_ID')
    ],
    'vigo' => [
        'token' => env('VIGO_TOKEN')
    ]
];

```
Next, edit your `.env` file with your Twitter, Google and Vigo keys.
```bash
TWITTER_CONSUMER_KEY=xxxxx
TWITTER_CONSUMER_SECRET=xxxxx
TWITTER_ACCESS_TOKEN=xxxxx
TWITTER_ACCESS_TOKEN_SECRET=xxxxx

GOOGLE_API_KEY=xxxxx
GOOGLE_SEARCH_ENGINE_ID=xxxxx

VIGO_TOKEN=xxxxx
```
## Usage
To crawl all the supported monitors (twitter, google and vigo) for a particular keyword, you can use the `Empact\WebMonitor\Drivers\BaseMonitor` class or the Facade at `Empact\WebMonitor\Facades\EmpactWebMonitor`and
call search on it passing in the keyword you want to search for. So for example, I have a `SearchController.php` file
```php
<?php

namespace App\Http\Controllers;

use Empact\WebMonitor\Facades\EmpactWebMonitor;

class SearchController extends Controller
{
   public function search()
   {
     $keyword = 'Burna Boy';
     
     $results = EmpactWebMonitor::search($keyword);
     
     return response()->json(['data'=>$results]);
}
```



