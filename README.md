# Ledgerly UI

**Ledgerly UI** is a Blade-based timeline viewer for applications using **ledgerly/core**.
It provides a clean, read-only interface for browsing audit logs, activity timelines, and correlated transactions.

This package focuses strictly on **presentation**. It does not create or modify ledger entries.

---

## Features

* Timeline view of ledger entries
* Correlation grouping (transaction-style blocks)
* Severity indicators
* Diff visualization
* Metadata display
* Pagination
* Fully Blade-based (no Livewire or JavaScript required)
* Publishable views and styles
* Snapshot-test friendly structure

---

## Requirements

* PHP 8.2+
* Laravel 11+
* `ledgerly/core` ^0.1

---

## Installation

Install via Composer:

```bash
composer require ledgerly-app/ui
```

Publish configuration, views, and assets if desired:

```bash
php artisan vendor:publish --tag=ledgerly-ui-config
php artisan vendor:publish --tag=ledgerly-ui-views
php artisan vendor:publish --tag=ledgerly-ui-assets
```

---

## Usage

By default, the package registers a route:

```
GET /ledgerly/timeline
```

You should normally protect this route with authentication or authorization middleware in your application.

Example:

```php
Route::middleware(['web', 'auth'])
    ->prefix('ledgerly')
    ->group(function () {
        require base_path('vendor/ledgerly/ui/routes/web.php');
    });
```

---

## How It Works

The rendering pipeline is intentionally simple:

```
LedgerEntry (core)
      ↓
TimelineMapper
      ↓
ViewModels
      ↓
Presenters
      ↓
Blade templates
```

This separation keeps:

* Blade templates simple
* Rendering deterministic
* Tests reliable
* Customization straightforward

---

## Customizing the Layout

The default layout is minimal and neutral.

You can change the layout in:

```php
config/ledgerly-ui.php
```

Example:

```php
'layout' => 'layouts.app',
```

---

## Customizing Action Labels

Action labels can be overridden in config:

```php
'action_labels' => [
    'invoice.updated' => 'Invoice amount changed',
],
```

If no override exists, labels are automatically humanized.

---

## Overriding Views

After publishing views:

```
resources/views/vendor/ledgerly/
```

You can customize:

* timeline layout
* entry rendering
* metadata display
* pagination

No presenter or controller changes are required.

---

## CSS and Styling

Ledgerly UI ships with a minimal stylesheet designed to:

* look clean by default
* avoid conflicts
* be easy to override

You are encouraged to override styles in your application rather than editing vendor files.

---

## Severity Indicators

Severity is derived from entry metadata:

```
info
notice
warning
error
critical
```

Groups automatically reflect the highest severity of their entries.

---

## Correlation Groups

Entries sharing a `correlation_id` are grouped visually.
Grouping is:

* temporal (adjacent entries only)
* non-destructive
* read-only

---

## Testing

This package is designed to be easy to test.

Key parts are covered by:

* unit tests for presenters
* timeline mapper tests
* snapshot tests for rendered output

Run tests:

```bash
composer test
```

---

## Limitations (By Design)

Ledgerly UI intentionally does **not**:

* log actions automatically
* provide real-time updates
* implement authorization
* provide dashboards or analytics

Those concerns belong to the host application or higher-level packages.

---

## Versioning

Ledgerly follows semantic versioning.

During `0.x` releases:

* APIs are relatively stable
* minor changes may still occur
* breaking changes will be documented clearly

---

## Contributing

Contributions are welcome.

Please:

* keep changes focused
* include tests
* avoid adding framework dependencies
* keep Blade templates logic-free

See [`CONTRIBUTING.md`](CONTRIBUTING.md) for details.

---

## License

[MIT](LICENSE.md)

---

## A Note on Philosophy

Ledgerly UI is designed to be **boringly reliable**.
If it ever surprises you, that’s a bug.
