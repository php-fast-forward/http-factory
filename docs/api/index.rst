API Reference
=============

This package is intentionally small, so the API surface is easy to learn.
There are five main pieces to understand:

.. list-table::
   :header-rows: 1

   * - Type
     - Role
   * - ``HttpMessageFactoryServiceProvider``
     - Registers aliases and concrete services in the container
   * - ``ResponseFactoryInterface``
     - Defines the response helper methods on top of PSR-17
   * - ``ResponseFactory``
     - Concrete decorator that implements the response helper methods
   * - ``StreamFactoryInterface``
     - Defines the payload-stream helper method on top of PSR-17
   * - ``StreamFactory``
     - Concrete decorator that implements the stream helper methods

.. toctree::
   :maxdepth: 2
   :caption: API Reference

   response-factory-interface
   response-factory
   stream-factory-interface
   stream-factory
   service-provider
