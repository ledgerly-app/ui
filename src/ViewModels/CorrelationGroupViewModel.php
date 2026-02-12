<?php

namespace Ledgerly\UI\ViewModels;

final class CorrelationGroupViewModel
{
    /**
     * @param  LedgerEntryViewModel[]  $entries
     */
    public function __construct(
        public string $correlationId,
        public ?string $label,
        public string $startedAt,
        public string $endedAt,
        public array $entries,
        public string $maxSeverity,
        public string $severityIcon,
    ) {}
}
