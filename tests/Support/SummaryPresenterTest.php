<?php

use Ledgerly\UI\Support\SummaryPresenter;

it('builds a full summary', function () {
    $summary = SummaryPresenter::present(
        'John',
        'invoice.updated',
        'Invoice #42'
    );

    expect($summary)->toBe('John updated Invoice #42');
});

it('falls back to System when actor is null', function () {
    $summary = SummaryPresenter::present(
        null,
        'system.cleanup',
        null
    );

    expect($summary)->toBe('System cleanup');
});

it('handles missing target', function () {
    $summary = SummaryPresenter::present(
        'Alice',
        'user.logged_in',
        null
    );

    expect($summary)->toBe('Alice logged in');
});

it('formats underscored verbs correctly', function () {
    $summary = SummaryPresenter::present(
        'Alice',
        'user.logged_out',
        null
    );

    expect($summary)->toBe('Alice logged out');
});
