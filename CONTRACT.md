# CONTRACT.md


# Ledgerly UI – Contract Surface

This document defines the **public contracts** and **behavioral guarantees** of `ledgerly-app/ui`.

If behavior or APIs described here change, it must be done in a **minor or major version** with clear release notes.

Anything not described here should be considered **internal** and may change without notice.

---

## Purpose

Ledgerly UI provides a **read-only timeline viewer** for ledger entries created by `ledgerly-app/core`.

It is a **presentation layer only**.

It does not:
- create ledger entries
- modify ledger entries
- enforce authorization
- perform background processing

---

## Stable Contracts (v0.1.x)

The following are considered stable for the lifetime of the 0.1.x series.

### 1. Timeline Rendering Pipeline

The rendering flow is:

```

LedgerEntry → TimelineMapper → ViewModels → Presenters → Blade

```

The following components are public and stable:

- `TimelineMapper`
- ViewModel classes
- Presenter classes
- Blade view entry points

Internal helper methods are not part of the contract.

---

### 2. ViewModel Shapes

ViewModels expose stable public properties and predictable shapes.

Applications may safely rely on:

- LedgerEntryViewModel fields
- CorrelationGroupViewModel fields
- LedgerTimelineViewModel structure

New fields may be added in minor releases but existing ones will not be removed in 0.1.x.

---

### 3. Presenters

The following presenters are public:

- ActionLabelResolver
- VerbFormatter
- SummaryPresenter
- DiffPresenter
- MetadataPresenter
- SeverityPresenter

Their public methods are stable.

Internal implementation details are not.

---

### 4. Blade Entry Points

The following view files are considered stable override points:

```

timeline.blade.php
_entry.blade.php
_diff.blade.php
_metadata.blade.php
_group.blade.php
_paginator.blade.php

```

Applications may publish and customize these safely.

Markup details inside these templates are **not guaranteed to remain identical**.

---

### 5. Configuration Keys

These keys are stable:

```

layout
per_page
action_labels
show_metadata
hidden_metadata_keys

```

New keys may be added in minor releases.

---

### 6. CSS Namespace

All styles are prefixed:

```

ledgerly-

```

This prefix will remain stable to avoid conflicts.

Exact CSS rules are not guaranteed to remain unchanged.

---

## Non-Contracts

The following are intentionally **not guaranteed**:

- Exact HTML structure
- CSS class combinations beyond namespace
- Pagination markup internals
- Internal mapper implementation details
- Blade partial structure beyond entry points

These may change between minor versions.

---

## Backwards Compatibility Policy

During 0.1.x:

- Breaking changes are avoided whenever possible
- Minor structural changes may occur if necessary
- Clear upgrade notes will always be provided

---

## Relationship to ledgerly-app/core

Ledgerly UI assumes:

- Entries are immutable
- Action names are valid
- Metadata is structured
- Correlation IDs are stable

Changes in core behavior may require coordinated UI updates.

---

## Philosophy

Ledgerly UI prioritizes:

- Predictability
- Simplicity
- Readability
- Testability

Over:
- Visual complexity
- Real-time features
- Heavy interactivity
