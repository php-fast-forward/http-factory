ResponseFactory
===============

Namespace: ``FastForward\Http\Message\Factory``

Purpose
-------

``ResponseFactory`` is the concrete implementation behind ``FastForward\Http\Message\Factory\ResponseFactoryInterface``.
It wraps a PSR-17 response factory and adds convenience methods for common response types.

Constructor
-----------

.. code-block:: php

   final readonly class ResponseFactory implements ResponseFactoryInterface
   {
       public function __construct(
           private Psr\Http\Message\ResponseFactoryInterface $responseFactory,
       ) {}
   }

Behavior
--------

The class has two kinds of methods:

- ``createResponse()`` delegates to the wrapped PSR-17 factory
- the helper methods instantiate Fast Forward response classes directly

Helper Return Types
-------------------

.. list-table::
   :header-rows: 1

   * - Helper method
     - Concrete object returned
   * - ``createResponseFromHtml()``
     - ``FastForward\Http\Message\HtmlResponse``
   * - ``createResponseFromPayload()``
     - ``FastForward\Http\Message\JsonResponse``
   * - ``createResponseFromText()``
     - ``FastForward\Http\Message\TextResponse``
   * - ``createResponseNoContent()``
     - ``FastForward\Http\Message\EmptyResponse``
   * - ``createResponseRedirect()``
     - ``FastForward\Http\Message\RedirectResponse``

Important Detail
----------------

Only ``createResponse()`` uses the wrapped PSR-17 response factory.
The convenience helpers create specialized response objects directly because those response types come from ``fast-forward/http-message``.

Example
-------

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactory;
   use Nyholm\Psr7\Factory\Psr17Factory;

   $factory = new ResponseFactory(new Psr17Factory());

   $response = $factory->createResponseFromPayload([
       'hello' => 'world',
   ]);

Extensibility
-------------

``ResponseFactory`` is ``final`` and ``readonly``.
If you need different helper behavior, prefer composition:

- register your own implementation for ``FastForward\Http\Message\Factory\ResponseFactoryInterface``
- keep using the PSR-17 factory directly for custom response assembly
