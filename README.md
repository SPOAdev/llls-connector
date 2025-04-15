# LLLS License Connector (PHP)
Connector package to verify licenses from [LLLS (Light Laravel License Server)](https://github.com/spoadev/llls) by SPOAdev.

---
## Installation
Add to your project using Composer:
```bash
composer require spoadev/llls-connector
```
## Usage Example
```php
use Llls\Connector\LicenseConnector;

$connector = new LicenseConnector('https://llls.domain.tld');

$response = $connector->verify('LICENSE-KEY', 'end-client-domain.tld');

if (($response['status'] ?? '') === 'valid') {
    $payload = $response['update'] ?? [];

    // Handle update data
    if (!empty($payload)) {
        // Example:
        // $payload['latest_version']
        // $payload['download_url']
        // $payload['changelog']
    }
}
```
## Response Example
```json
{
  "status": "valid",
  "message": "License is valid",
  "expires_at": "2025-07-15 00:00:00",
  "update": {
    "latest_version": "2.3.5",
    "download_url": "https://my.storage.tld/update.zip",
    "changelog": "Performance improvements",
    "force_update": "true"
  }
}
```
## Optional: Guzzle Support
If Guzzle is available, the connector will use it automatically. Otherwise, it will fallback to native PHP cURL.
#### To install Guzzle:
```bash
composer require guzzlehttp/guzzle
```
## Requirements
- PHP 7.4 or higher
- Laravel, WordPress, Symfony, or any PHP environment
- 
## Version
**1.0.0** — Initial release
## Changelog
### 1.0.0 (04/15/2025)
- Initial release
- License verification via POST
- Dynamic update payload support
- Guzzle fallback to cURL
- Compatible with any PHP client
