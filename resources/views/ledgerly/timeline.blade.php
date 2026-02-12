@extends(config('ledgerly-ui.layout', 'ledgerly::layout'))

@section('content')
    <div class="ledgerly-timeline">
        @if (empty($vm->items))
            <div class="ledgerly-empty">
                No ledger entries found.
            </div>
        @else
            @foreach ($vm->items as $item)
                @if ($item instanceof \Ledgerly\UI\ViewModels\CorrelationGroupViewModel)
                    @include ('ledgerly::_group', ['group' => $item])
                @else
                    @include ('ledgerly::_entry', ['entry' => $item])
                @endif
            @endforeach
        @endif

        <div class="ledgerly-pagination pagination">
            {{ $vm->paginator->links('ledgerly::_paginator') }}
        </div>
    </div>
@endsection
