<?php

namespace Ledgerly\UI\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Ledgerly\Core\Models\LedgerEntry;
use Ledgerly\UI\Support\TimelineMapper;

final class LedgerTimelineController
{
    public function __invoke(Request $request): View
    {
        /** @var int $perPage */
        $perPage = config('ledgerly-ui.per_page', 50);

        $paginator = LedgerEntry::query()
            ->latest()
            ->paginate($perPage);

        $vm = TimelineMapper::fromPaginator($paginator);

        return view('ledgerly::timeline', compact('vm'));
    }
}
