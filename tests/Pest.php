<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Ledgerly\UI\Tests\TestCase;

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in(__DIR__);
