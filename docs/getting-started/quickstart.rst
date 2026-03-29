Quickstart
==========

Quick usage example
-------------------

After installing and configuring the service provider, you can easily obtain the factories and create HTTP objects:

.. code-block:: php

   use Psr\Http\Message\RequestFactoryInterface;
   use Psr\Http\Message\ServerRequestInterface;

   // Getting the request factory
   $requestFactory = $container->get(RequestFactoryInterface::class);
   $request = $requestFactory->createRequest('GET', '/');

   // Getting the ServerRequest from globals
   $serverRequest = $container->get(ServerRequestInterface::class);

   // Creating a custom response
   use FastForward\Http\Message\Factory\ResponseFactoryInterface;
   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $response = $responseFactory->createResponse(200);

   // Creating a JSON response
   $jsonResponse = $responseFactory->createResponseFromPayload(['ok' => true]);

   // Creating an HTML response
   $htmlResponse = $responseFactory->createResponseFromHtml('<h1>Hello</h1>');
