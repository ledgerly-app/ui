<?php

namespace Ledgerly\UI\Support;

final class SummaryPresenter
{
    /**
     * Build a readable summary sentence.
     *
     * Example:
     * John updated invoice #42
     * System logged in
     */
    public static function present(
        ?string $actorLabel,
        string $action,
        ?string $targetLabel = null
    ): string {
        $actor = $actorLabel ?: 'System';
        $verb = VerbFormatter::fromAction($action);

        if ($targetLabel) {
            return sprintf('%s %s %s', $actor, $verb, $targetLabel);
        }

        return sprintf('%s %s', $actor, $verb);
    }
}
