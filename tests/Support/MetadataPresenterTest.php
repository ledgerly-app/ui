<?php

use Ledgerly\UI\Support\MetadataPresenter;

it('presents basic metadata', function () {
    $metadata = [
        'ip' => '127.0.0.1',
        'method' => 'POST',
    ];

    $rows = MetadataPresenter::present($metadata);

    expect($rows)->toHaveCount(2)
        ->and($rows[0]['label'])->toBe('Ip')
        ->and($rows[0]['value'])->toBe('127.0.0.1');
});

it('returns empty array for null metadata', function () {
    expect(MetadataPresenter::present(null))->toBe([]);
});

it('returns empty array for empty metadata', function () {
    expect(MetadataPresenter::present([]))->toBe([]);
});

it('filters hidden metadata keys', function () {
    config()->set('ledgerly-ui.hidden_metadata_keys', ['internal_id']);

    $metadata = [
        'ip' => '127.0.0.1',
        'internal_id' => 'abc123',
    ];

    $rows = MetadataPresenter::present($metadata);

    expect($rows)->toHaveCount(1)
        ->and($rows[0]['key'])->toBe('ip');
});

it('stringifies arrays as json', function () {
    $metadata = [
        'payload' => ['foo' => 'bar'],
    ];

    $rows = MetadataPresenter::present($metadata);

    expect($rows[0]['value'])->toBe(json_encode(['foo' => 'bar'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
});

it('stringifies objects as json', function () {
    $obj = new stdClass;
    $obj->foo = 'bar';

    $metadata = [
        'object' => $obj,
    ];

    $rows = MetadataPresenter::present($metadata);

    expect($rows[0]['value'])->toBe(json_encode($obj, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
});

it('stringifies booleans', function () {
    $metadata = [
        'success' => true,
    ];

    $rows = MetadataPresenter::present($metadata);

    expect($rows[0]['value'])->toBe('true');
});

it('stringifies null values', function () {
    $metadata = [
        'value' => null,
    ];

    $rows = MetadataPresenter::present($metadata);

    expect($rows[0]['value'])->toBe('null');
});

it('humanizes metadata keys', function () {
    $metadata = [
        'user_agent' => 'Test',
    ];

    $rows = MetadataPresenter::present($metadata);

    expect($rows[0]['label'])->toBe('User Agent');
});
