<?php

use Ledgerly\UI\Support\VerbFormatter;

it('extracts simple verbs', function () {
    expect(VerbFormatter::fromAction('invoice.updated'))
        ->toBe('updated');
});

it('formats underscored verbs', function () {
    expect(VerbFormatter::fromAction('user.logged_in'))
        ->toBe('logged in');
});

it('uses the last segment as the verb', function () {
    expect(VerbFormatter::fromAction('billing.invoice.approved'))
        ->toBe('approved');
});

it('handles malformed actions safely', function () {
    expect(VerbFormatter::fromAction('invalid'))
        ->toBe('invalid');
});
