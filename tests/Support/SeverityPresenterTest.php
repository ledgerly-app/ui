<?php

use Ledgerly\UI\Support\SeverityPresenter;

it('matches critical icon', function () {
    expect(SeverityPresenter::icon('critical'))
        ->toBe('flame');
});

it('matches error icon', function () {
    expect(SeverityPresenter::icon('error'))
        ->toBe('x-circle');
});

it('matches warning icon', function () {
    expect(SeverityPresenter::icon('warning'))
        ->toBe('alert-triangle');
});

it('matches notice icon', function () {
    expect(SeverityPresenter::icon('notice'))
        ->toBe('bell');
});

it('resolves default icon', function () {
    expect(SeverityPresenter::icon(''))
        ->toBe('info');
});

it('matches critical weight', function () {
    expect(SeverityPresenter::weight('critical'))
        ->toBe(5);
});

it('matches error weight', function () {
    expect(SeverityPresenter::weight('error'))
        ->toBe(4);
});

it('matches warning weight', function () {
    expect(SeverityPresenter::weight('warning'))
        ->toBe(3);
});

it('matches notice weight', function () {
    expect(SeverityPresenter::weight('notice'))
        ->toBe(2);
});

it('resolves default weight', function () {
    expect(SeverityPresenter::weight(''))
        ->toBe(1);
});
