<?php

namespace Ledgerly\UI\Support;

final class VerbFormatter
{
    /**
     * Extract and format the verb from an action string.
     *
     * Example:
     * invoice.updated -> updated
     * user.logged_in -> logged in
     */
    public static function fromAction(string $action): string
    {
        $segments = explode('.', $action);

        // Verb is always the last segment
        $verb = end($segments);

        // Normalize underscores -> spaces
        $verb = str_replace('_', ' ', $verb);

        // Lowercase for sentence usage
        return mb_strtolower($verb);
    }
}
