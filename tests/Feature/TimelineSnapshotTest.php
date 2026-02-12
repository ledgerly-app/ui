<?php

use Illuminate\Support\Carbon;
use Ledgerly\Core\Models\LedgerEntry;
use Spatie\Snapshots\MatchesSnapshots;

uses(MatchesSnapshots::class);

function createEntry(array $attributes = [])
{
    Carbon::setTestNow('2026-01-01 12:00:00');

    return LedgerEntry::create(array_merge([
        'action' => 'invoice.updated',
        'metadata' => ['severity' => 'info'],
        'created_at' => now(),
    ], $attributes));
}

it('renders a single ledger entry correctly', function () {
    createEntry([
        'diff' => [
            'amount' => [100, 150],
        ],
    ]);

    $response = $this->get(route('ledgerly.timeline'));

    $response->assertOk();

    $this->assertMatchesHtmlSnapshot(
        $response->getContent()
    );
});

it('renders correlation groups correctly', function () {
    createEntry([
        'action' => 'invoice.updated',
        'metadata' => [
            'correlation_id' => 'abc123',
            'severity' => 'info',
        ],
    ]);

    createEntry([
        'action' => 'invoice.sent',
        'metadata' => [
            'correlation_id' => 'abc123',
            'severity' => 'warning',
        ],
    ]);

    $response = $this->get(route('ledgerly.timeline'));

    $this->assertMatchesHtmlSnapshot(
        $response->getContent()
    );
});

it('renders metadata blocks correctly', function () {

    createEntry([
        'metadata' => [
            'ip' => '127.0.0.1',
            'method' => 'POST',
            'severity' => 'info',
        ],
    ]);

    $response = $this->get(route('ledgerly.timeline'));

    $this->assertMatchesHtmlSnapshot(
        $response->getContent()
    );
});

it('shows highest severity in correlation group', function () {

    createEntry([
        'metadata' => [
            'correlation_id' => 'group1',
            'severity' => 'info',
        ],
    ]);

    createEntry([
        'metadata' => [
            'correlation_id' => 'group1',
            'severity' => 'error',
        ],
    ]);

    $response = $this->get(route('ledgerly.timeline'));

    $this->assertMatchesHtmlSnapshot(
        $response->getContent()
    );
});

it('renders empty timeline gracefully', function () {

    $response = $this->get(route('ledgerly.timeline'));

    $this->assertMatchesHtmlSnapshot(
        $response->getContent()
    );
});
