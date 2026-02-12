<?php

namespace Ledgerly\UI\Support;

final class SeverityPresenter
{
    public static function icon(string $severity): string
    {
        return match ($severity) {
            'critical' => 'flame',
            'error' => 'x-circle',
            'warning' => 'alert-triangle',
            'notice' => 'bell',
            default => 'info',
        };
    }

    public static function label(string $severity): string
    {
        return ucfirst($severity);
    }

    public static function weight(string $severity): int
    {
        return match ($severity) {
            'critical' => 5,
            'error' => 4,
            'warning' => 3,
            'notice' => 2,
            default => 1,
        };
    }
}
