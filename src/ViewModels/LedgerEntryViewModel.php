<?php

namespace Ledgerly\UI\ViewModels;

final class LedgerEntryViewModel
{
    /**
     * @param  array<string, mixed>|null  $diff
     * @param  array<string, mixed>  $metadata
     */
    public function __construct(
        public int $id,
        public string $action,
        public string $actionLabel,
        public ?string $actorLabel,
        public ?string $targetLabel,
        public ?array $diff,
        public array $metadata,
        public string $occurredAt,
        public ?string $correlationId,
        public string $severity,
        public string $severityLabel,
        public string $severityIcon,
        public string $summary,
    ) {}
}
