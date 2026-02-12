<?php

namespace Ledgerly\UI;

use Illuminate\Support\ServiceProvider;

final class LedgerlyUIServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (config('ledgerly-ui.routes', true)) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }
        $this->loadViewsFrom(__DIR__.'/../resources/views/ledgerly', 'ledgerly');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/ledgerly'),
        ], 'ledgerly-ui-views');

        $this->publishes([
            __DIR__.'/../config/ledgerly-ui.php' => config_path('ledgerly-ui.php'),
        ], 'ledgerly-ui-config');

        $this->publishes([
            __DIR__.'/../resources/css/ledgerly.css' => public_path('vendor/ledgerly/ledgerly.css'),
        ], 'ledgerly-ui-assets');
    }
}
