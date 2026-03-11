<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WhatsApp\WhatsAppGatewayInterface;
use App\Services\WhatsApp\FonnteGateway;
use App\Services\WhatsApp\WablasGateway;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;

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
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        Password::defaults(function () {
            $rule = Password::min(8)
                ->mixedCase()
                ->numbers();

            return $this->app->isProduction()
                        ? $rule->uncompromised()
                        : $rule;
        });
    }
}
