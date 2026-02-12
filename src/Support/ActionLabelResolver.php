<?php

namespace Ledgerly\UI\Support;

use Illuminate\Support\Str;

final class ActionLabelResolver
{
    /**
     * Resolve a human-readable label for an action string.
     */
    public static function resolve(string $action): string
    {
        $overrides = config('ledgerly-ui.action_labels', []);
        // dd($overrides[$action]);
        if (isset($overrides[$action])) {
            return $overrides[$action];
        }

        return self::humanize($action);
    }

    /**
     * Convert "invoice.updated" -> "Invoice Updated"
     */
    private static function humanize(string $action): string
    {
        $label = str_replace('.', ' ', $action);

        $label = str_replace('_', ' ', $label);

        return Str::headline($label);
    }
}
