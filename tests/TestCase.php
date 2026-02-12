<?php

namespace Ledgerly\UI\Tests;

use Illuminate\Support\Facades\File;
use Ledgerly\UI\LedgerlyUIServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LedgerlyUIServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        foreach (File::allFiles(__DIR__.'/../vendor/ledgerly-app/core/database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
        }
    }
}
