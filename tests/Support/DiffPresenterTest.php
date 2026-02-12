<?php

use Ledgerly\UI\Support\DiffPresenter;

class StringableObject
{
    public function __toString(): string
    {
        return 'stringable-value';
    }
}

it('presents a diff correctly', function () {
    $diff = [
        'amount' => [100, 150],
    ];

    $rows = DiffPresenter::present($diff);

    expect($rows[0]['field'])->toBe('Amount')
        ->and($rows[0]['after'])->toBe('150')
        ->and($rows[0]['before'])->toBe('100');
});

it('returns empty array for malformed diff rows', function () {
    $diff = [
        'broken' => 'invalid',
    ];

    expect(DiffPresenter::present($diff))->toBe([]);
});

it('returns empty array for null diff', function () {
    expect(DiffPresenter::present(null))->toBe([]);
});

it('stringifies null value', function () {
    $diff = [
        'null' => [null, 10],
    ];

    $rows = DiffPresenter::present($diff);

    expect($rows[0]['before'])->toBe('null');
});

it('stringifies boolean value', function () {
    $diff = [
        'bool' => [true, false],
    ];

    $rows = DiffPresenter::present($diff);

    expect($rows[0]['before'])->toBe('true')
        ->and($rows[0]['after'])->toBe('false');
});

it('stringifies arrays as json', function () {
    $diff = [
        'array' => [100, [500]],
    ];

    $rows = DiffPresenter::present($diff);

    expect($rows[0]['after'])->toBe(json_encode([500]));
});

it('stringifies objects that implement __toString', function () {
    $diff = [
        'field' => [new StringableObject, new StringableObject],
    ];

    $rows = DiffPresenter::present($diff);

    expect($rows)->toHaveCount(1)
        ->and($rows[0]['before'])->toBe('stringable-value')
        ->and($rows[0]['after'])->toBe('stringable-value');
});

it('json-encodes objects without __toString', function () {
    $object = new stdClass;
    $object->foo = 'bar';

    $diff = [
        'field' => [$object, $object],
    ];

    $rows = DiffPresenter::present($diff);

    expect($rows)->toHaveCount(1)
        ->and($rows[0]['before'])->toBe(json_encode($object))
        ->and($rows[0]['after'])->toBe(json_encode($object));
});
