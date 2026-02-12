<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>@yield('title', 'Ledger Timeline')</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Ledgerly CSS --}}
        <link rel="stylesheet" href="{{ asset('vendor/ledgerly/ledgerly.css') }}">

        {{-- Allow host app to inject extra head content --}}
        @stack('ledgerly-head')
    </head>
    <body>

        <div class="ledgerly-container">

            <header class="ledgerly-header">
                <h1 class="ledgerly-title">
                    Ledger Timeline
                </h1>
            </header>

            <main class="ledgerly-content">
                @yield('content')
            </main>

        </div>

        {{-- Allow host app to inject scripts --}}
        @stack('ledgerly-scripts')

    </body>
</html>
