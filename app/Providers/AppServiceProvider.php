<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WhatsApp\WhatsAppGatewayInterface;
use App\Services\WhatsApp\FonnteGateway;
use App\Services\WhatsApp\WablasGateway;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WhatsAppGatewayInterface::class, function ($app) {
            $gateway = config('services.whatsapp.gateway');
            if ($gateway === 'wablas') {
                return new WablasGateway();
            }
            return new FonnteGateway(); // Default
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
