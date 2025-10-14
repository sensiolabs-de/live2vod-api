# Live2VOD API

Live2VOD API related objects.

## Overview

This package contains reusable domain objects from the ORF Live2VOD system, including Clip, Session, Form, Identifier, and Marker value objects used throughout the application.

## Installation

This package is intended to be installed via Composer:

```bash
composer require sensiolabs-de/live2vod-api
```

## Usage

The package provides domain objects in the `SensioLabs\Live2Vod\Api\Domain` namespace:

```php
use SensioLabs\Live2Vod\Api\Domain\Identifier\ClipId;
use SensioLabs\Live2Vod\Api\Domain\Clip\Status;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Field\StringField;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Fields;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Name;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Label;

// Create identifiers
$clipId = ClipId::fromString('01HQX...');

// Create form fields
$field = new StringField(
    name: new Name('title'),
    label: new Label('Video Title'),
    required: true,
);

$fields = Fields::fromArray([
    ['type' => 'string', 'name' => 'title', 'label' => 'Title', 'required' => true],
    ['type' => 'textarea', 'name' => 'description', 'label' => 'Description'],
]);
```

## Available Components

### Identifiers (`Domain\Identifier`)
- `ClipId` - ULID-based identifier for clips
- `SessionId` - ULID-based identifier for sessions
- `MarkerId` - ULID-based identifier for markers
- `IdTrait` - Shared trait for identifier value objects

### Clip Domain (`Domain\Clip`)
- `Status` - Enum for clip status (created, recording, completed, failed)
- `StreamType` - Enum for stream types (HLS, DASH, MP4)
- `Assets` - Collection of clip assets (streams and files)
- `Stream` - Stream asset with URL and type
- `File` - File asset with URL, type, and bitrate
- `Bitrate` - Value object for bitrate (e.g., 1080p, 720p)
- `FileType` - Enum for file types (MP4, etc.)
- `Filepath` - Value object for file paths
- `Thumbnail` - Thumbnail URL value object
- `FormData` - Dynamic form data for clips

### Marker Domain (`Domain\Marker`)
- `Type` - Enum for marker types (chapter, advertisement, intro, blackfade, mute, beitrag)

### Session Domain (`Domain\Session`)
- `Config` - Session configuration
- `Channel` - Channel identifier
- `Form` - Dynamic form configuration
- `FormConfig` - Form configuration wrapper

### Form Value Objects (`Domain\Session\Form`)
- `Name`, `Label`, `Placeholder`, `Help`, `Description` - String value objects for form metadata
- `Icon` - Icon identifier for UI elements
- `Endpoint` - URL endpoint for form submission or actions
- `FieldType` - Enum for field types (STRING, TEXTAREA, SELECT, NUMBER, DATE, etc.)
- `ActionOn` - Enum for action triggers (CHANGE, etc.)
- `Field` - Base form field
- `Fields` - Collection of form fields with validation and type-safe access
- `Button` - Form button definition
- `Buttons` - Collection of form buttons
- `Action` - Dynamic field action
- `Actions` - Collection of dynamic field actions

### Field Types (`Domain\Session\Form\Field`)
- `StringField` - Text input with validation (minLength, maxLength, pattern)
- `TextareaField` - Multi-line text input
- `NumberField` - Numeric input with min/max validation
- `DateField` - Date input
- `DateTimeField` - DateTime input
- `SelectField` - Single select dropdown
- `MultiSelectField` - Multiple select dropdown
- `BooleanField` - Checkbox/toggle
- `ImageField` - Image upload field
- `UrlField` - URL input with validation

### Common Value Objects (`Domain`)
- `Title` - Title value object
- `Url` - URL value object with validation

### Exceptions
- `Domain\Clip\Exception\FileNotFoundException` - Thrown when file not found
- `Domain\Session\Form\Exception\FieldNotFoundException` - Thrown when accessing non-existent field
- `Domain\Session\Form\Exception\FieldTypeMismatchException` - Thrown when field type doesn't match expected type
- `Exception\InvalidUrlException` - Thrown for invalid URLs

## Development

### Automatic Sync

The Domain objects in this package are automatically synchronized from the main ORF Live2VOD repository using `.github/sync-live2vod-api.sh`.

**Sync Configuration:**

The sync script uses key-value mappings to copy directories:

```bash
SYNC_MAPPINGS=(
    "src/Domain:live2vod-api/src/Domain"
)
```

To customize sync behavior, edit the mappings in `.github/sync-live2vod-api.sh`. Supports:
- Directory mappings: `"src/Domain:live2vod-api/src/Domain"`
- File mappings with renaming: `"src/Domain/Foo.php:live2vod-api/src/Domain/Bar.php"`

**How it works:**

1. Copies all files from `src/Domain/` recursively
2. Transforms namespaces from `App\Domain` to `SensioLabs\Live2Vod\Api\Domain`
3. Updates all use statements to reference the new namespace
4. Validates PHP 8.1 syntax compatibility with `php -l`
5. Auto-detects and copies missing dependencies
6. Can be run manually: `bash .github/sync-live2vod-api.sh`

**PHP 8.1 Validation:**

The sync script automatically validates all copied files for PHP 8.1 compatibility:
- Runs `php -l` syntax check on every file
- Catches PHP 8.2+ features like readonly classes
- Exits with error if any file fails validation
- Ensures package maintains PHP 8.1.2+ compatibility

### Subtree Split

This package is automatically split into the [sensiolabs-de/live2vod-api](https://github.com/sensiolabs-de/live2vod-api) repository using GitHub Actions.

**Workflow Configuration:**

The split workflow (`.github/workflows/split-live2vod-api.yaml`) triggers on push to `develop` when `live2vod-api/` files change:

```yaml
on:
    push:
        branches:
            - develop
        paths:
            - 'live2vod-api/**'
```

**Setup Requirements:**

1. Create GitHub Personal Access Token with repository write access
2. Add as repository secret: `LIVE2VOD_API_SPLIT_TOKEN`
3. Workflow uses `symplify/github-action-monorepo-split` to extract subtree
4. Pushes to `sensiolabs-de/live2vod-api` repository on `main` branch

**Manual Split (Alternative):**

If GitHub Actions unavailable, use git subtree:

```bash
cd orf-live2vod
git subtree split --prefix=live2vod-api -b live2vod-api-split
cd ../live2vod-api
git pull ../orf-live2vod live2vod-api-split
git push origin main
```

Or use `splitsh-lite` for better performance:

```bash
splitsh-lite --prefix=live2vod-api/ --origin=develop --target=refs/heads/main
git push git@github.com:sensiolabs-de/live2vod-api.git refs/heads/main
```

## Requirements

- PHP 8.1.2 or higher
- oskarstark/enum-helper ^1.8
- oskarstark/trimmed-non-empty-string ^1.9
- symfony/http-kernel ^7.0
- symfony/uid ^7.0
- thecodingmachine/safe ^2.5
- webmozart/assert ^1.11

## License

Proprietary
