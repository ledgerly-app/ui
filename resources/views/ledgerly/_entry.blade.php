<div class="ledgerly-entry">
    <div class="ledgerly-entry-header">
        <span class="ledgerly-severity ledgerly-severity-{{ $entry->severity }}"></span>

        <span class="ledgerly-entry-summary">
            {{ $entry->summary }}
        </span>

        <span class="ledgerly-entry-time">
            {{ $entry->occurredAt }}
        </span>
    </div>

    {{-- Diff --}}
    @if (! empty($entry->diff))
        @include('ledgerly::_diff', ['diff' => $entry->diff])
    @endif

    {{-- Metadata --}}
    @if (config('ledgerly-ui.show_metadata', true) && ! empty($entry->metadata))
        @include ('ledgerly::_metadata', ['metadata' => $entry->metadata])
    @endif
</div>
