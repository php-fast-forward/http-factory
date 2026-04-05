Aliases and Service Mapping
===========================

The service provider uses aliases so that multiple interfaces can reuse the same underlying object.
This keeps the container setup compact and avoids duplicate factory instances.

PSR-17 Alias Group
------------------

All of the following service ids resolve to the same ``Nyholm\Psr7\Factory\Psr17Factory`` instance:

- ``Psr\Http\Message\RequestFactoryInterface``
- ``Psr\Http\Message\ResponseFactoryInterface``
- ``Psr\Http\Message\ServerRequestFactoryInterface``
- ``Psr\Http\Message\StreamFactoryInterface``
- ``Psr\Http\Message\UploadedFileFactoryInterface``
- ``Psr\Http\Message\UriFactoryInterface``

Fast Forward Alias Group
------------------------

The package also exposes convenience aliases:

- ``FastForward\Http\Message\Factory\ResponseFactoryInterface`` resolves to ``FastForward\Http\Message\Factory\ResponseFactory``
- ``FastForward\Http\Message\Factory\StreamFactoryInterface`` resolves to ``FastForward\Http\Message\Factory\StreamFactory``
- ``Nyholm\Psr7Server\ServerRequestCreatorInterface`` resolves to ``Nyholm\Psr7Server\ServerRequestCreator``

Why This Matters
----------------

The alias setup creates a clean separation:

- PSR-17 interfaces give you low-level factory behavior
- Fast Forward interfaces give you convenience methods for common application responses

Overriding A Service
--------------------

If you want different behavior, replace the alias target in your container configuration with your own implementation.
Typical examples include:

- a custom response factory that always adds application-specific headers
- a custom stream factory that uses another payload encoding strategy
- a different request bootstrap process in long-running servers

Before overriding, check your container's precedence rules so you know whether your registration replaces or is replaced by the service-provider definition.
