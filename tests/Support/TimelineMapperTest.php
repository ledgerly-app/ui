<?php

use Ledgerly\Core\Models\LedgerEntry;
use Ledgerly\UI\Support\TimelineMapper;
use Ledgerly\UI\ViewModels\CorrelationGroupViewModel;

function createNewEntry(array $attributes = [])
{
    return LedgerEntry::create(array_merge([
        'action' => 'invoice.updated',
        'metadata' => ['severity' => 'info'],
        'created_at' => now(),
    ], $attributes));
}

it('maps ledger entries into timeline items', function () {

    createNewEntry();
    createNewEntry();

    $paginator = LedgerEntry::query()->paginate(50);

    $vm = TimelineMapper::fromPaginator($paginator);

    expect($vm->items)->toHaveCount(2);
});

it('groups entries by correlation id', function () {

    createNewEntry([
        'metadata' => [
            'correlation_id' => 'abc',
            'severity' => 'info',
        ],
    ]);

    createNewEntry([
        'metadata' => [
            'correlation_id' => 'abc',
            'severity' => 'info',
        ],
    ]);

    $paginator = LedgerEntry::query()->paginate(50);

    $vm = TimelineMapper::fromPaginator($paginator);

    expect($vm->items)->toHaveCount(1);
});

it('does not group entries with different correlation ids', function () {

    createNewEntry([
        'metadata' => ['correlation_id' => 'a'],
    ]);

    createNewEntry([
        'metadata' => ['correlation_id' => 'b'],
    ]);

    $paginator = LedgerEntry::query()->paginate(50);

    $vm = TimelineMapper::fromPaginator($paginator);

    expect($vm->items)->toHaveCount(2);
});

it('does not group non-adjacent correlation entries', function () {

    createNewEntry([
        'metadata' => ['correlation_id' => 'a'],
    ]);

    createNewEntry([
        'metadata' => [],
    ]);

    createNewEntry([
        'metadata' => ['correlation_id' => 'a'],
    ]);

    $paginator = LedgerEntry::query()->paginate(50);

    $vm = TimelineMapper::fromPaginator($paginator);

    expect($vm->items)->toHaveCount(3);
});

it('uses highest severity for correlation group', function () {

    createNewEntry([
        'metadata' => [
            'correlation_id' => 'group1',
            'severity' => 'info',
        ],
    ]);

    createNewEntry([
        'metadata' => [
            'correlation_id' => 'group1',
            'severity' => 'error',
        ],
    ]);

    $paginator = LedgerEntry::query()->paginate(50);

    $vm = TimelineMapper::fromPaginator($paginator);

    $group = $vm->items[0];

    expect($group->maxSeverity)->toBe('error');
});

it('handles entries without metadata safely', function () {

    createNewEntry([
        'metadata' => null,
    ]);

    $paginator = LedgerEntry::query()->paginate(50);

    $vm = TimelineMapper::fromPaginator($paginator);

    expect($vm->items)->toHaveCount(1);
});

it('generates summaries for entries', function () {

    createNewEntry([
        'action' => 'invoice.updated',
    ]);

    $paginator = LedgerEntry::query()->paginate(50);

    $vm = TimelineMapper::fromPaginator($paginator);

    $entry = $vm->items[0];

    expect($entry->summary)->not->toBeEmpty();
});

it('normalizes diff via presenter', function () {

    createNewEntry([
        'diff' => [
            'amount' => [100, 200],
        ],
    ]);

    $paginator = LedgerEntry::query()->paginate(50);

    $vm = TimelineMapper::fromPaginator($paginator);

    $entry = $vm->items[0];

    expect($entry->diff)->toHaveCount(1);
});

it('returns empty timeline when no entries exist', function () {

    $paginator = LedgerEntry::query()->paginate(50);

    $vm = TimelineMapper::fromPaginator($paginator);

    expect($vm->items)->toBe([]);
});

it('does not group a single correlation entry', function () {
    LedgerEntry::create([
        'action' => 'invoice.updated',
        'metadata' => [
            'correlation_id' => 'abc123',
            'severity' => 'info',
        ],
        'created_at' => now(),
    ]);

    $paginator = LedgerEntry::query()->paginate(50);

    $vm = TimelineMapper::fromPaginator($paginator);

    expect($vm->items)->toHaveCount(1)
        ->and($vm->items[0])
        ->not->toBeInstanceOf(CorrelationGroupViewModel::class)
        ->and($vm->items[0]->correlationId)->toBe('abc123');
});
