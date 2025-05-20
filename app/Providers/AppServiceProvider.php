<?php

namespace App\Providers;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $this->configureCloudinary();
    }
    /**
     * Configure Cloudinary settings.
     *
     * @return void
     */
    protected function configureCloudinary()
    {
        $config = new Configuration;
        $config->cloud->cloudName = env("CLOUDINARY_CLOUD_NAME");
        $config->cloud->apiKey = env("CLOUDINARY_API_KEY");
        $config->cloud->apiSecret = env("CLOUDINARY_API_SECRET");
        $config->url->secure = true;

    }
}
