# 🚀 FastForward HTTP Factory

[![PHP Version](https://img.shields.io/badge/PHP-^8.1-8892BF?logo=php)](https://www.php.net/)
[![License](https://img.shields.io/github/license/php-fast-forward/http-factory)](https://opensource.org/licenses/MIT)
[![CI](https://github.com/php-fast-forward/http-factory/actions/workflows/tests.yml/badge.svg)](https://github.com/php-fast-forward/http-factory/actions)

A [PSR-11](https://www.php-fig.org/psr/psr-11/) compatible service provider that registers a fully functional set of [PSR-17](https://www.php-fig.org/psr/psr-17/) and [PSR-7](https://www.php-fig.org/psr/psr-7/) HTTP factories using [Nyholm PSR-7](https://github.com/Nyholm/psr7) and [Nyholm ServerRequestCreator](https://github.com/Nyholm/psr7-server).

Designed to work out of the box with the [`php-fast-forward/container`](https://github.com/php-fast-forward/container) autowiring system.

---

## 📦 Installation

```bash
composer require fast-forward/http-factory
```

## ✅ Features
- Registers the Psr17Factory as the base implementation for all PSR-17 interfaces
- Registers the ServerRequestCreator using InvokableFactory
- Provides ServerRequestInterface::class using fromGlobals() via MethodFactory
- Aliases:
  - RequestFactoryInterface
  - ResponseFactoryInterface
  - ServerRequestFactoryInterface
  - StreamFactoryInterface
  - UploadedFileFactoryInterface
  - UriFactoryInterface

## 🛠️ Usage

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
```

## 🔧 Services Registered

The following services will be automatically registered in your container when using `HttpMessageFactoryServiceProvider`:

| Service Interface                                     | Implementation Source                                |
|------------------------------------------------------|------------------------------------------------------|
| `Psr\Http\Message\RequestFactoryInterface`           | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Psr\Http\Message\ResponseFactoryInterface`          | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Psr\Http\Message\ServerRequestFactoryInterface`     | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Psr\Http\Message\StreamFactoryInterface`            | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Psr\Http\Message\UploadedFileFactoryInterface`      | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Psr\Http\Message\UriFactoryInterface`               | `Nyholm\Psr7\Factory\Psr17Factory` (via alias)       |
| `Nyholm\Psr7\Factory\Psr17Factory`                   | Registered via `InvokableFactory`                    |
| `Nyholm\Psr7Server\ServerRequestCreator`             | Registered via `InvokableFactory`, with dependencies |
| `Psr\Http\Message\ServerRequestInterface`            | Created by calling `fromGlobals()` on `ServerRequestCreator` via `MethodFactory` |

---

## 📂 License

This package is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!  
Feel free to open a [GitHub Issue](https://github.com/php-fast-forward/http-factory/issues) or submit a Pull Request.
