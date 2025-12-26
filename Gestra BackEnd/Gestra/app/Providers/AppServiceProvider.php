<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Storage::extend('azure', function ($app, $config) {

            $connectionString =
                "DefaultEndpointsProtocol=https;" .
                "AccountName={$config['name']};" .
                "AccountKey={$config['key']};" .
                "EndpointSuffix=core.windows.net";

            $client = BlobRestProxy::createBlobService($connectionString);

            $adapter = new AzureBlobStorageAdapter(
                $client,
                $config['container']
            );

            $filesystem = new Filesystem($adapter);

            return new FilesystemAdapter($filesystem, $adapter, $config);
        });
    }
}
