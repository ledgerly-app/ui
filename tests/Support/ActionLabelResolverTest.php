<?php

use Ledgerly\UI\Support\ActionLabelResolver;

it('humanizes actions correctly', function () {
    expect(ActionLabelResolver::resolve('invoice.updated'))
        ->toBe('Invoice Updated');
});

it('handles underscored verbs', function () {
    expect(ActionLabelResolver::resolve('user.logged_in'))
        ->toBe('User Logged In');
});

it('uses config overrides when present', function () {
    config()->set('ledgerly-ui.action_labels', [
        'invoice.updated' => 'Amount Changed',
    ]);

    expect(ActionLabelResolver::resolve('invoice.updated'))
        ->toBe('Amount Changed');
});
