Use Cases
=========

This page collects small real-world scenarios that new users usually look for first.

Return JSON From An API Endpoint
--------------------------------

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactoryInterface;

   $responseFactory = $container->get(ResponseFactoryInterface::class);

   return $responseFactory->createResponseFromPayload([
       'user' => [
           'id' => 1,
           'name' => 'Alice',
       ],
   ]);

Return An HTML Maintenance Page
-------------------------------

.. code-block:: php

   return $responseFactory
       ->createResponseFromHtml('<h1>Maintenance</h1><p>Please try again later.</p>')
       ->withStatus(503);

Return Plain Text For A Health Check
------------------------------------

.. code-block:: php

   return $responseFactory->createResponseFromText('ok');

Redirect After Authentication
-----------------------------

.. code-block:: php

   return $responseFactory->createResponseRedirect('/dashboard');

Return 204 After A Delete Operation
-----------------------------------

.. code-block:: php

   return $responseFactory->createResponseNoContent([
       'X-Deleted-Resource' => 'account',
   ]);

Return 202 Accepted With A JSON Body
------------------------------------

.. code-block:: php

   use FastForward\Http\Message\Factory\StreamFactoryInterface;

   $streamFactory = $container->get(StreamFactoryInterface::class);

   return $responseFactory
       ->createResponse(202)
       ->withHeader('Content-Type', 'application/json; charset=utf-8')
       ->withBody($streamFactory->createStreamFromPayload([
           'accepted' => true,
           'jobId' => 'sync-123',
       ]));

Create The Current Request From Globals
---------------------------------------

.. code-block:: php

   use Psr\Http\Message\ServerRequestInterface;

   $request = $container->get(ServerRequestInterface::class);

   $method = $request->getMethod();
   $path = $request->getUri()->getPath();

Use The Helpers Without A Container
-----------------------------------

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactory;
   use FastForward\Http\Message\Factory\StreamFactory;
   use Nyholm\Psr7\Factory\Psr17Factory;

   $psr17Factory = new Psr17Factory();
   $responseFactory = new ResponseFactory($psr17Factory);
   $streamFactory = new StreamFactory($psr17Factory);

   $response = $responseFactory->createResponseFromPayload([
       'standalone' => true,
   ]);
