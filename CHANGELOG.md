# Changelog

All notable changes to `ledgerly-app/ui` will be documented in this file

## 0.1.0 - 2026-02-12

### Ledgerly UI v0.1.0

Initial public release of **Ledgerly UI**, a Blade-based timeline viewer for applications using `ledgerly-app/core`.

This release focuses on providing a **stable, predictable, and dependency-light presentation layer** for audit logs and activity timelines.


---

#### Highlights

* Timeline rendering for ledger entries
* Correlation grouping (transaction-style blocks)
* Severity indicators and escalation
* Diff visualization
* Metadata display
* Pagination with custom renderer
* Snapshot-testable Blade structure
* Publishable views, configuration, and assets

This release intentionally prioritizes **clarity and reliability over feature breadth**.


---

#### Features

##### Timeline Rendering

Ledger entries are displayed in a structured timeline with:

* actor
* action
* target
* timestamp
* severity indicator

Rendering is deterministic and optimized for readability.


---

##### Correlation Groups

Entries sharing a `correlation_id` are grouped visually.

Grouping is:

* temporal (adjacent entries only)
* read-only
* non-destructive

Severity is automatically escalated to the highest level within the group.


---

##### Diff Presentation

Attribute changes are rendered in a structured table format:

* field name
* before value
* after value

Diff formatting is handled by a dedicated presenter to keep Blade templates simple.


---

##### Metadata Display

Metadata is normalized and displayed in a collapsible section.

Supported metadata types:

* strings
* numbers
* booleans
* arrays
* objects (JSON encoded)

Hidden metadata keys can be configured.


---

##### Action Label Resolution

Actions are humanized automatically:

```
invoice.updated → Invoice Updated
user.logged_in → User Logged In

```
Custom labels can be defined in configuration.


---

##### Summary Formatting

Readable summaries are generated automatically:

```
John updated Invoice #42
System logged in
Alice approved Order #15

```
Grammar is handled by presenters rather than Blade templates.


---

##### Custom Pagination

A lightweight paginator view is included that:

* avoids CSS framework dependencies
* renders consistently across applications
* is easy to override


---

##### Customizable Layout and Views

Applications may override:

* layout
* timeline templates
* entry rendering
* diff display
* metadata display

All views are publishable.


---

##### Minimal CSS

Ledgerly UI ships with a small, neutral stylesheet designed to:

* avoid conflicts
* work in any Laravel application
* be easy to override

All classes are namespaced with:

```
ledgerly-

```

---

#### Testing

This release includes:

* Presenter unit tests
* Timeline mapper tests
* Snapshot tests for rendered output

The architecture is designed to make UI behavior deterministic and testable.


---

#### Documentation

The repository now includes:

* [README](https://github.com/ledgerly-app/ui/blob/main/README.md)
* [CONTRACT](https://github.com/ledgerly-app/ui/blob/main/CONTRACT.md)
* [CONTRIBUTING](https://github.com/ledgerly-app/ui/blob/main/CONTRIBUTING.md)

These documents define:

* supported contracts
* contribution guidelines
* customization points


---

#### Requirements

* PHP 8.2+
* Laravel 11+
* ledgerly-app/core ^0.1


---

#### Limitations (By Design)

Ledgerly UI intentionally does not provide:

* real-time updates
* dashboards or analytics
* filtering UI
* search UI
* authorization or access control

These concerns belong to the host application or higher-level packages.


---

#### Stability

This is a **0.1.0** release.

During the 0.x series:

* APIs are relatively stable
* minor structural changes may occur
* breaking changes will be clearly documented


---

#### Acknowledgements

Ledgerly UI is built with the philosophy that audit logs should be:

* readable
* predictable
* testable
* boring in the best possible way


---

#### Next Steps

Planned areas of exploration:

* timeline filtering primitives
* improved correlation visualization
* optional severity theming
* groundwork for ledgerly/cloud integration
