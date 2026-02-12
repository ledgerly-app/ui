<?php

namespace Ledgerly\UI\Support;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Ledgerly\Core\Models\LedgerEntry;
use Ledgerly\UI\ViewModels\CorrelationGroupViewModel;
use Ledgerly\UI\ViewModels\LedgerEntryViewModel;
use Ledgerly\UI\ViewModels\LedgerTimelineViewModel;

/** @mixin LedgerEntry */
final class TimelineMapper
{
    /**
     * @param  LengthAwarePaginator<int, LedgerEntry>  $paginator
     */
    public static function fromPaginator(LengthAwarePaginator $paginator): LedgerTimelineViewModel
    {
        $entries = collect($paginator->items())
            ->map(fn (LedgerEntry $entry) => self::mapEntry($entry))
            ->values();

        $items = self::groupByCorrelation($entries);

        return new LedgerTimelineViewModel(
            items: $items,
            paginator: $paginator,
        );
    }

    private static function mapEntry(LedgerEntry $entry): LedgerEntryViewModel
    {
        $metadata = is_array($entry->metadata) ? $entry->metadata : [];

        $severity = $metadata['severity'] ?? 'info';

        $actorLabel = self::resolveActorLabel($entry);

        $targetLabel = self::resolveTargetLabel($entry);

        return new LedgerEntryViewModel(
            id: $entry->id,
            action: $entry->action,
            actionLabel: ActionLabelResolver::resolve($entry->action),
            actorLabel: $actorLabel,
            targetLabel: $targetLabel,
            diff: DiffPresenter::present($entry->diff),
            metadata: MetadataPresenter::present($entry->metadata),
            occurredAt: optional($entry->created_at)->toISOString(),
            correlationId: $entry->metadata['correlation_id'] ?? null,
            severity: $severity,
            severityLabel: SeverityPresenter::label($severity),
            severityIcon: SeverityPresenter::icon($severity),
            summary: SummaryPresenter::present(
                actorLabel: $actorLabel,
                action: $entry->action,
                targetLabel: $targetLabel,
            ),
        );
    }

    private static function resolveActorLabel(LedgerEntry $entry): ?string
    {
        if (! $entry->actor) {
            return null;
        }

        return method_exists($entry->actor, 'ledgerlyLabel')
            ? $entry->actor->ledgerlyLabel()
            : class_basename($entry->actor).' #'.$entry->actor->getKey();
    }

    private static function resolveTargetLabel(LedgerEntry $entry): ?string
    {
        if (! $entry->target) {
            return null;
        }

        return method_exists($entry->target, 'ledgerlyLabel')
            ? $entry->target->ledgerlyLabel()
            : class_basename($entry->target).' #'.$entry->target->getKey();
    }

    /**
     * @param  Collection<int, LedgerEntryViewModel>  $entries
     * @return array<int, LedgerEntryViewModel|CorrelationGroupViewModel>
     */
    private static function groupByCorrelation(Collection $entries): array
    {
        $items = [];
        $buffer = [];
        $currentCorrelation = null;

        foreach ($entries as $entry) {
            if (! $entry->correlationId) {
                self::flushBuffer($buffer, $items);
                $items[] = $entry;

                continue;
            }

            if ($currentCorrelation === null) {
                $currentCorrelation = $entry->correlationId;
            }

            if ($entry->correlationId !== $currentCorrelation) {
                self::flushBuffer($buffer, $items);
                $currentCorrelation = $entry->correlationId;
            }

            $buffer[] = $entry;
        }

        self::flushBuffer($buffer, $items);

        return $items;
    }

    private static function flushBuffer(array &$buffer, array &$items): void
    {
        if (count($buffer) === 0) {
            return;
        }

        if (count($buffer) === 1) {
            $items[] = $buffer[0];
            $buffer = [];

            return;
        }

        $items[] = self::buildGroup($buffer);
        $buffer = [];
    }

    /**
     * @param  LedgerEntryViewModel[]  $entries
     */
    private static function buildGroup(array $entries): CorrelationGroupViewModel
    {
        /** @var string $maxSeverity */
        $maxSeverity = collect($entries)
            ->pluck('severity')
            ->sortByDesc(fn ($s) => SeverityPresenter::weight($s))
            ->first();

        return new CorrelationGroupViewModel(
            correlationId: $entries[0]->correlationId,
            label: $entries[0]->actionLabel,
            startedAt: end($entries)->occurredAt,
            endedAt: $entries[0]->occurredAt,
            entries: $entries,
            maxSeverity: $maxSeverity,
            severityIcon: SeverityPresenter::icon($maxSeverity),
        );
    }
}
