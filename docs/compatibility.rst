Compatibility
=============

Version Snapshot
----------------

This page summarizes the compatibility expectations visible in the package metadata.

.. list-table::
   :header-rows: 1

   * - Concern
     - Status
     - Notes
   * - PHP
     - Supported
     - Requires ``^8.3``
   * - PSR-7
     - Supported
     - Returned responses and streams remain PSR-7 compatible
   * - PSR-17
     - Supported
     - The package exposes standard factory interfaces and adds convenience wrappers
   * - PSR-11
     - Supported at the service level
     - Services are container-friendly once registered
   * - Fast Forward container integration
     - First-class
     - ``HttpMessageFactoryServiceProvider`` is designed for this workflow

Important Note About Containers
-------------------------------

The package works naturally with ``fast-forward/container``.
If you use another container, the safest approach is to reproduce the registrations manually unless that container already supports Fast Forward service-provider definitions.

Important Note About Returned Classes
-------------------------------------

The convenience methods return classes from ``fast-forward/http-message`` such as ``JsonResponse`` and ``JsonStream``.
That is expected behavior and part of the public package experience.
