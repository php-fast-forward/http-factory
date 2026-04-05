# FastForward HTTP Factory

[![PHP Version](https://img.shields.io/badge/PHP-^8.3-8892BF?logo=php)](https://www.php.net/)
[![License](https://img.shields.io/github/license/php-fast-forward/http-factory)](https://opensource.org/licenses/MIT)
[![CI](https://github.com/php-fast-forward/http-factory/actions/workflows/tests.yml/badge.svg)](https://github.com/php-fast-forward/http-factory/actions)

A Fast Forward service provider and helper-factory package for [PSR-17](https://www.php-fig.org/psr/psr-17/) and [PSR-7](https://www.php-fig.org/psr/psr-7/) HTTP objects, built on top of [Nyholm PSR-7](https://github.com/Nyholm/psr7) and [Nyholm ServerRequestCreator](https://github.com/Nyholm/psr7-server).

Designed to work out of the box with the [`php-fast-forward/container`](https://github.com/php-fast-forward/container) autowiring system.

---

## 📦 Installation

```bash
composer require fast-forward/http-factory
```

## Features
- Reuses one `Nyholm\Psr7\Factory\Psr17Factory` instance for the standard PSR-17 interfaces
- Registers `Nyholm\Psr7Server\ServerRequestCreator` and exposes `ServerRequestInterface::class` via `fromGlobals()`
- Exposes `FastForward\Http\Message\Factory\ResponseFactoryInterface` for HTML, JSON, text, redirect, and no-content helpers
- Exposes `FastForward\Http\Message\Factory\StreamFactoryInterface` for payload-aware JSON stream helpers
- Keeps returned objects PSR-7 compatible

## Usage

There are two similarly named response and stream factory interfaces:

- `Psr\Http\Message\ResponseFactoryInterface` and `Psr\Http\Message\StreamFactoryInterface` for plain PSR-17 behavior
- `FastForward\Http\Message\Factory\ResponseFactoryInterface` and `FastForward\Http\Message\Factory\StreamFactoryInterface` for Fast Forward helper methods

If you’re using `fast-forward/container`:
```php
use FastForward\Container\container;
use FastForward\Config\ArrayConfig;
use FastForward\Container\ContainerInterface;

$config = new ArrayConfig([
    ContainerInterface::class => [
        // Reference the service provider by class name
        HttpMessageFactoryServiceProvider::class,
    ],
]);

$container = container($config);

$requestFactory = $container->get(Psr\Http\Message\RequestFactoryInterface::class);
$serverRequest = $container->get(Psr\Http\Message\ServerRequestInterface::class);
$responseFactory = $container->get(FastForward\Http\Message\Factory\ResponseFactoryInterface::class);
$streamFactory = $container->get(FastForward\Http\Message\Factory\StreamFactoryInterface::class);

$request = $requestFactory->createRequest('GET', '/health');

$jsonResponse = $responseFactory->createResponseFromPayload(['ok' => true]);
$htmlResponse = $responseFactory->createResponseFromHtml('<h1>Hello</h1>');
$redirectResponse = $responseFactory->createResponseRedirect('/login');
$noContentResponse = $responseFactory->createResponseNoContent();

$acceptedResponse = $responseFactory
    ->createResponse(202)
    ->withHeader('Content-Type', 'application/json; charset=utf-8')
    ->withBody($streamFactory->createStreamFromPayload(['queued' => true]));
```

## Services Registered

The following services will be automatically registered in your container when using `HttpMessageFactoryServiceProvider`:

| Service Interface                                     | Implementation Source                                |
|------------------------------------------------------|------------------------------------------------------|
| `Psr\Http\Message\RequestFactoryInterface`           | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Psr\Http\Message\ResponseFactoryInterface`          | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Psr\Http\Message\ServerRequestFactoryInterface`     | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Psr\Http\Message\StreamFactoryInterface`            | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Psr\Http\Message\UploadedFileFactoryInterface`      | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Psr\Http\Message\UriFactoryInterface`               | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Nyholm\Psr7Server\ServerRequestCreatorInterface`    | `Nyholm\Psr7Server\ServerRequestCreator` (via alias) |
| `FastForward\Http\Message\Factory\ResponseFactoryInterface` | `FastForward\Http\Message\Factory\ResponseFactory` (via alias) |
| `FastForward\Http\Message\Factory\StreamFactoryInterface` | `FastForward\Http\Message\Factory\StreamFactory` (via alias) |
| `Nyholm\Psr7\Factory\Psr17Factory`                   | Registered via `InvokableFactory`                    |
| `Nyholm\Psr7Server\ServerRequestCreator`             | Registered via `InvokableFactory`, with dependencies |
| `FastForward\Http\Message\Factory\ResponseFactory`   | Registered via `InvokableFactory`                    |
| `FastForward\Http\Message\Factory\StreamFactory`     | Registered via `InvokableFactory`                    |
| `Psr\Http\Message\ServerRequestInterface`            | Created by calling `fromGlobals()` on `ServerRequestCreator` via `MethodFactory` |

## Documentation

The Sphinx documentation under [`docs/`](docs/) covers:

- beginner installation and quickstart flows
- concrete `ResponseFactory` and `StreamFactory` classes
- common response and payload-stream scenarios
- alias mapping, compatibility, dependencies, and troubleshooting

## License

This package is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).

## Contributing

Contributions, issues, and feature requests are welcome!  
Feel free to open a [GitHub Issue](https://github.com/php-fast-forward/http-factory/issues) or submit a Pull Request.
