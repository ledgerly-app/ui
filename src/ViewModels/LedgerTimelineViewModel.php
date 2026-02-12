<?php

namespace Ledgerly\UI\ViewModels;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Ledgerly\Core\Models\LedgerEntry;

final class LedgerTimelineViewModel
{
    /**
     * @param  array<int, LedgerEntryViewModel|CorrelationGroupViewModel>  $items
     * @param  LengthAwarePaginator<int, LedgerEntry>  $paginator
     */
    public function __construct(
        public array $items,
        public LengthAwarePaginator $paginator,
    ) {}
}
