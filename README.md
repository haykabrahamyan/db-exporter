# DB-Exporter
[![N|Solid](https://haykabrahamyan.com/assets/avatar1.jpg)](https://haykabrahamyan.com)

Why need to search? you are already found, follow to guide and make life happy:) 


# Features!

  - Export MySql database to SQL file using 'mysqldump' command in shell
  - Automatically upload dump to Google Drive 
  - Laravel Storage Support


before start configuration prepare your Google oAuth credentials:
  - GOOGLE_DRIVE_CLIENT_ID
  - GOOGLE_DRIVE_CLIENT_SECRET
  - GOOGLE_DRIVE_REFRESH_TOKEN
  - GOOGLE_DRIVE_FOLDER_ID(optional)


### Installation

Package requires [php](https://php.net/) v5.3+ to run.

Install the dependencies and devDependencies and update composer.

```sh
"require": {
....
    "haykabrahamyan/db-exporter": "^1.0.0",
....
}
```

update environments as follows...

```sh
GOOGLE_DRIVE_CLIENT_ID=xxxx-yyyyyyyyy.apps.googleusercontent.com
GOOGLE_DRIVE_CLIENT_SECRET=client_secret
GOOGLE_DRIVE_REFRESH_TOKEN=1/xxxxxx
GOOGLE_DRIVE_FOLDER_ID=null
```
set drive folder to null if you want to upload dump in your drive root folder

```sh
DbExporter_MYSQLDUMP=/usr/bin/mysqldump
DbExporter_PATH=/var/www/html/public/
```

### Configuration

Add the storage disk configuration to config/filesystem.php:
```sh
return [
  
    // ...
  
    'cloud' => 'google', // Optional: set Google Drive as default cloud storage
    
    'disks' => [
        
        // ...
        
        'google' => [
            'driver' => 'google',
            'clientId' => env('GOOGLE_DRIVE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
            'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
            'folderId' => env('GOOGLE_DRIVE_FOLDER_ID'),
        ],
        
        // ...
        
    ],
    
    // ...
];
```


### Development

Save GoogleDriveServiceProvider.php to app/Providers and add it to the providers array in config/app.php:

```sh
App\Providers\GoogleDriveServiceProvider::class,
```

GoogleDriveServiceProvider.php
```sh
<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Storage::extend('google', function($app, $config) {
            $client = new \Google_Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);
            $service = new \Google_Service_Drive($client);
            $adapter = new \Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter($service, $config['folderId']);
            return new \League\Flysystem\Filesystem($adapter);
        });
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
```

#### how to use
You are done and can use now everywhere in your code including scheduled files by simple call
```sh
DbExporterController::doExport();
```
Don't forget! Use the class to the head of your file where should be called Exporter
```sh
use Haykabrahamyan\DbExporter\DbExporterController;
```


License
----

MIT


**Free Software, Good Luck!**
You are free to donate at 132DKpgzGfYfFgqjR9EoG8EpYyAm84ksj2 BTC address  

