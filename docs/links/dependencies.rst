Dependencies
============

This package is small, but its behavior depends on a few important runtime packages.
Knowing what each dependency does makes the architecture easier to understand.

Direct Runtime Dependencies
---------------------------

.. list-table::
   :header-rows: 1

   * - Package
     - Why it is used here
   * - ``fast-forward/container``
     - Provides the alias, invokable, and method factory helpers used by the service provider
   * - ``fast-forward/http-message``
     - Provides ``HtmlResponse``, ``JsonResponse``, ``TextResponse``, ``EmptyResponse``, ``RedirectResponse``, and ``JsonStream``
   * - ``nyholm/psr7-server``
     - Provides ``ServerRequestCreator`` for building a current request from PHP globals
   * - ``psr/http-factory``
     - Provides the PSR-17 interfaces implemented and exposed by the package

Important Indirect Runtime Dependency
-------------------------------------

``nyholm/psr7`` is the underlying PSR-7 implementation used by the specialized Fast Forward response and stream objects.
That is why the container aliases point to ``Nyholm\Psr7\Factory\Psr17Factory``.

Development Dependency
----------------------

- ``fast-forward/dev-tools`` is used for the local quality and development workflow, not for runtime behavior

Practical Reading
-----------------

If you are trying to understand "where a concrete object comes from", this is the usual flow:

1. the service provider wires aliases
2. the PSR-17 services resolve to Nyholm's factory
3. the Fast Forward helper factories create response and stream classes from ``fast-forward/http-message``
