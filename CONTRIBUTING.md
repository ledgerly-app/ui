# CONTRIBUTING.md

# Contributing to Ledgerly UI

Thank you for your interest in contributing.

Ledgerly UI aims to remain:

- simple
- predictable
- framework-light
- easy to maintain

Please read these guidelines before submitting changes.

---

## Development Setup

Clone the repository and install dependencies:

```bash
composer install
````

Run tests:

```bash
composer test
```

---

## Coding Guidelines

### Keep Blade Templates Simple

Blade templates should:

* contain minimal logic
* not query the database
* not perform transformations

All formatting belongs in presenters.

---

### Prefer Presenters Over Blade Logic

If formatting is needed:

✔ Add a presenter
✖ Do not add complex Blade conditions

---

### Keep Controllers Thin

Controllers should only:

* fetch entries
* paginate
* pass to mapper

---

### Avoid Adding Dependencies

Ledgerly UI intentionally avoids:

* JavaScript frameworks
* UI component libraries
* CSS frameworks

Please keep it dependency-light.

---

## Tests

All changes must include tests when applicable.

Especially important:

* TimelineMapper behavior
* Presenter formatting
* Grouping logic

Snapshot tests are encouraged for UI output.

---

## Documentation

If you change:

* public API
* configuration
* behavior visible to users

Update:

* README
* CONTRACT.md
* relevant doc-blocks

---

## Pull Request Guidelines

Please:

* Keep PRs small and focused
* Include tests
* Explain reasoning clearly
* Avoid unrelated refactors

---

## What Not to Add (Without Discussion)

Please open an issue before proposing:

* real-time updates
* filtering UI
* search UI
* dashboards
* heavy styling
* authorization features

These may belong in separate packages.

---

## Philosophy

Ledgerly UI values:

* clarity over cleverness
* boring code over magic
* explicit behavior over hidden behavior

If a change makes the code harder to understand, it probably isn't right.

---

## Thank You

Contributions, feedback, and ideas are always welcome.
