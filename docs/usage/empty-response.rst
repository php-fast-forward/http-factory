No-Content Response
===================

``createResponseNoContent()`` creates a ``204 No Content`` response backed by ``FastForward\Http\Message\EmptyResponse``.

What It Does
------------

- always returns status ``204``
- leaves the body empty
- lets you attach optional headers

Example
-------

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactoryInterface;

   $responseFactory = $container->get(ResponseFactoryInterface::class);

   $response = $responseFactory->createResponseNoContent([
       'X-Resource-Deleted' => 'true',
   ]);

When To Use It
--------------

- successful ``DELETE`` handlers
- ``OPTIONS`` responses with no body
- endpoints where the client only needs the status code and headers

Important Limitation
--------------------

This helper is intentionally specific to ``204 No Content``.
If you need another empty response such as ``202 Accepted``, use the standard PSR-17 method instead.

.. code-block:: php

   use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactoryInterface;

   $psrResponseFactory = $container->get(PsrResponseFactoryInterface::class);

   $acceptedResponse = $psrResponseFactory->createResponse(202);
