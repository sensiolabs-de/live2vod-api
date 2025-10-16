# Live2VOD API

A PHP library for interacting with the ORF Live2VOD system, providing API clients, domain objects, webhook handling, and DRM token generation.

## Overview

This package provides a complete SDK for the ORF Live2VOD system, including:
- HTTP client for session management
- Domain value objects (Clip, Session, Form, Marker, etc.)
- Webhook event handling and factories
- DRM token generation
- Request/Response DTOs for API communication
- Foundry factories for testing

## Installation

This package is intended to be installed via Composer:

```bash
composer require sensiolabs-de/live2vod-api
```

## Usage

### Session API Client

```php
use SensioLabs\Live2Vod\Api\Client;
use SensioLabs\Live2Vod\Api\SessionApi;
use SensioLabs\Live2Vod\Api\Domain\Api\Request\CreateSessionRequest;
use SensioLabs\Live2Vod\Api\Domain\Identifier\SessionId;
use Symfony\Component\HttpClient\HttpClient;

// Initialize the client
$httpClient = HttpClient::create();
$client = new Client($httpClient, 'https://api.example.com');
$sessionApi = new SessionApi($client);

// Create a session
$request = new CreateSessionRequest(/* ... */);
$response = $sessionApi->create($request);

// Get session details
$session = $sessionApi->get($response->id);

// Delete a session
$sessionApi->delete($response->id);
```

### Domain Objects

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

### Webhook Handling

```php
use SensioLabs\Live2Vod\Api\Webhook\WebhookEventFactory;
use SensioLabs\Live2Vod\Api\Domain\Webhook\Event\ClipCompletedEvent;

$factory = new WebhookEventFactory();

// Parse webhook payload
$event = $factory->createFromPayload($webhookPayload);

if ($event instanceof ClipCompletedEvent) {
    // Handle clip completed event
    $clipId = $event->clipId;
    $sessionId = $event->sessionId;
}
```

### DRM Token Generation

```php
use SensioLabs\Live2Vod\Api\DRM\TokenGenerator;
use SensioLabs\Live2Vod\Api\Domain\DRM\GeoLocation;

$tokenGenerator = new TokenGenerator('your-secret-key');

$token = $tokenGenerator->generate(
    sessionId: $sessionId,
    clipId: $clipId,
    geoLocation: GeoLocation::AT,
    expiresAt: new \DateTimeImmutable('+1 hour')
);
```

## Available Components

### API Clients

#### `Client` & `ClientInterface`
HTTP client wrapper for making API requests with customizable HTTP client support.

#### `SessionApi` & `SessionApiInterface`
High-level API for session management:
- `create(CreateSessionRequest)` - Create new session
- `get(SessionId)` - Retrieve session details
- `delete(SessionId)` - Delete session

#### `NullSessionApi`
Null object implementation for testing/development.

### API Request/Response (`Domain\Api`)

#### Request Objects
- `CreateSessionRequest` - DTO for session creation

#### Response Objects
- `CreateSessionResponse` - Response after session creation
- `SessionResponse` - Complete session details

### DRM Components

#### `TokenGenerator` & `TokenGeneratorInterface`
Generate DRM tokens for protected content access.

#### Domain Objects (`Domain\DRM`)
- `Token` - DRM token value object with expiration
- `GeoLocation` - Geographic location enum for geo-blocking

### Webhook Components

#### `WebhookEventFactory` & `WebhookEventFactoryInterface`
Factory for creating webhook event objects from payloads.

#### Webhook Events (`Domain\Webhook\Event`)
- `ClipCreatedEvent` - Fired when clip is created
- `ClipCompletedEvent` - Fired when clip processing completes
- `ClipUpdatedEvent` - Fired when clip is updated
- `ClipErrorEvent` - Fired when clip processing fails
- `ClipDeletedEvent` - Fired when clip is deleted
- `ClipsCompletedEvent` - Fired when all session clips complete
- `ClipsFailedEvent` - Fired when session clips fail
- `SessionDeletedEvent` - Fired when session is deleted

#### Webhook Domain Objects (`Domain\Webhook`)
- `Event` - Base webhook event interface
- `Clip` - Clip representation in webhooks
- `Payload\ClipStatusCallbackPayload` - Payload for clip status callbacks
- `Payload\ClipDeletedCallbackPayload` - Payload for clip deletion callbacks

### Factory Components

- `AssetsFactory` - Creates clip assets from API responses
- `CreateSessionRequestFactory` - Creates session requests
- `SessionConfigFactory` - Creates session configurations
- `TokenFactory` - Creates DRM tokens
- `Webhook\WebhookEventFactory` - Creates webhook events

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
- `Exception\InvalidUrlException` - Thrown for invalid URLs
- `Domain\Clip\Exception\FileNotFoundException` - Thrown when file not found
- `Domain\Session\Form\Exception\FieldNotFoundException` - Thrown when accessing non-existent field
- `Domain\Session\Form\Exception\FieldTypeMismatchException` - Thrown when field type doesn't match expected type

### Testing Utilities

The package includes Foundry factories for easy test data generation:
- Located in `src/Factory/` namespace
- Integrated with `zenstruck/foundry` for seamless testing
- Use in your tests to create realistic mock data

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
- symfony/http-kernel ^6.4 || ^7.0
- symfony/uid ^6.4 || ^7.0
- thecodingmachine/safe ^3.0
- webmozart/assert ^1.11
- zenstruck/foundry ^2.7.5

## License

Proprietary
