---
name: fast-forward-http-factory
description: Create PSR-17 messages, JSON payload responses and streams directly or through Fast Forward HTTP factory services.
license: MIT; see LICENSE
compatibility: Supports fast-forward/http-factory ^1.3 and PHP ^8.3. Requires Composer and declared extensions; inspect the installed version. Earlier releases are outside this contract.
metadata:
  author: Fast Forward
  api-baseline: fast-forward/http-factory ^1.3
---

# Create HTTP messages and payload responses

Use this skill for an application consuming `fast-forward/http-factory:^1.3`.
Read its instructions, manifest/lockfile and installed source before editing.
Run `composer show fast-forward/http-factory`. For versions outside this contract,
inspect matching documentation; do not silently upgrade the application.

## First working integration

Requires PHP ^8.3, Composer's application autoloader and this package's runtime
dependencies.
With authority to install the dependency:

```sh
composer require 'fast-forward/http-factory:^1.3'
```

Create `app.php` in the application root alongside composer.json/vendor:

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use FastForward\Http\Message\Factory\ResponseFactory;
use FastForward\Http\Message\Factory\StreamFactory;
use Nyholm\Psr7\Factory\Psr17Factory;

$psr17 = new Psr17Factory();
$responses = new ResponseFactory($psr17);
$streams = new StreamFactory($psr17);
$response = $responses->createResponseFromPayload(['ready' => true]);
if ($response->getPayload() !== ['ready' => true]
    || json_decode((string) $response->getBody(), true, flags: JSON_THROW_ON_ERROR) !== ['ready' => true]
    || $responses->createResponseNoContent()->getStatusCode() !== 204
    || (string) $streams->createStream('hello') !== 'hello') {
    throw new RuntimeException('Message factory output differs.');
}

echo "integration ready\n";
```

Run `php app.php`. It throws on a wrong result; success prints
`integration ready`. It uses no production data and starts no server.

## Wiring and failure boundaries

The public namespace is `FastForward\Http\Message\Factory`, even though Composer calls this package `fast-forward/http-factory`. Direct construction needs a PSR-17 delegate; Nyholm Psr17Factory is already supplied transitively. The extended ResponseFactoryInterface and StreamFactoryInterface add payload helpers. PSR interfaces retain their narrower standard API.

For configuration-driven applications put `HttpMessageFactoryServiceProvider::class` (namespace `FastForward\Http\Message\Factory\ServiceProvider`) in ArrayConfig under `FastForward\Container\ContainerInterface::class`, pass it to `FastForward\Container\container($config)`, and resolve the desired interface. The raw list becomes the `config.`-prefixed container entry. A provider-only application may call `container(HttpMessageFactoryServiceProvider::class)`.

PSR-17 interface aliases share the Psr17Factory service; the extended response/stream wrappers are separate cached services. To override them supply an ArrayServiceProvider first. Factory methods create new messages. The default ServerRequestInterface service is created from globals and can be cached; call the ServerRequestCreator explicitly for each request in a worker. Payload encoding errors propagate; missing stream files fail rather than creating an empty body. A 204 response has no body; redirects default to 302 and permanent redirects use 301.

The helper tries aggregate sources in registration order. A PSR container or
not-found exception from one source permits fallback to another source; other
throwables propagate. Source priority is therefore the first successful resolution,
not a guarantee that an earlier broken factory terminates lookup. Nested provider
list errors during helper composition are caught; if services are absent, inspect
the raw configuration and resolve the provider directly to diagnose the failure.

## Verify integration

Run the [complete example](examples/integration.php) against the application's
autoloader in a disposable process. It checks success and negative cases:

```sh
php /path/to/fast-forward-http-factory/examples/integration.php ./vendor/autoload.php
```

Expected final marker: `fast-forward-http-factory: ok`. Keep application-specific regression
tests in its existing PHPUnit suite, with each fixture class in its same-named
file. File copying, host discovery and completed agent tasks are different checks.
For optional copying/synchronization load
[installation and lifecycle](references/installation.md).
