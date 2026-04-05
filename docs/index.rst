FastForward HTTP Factory
========================

``fast-forward/http-factory`` helps you bootstrap HTTP message factories quickly in Fast Forward applications.
It combines three pieces that beginners often need at the same time:

- a service provider that wires common HTTP services into the container
- the standard PSR-17 factory interfaces for requests, responses, streams, URIs, and uploaded files
- Fast Forward convenience factories for common response and payload-stream scenarios

The package is intentionally small. It does not replace a router, middleware dispatcher, or full HTTP kernel.
Its job is to make the creation of PSR-7 and PSR-17 objects predictable and easy to reuse.

What You Get
------------

- ``Nyholm\Psr7\Factory\Psr17Factory`` registered once and reused through multiple PSR-17 aliases
- ``Nyholm\Psr7Server\ServerRequestCreator`` and ``ServerRequestInterface::class`` resolution from PHP globals
- ``FastForward\Http\Message\Factory\ResponseFactory`` for HTML, JSON, text, redirect, and no-content responses
- ``FastForward\Http\Message\Factory\StreamFactory`` for regular PSR-17 streams plus payload-aware JSON streams

Useful Links
------------

- `GitHub Repository <https://github.com/php-fast-forward/http-factory>`_
- `Packagist <https://packagist.org/packages/fast-forward/http-factory>`_
- `Issue Tracker <https://github.com/php-fast-forward/http-factory/issues>`_
- `Coverage Report <https://php-fast-forward.github.io/http-factory/coverage/index.html>`_
- `Testdox Report <https://php-fast-forward.github.io/http-factory/coverage/testdox.html>`_

.. toctree::
   :maxdepth: 2
   :caption: Contents:

   getting-started/index
   usage/index
   advanced/index
   api/index
   links/index
   faq
   compatibility
