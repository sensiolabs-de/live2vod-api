# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a PHP library providing value objects for the ORF Live2VOD API, specifically the Form domain objects used for dynamic form configuration in CMS integrations.

## Architecture

The library contains value objects in the `SensioLabs\Live2Vod\Api\Value\Form` namespace:

### Form Value Objects (`src/Value/Form/`)

Strongly-typed value objects for dynamic form configuration:
- `Field`: Individual form field with type, name, label, validation, etc.
- `Fields`: Collection of form fields with validation
- `FieldType`: Enum for field types (TEXT, TEXTAREA, SELECT, etc.)
- `Button`: Form button configuration
- `Buttons`: Collection of buttons
- `Action`: Dynamic field actions (show/hide based on other fields)
- `Actions`: Collection of actions
- `Name`, `Label`, `Placeholder`, `Help`, `Description`: String value objects for form metadata
- `Icon`: Icon identifier for UI elements
- `Endpoint`: URL endpoint for form submission or actions
- `ActionOn`: Enum for when actions should trigger (CHANGE, etc.)

## Automatic Synchronization

**IMPORTANT**: The Form value objects in this package are automatically synchronized from the main ORF Live2VOD repository.

### Sync Script

The sync is performed by `.github/sync-live2vod-api.sh`, which is configurable via the `SYNC_DIRS` array:

```bash
SYNC_DIRS=(
    "."           # Root Form directory (files only)
    "Field"       # Field implementations
    "Exception"   # Exception classes
)
```

**Sync Process:**
1. Cleans the target directory `live2vod-api/src/Value/Form/`
2. Copies configured directories from `src/Domain/Session/Form/`
3. Transforms all namespaces from `App\Domain\Session\Form` to `SensioLabs\Live2Vod\Api\Value\Form`
4. Updates all use statements to reference the new namespace

**Manual Sync:**
```bash
.github/sync-live2vod-api.sh
```

**GitHub Actions Workflow (to be added manually):**

A workflow should be created to trigger on changes to `src/Domain/Session/Form/**` and automatically run the sync script.

### Development Guidelines

- **DO NOT** manually edit files in `live2vod-api/src/Value/Form/` - they will be overwritten by the sync script
- All changes to Form value objects must be made in the main repository at `src/Domain/Session/Form/`
- To sync new subdirectories, add them to the `SYNC_DIRS` array in `.github/sync-live2vod-api.sh`
- The sync script ensures this package stays in sync automatically

## Future: Subtree Split

This package is prepared for subtree splitting to allow it to be maintained as a separate repository and distributed via Composer. When implemented, this will enable other systems to use these value objects via:

```bash
composer require sensiolabs-de/live2vod-api
```

## Code Standards

- PHP 8.4 with strict types declaration
- All value objects are readonly classes
- Use webmozart/assert for validation
- Use oskarstark/trimmed-non-empty-string for non-empty string values
- Use oskarstark/enum-helper Comparable trait for enum comparisons

## Testing

Future: Tests should be added in `tests/Value/Form/` directory following the same structure as the main repository.
