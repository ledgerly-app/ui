<div class="ledgerly-correlation-group">
    <div class="ledgerly-correlation-header">
        <span class="ledgerly-severity ledgerly-severity-{{ $group->maxSeverity }}"></span>

        <span class="ledgerly-group-label">
            {{ $group->label ?? 'Related actions' }}
        </span>

        <span class="ledgerly-entry-time">
            {{ $group->startedAt }} - {{ $group->endedAt }}
        </span>
    </div>

    <div class="ledgerly-correlation-entries">
        @foreach ($group->entries as $entry)
            @include ('ledgerly::_entry', ['entry' => $entry])
        @endforeach
    </div>
</div>
