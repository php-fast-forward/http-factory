Stream Usage
============

``FastForward\Http\Message\Factory\StreamFactoryInterface`` extends the PSR-17 stream factory contract with one extra helper: ``createStreamFromPayload()``.

The concrete ``StreamFactory`` behaves like a decorator:

- ``createStream()``, ``createStreamFromFile()``, and ``createStreamFromResource()`` delegate to the wrapped PSR-17 factory
- ``createStreamFromPayload()`` creates a ``FastForward\Http\Message\JsonStream`` directly

Creating A JSON Payload Stream
------------------------------

.. code-block:: php

   use FastForward\Http\Message\Factory\StreamFactoryInterface;

   $streamFactory = $container->get(StreamFactoryInterface::class);

   $stream = $streamFactory->createStreamFromPayload([
       'queued' => true,
       'jobId' => 42,
   ]);

   $payload = $stream->getPayload();

Creating A Custom JSON Response
-------------------------------

This is useful when you want the payload convenience but need a status code or header combination that the response helper methods do not cover directly.

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactoryInterface;
   use FastForward\Http\Message\Factory\StreamFactoryInterface;

   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $streamFactory = $container->get(StreamFactoryInterface::class);

   $response = $responseFactory
       ->createResponse(202)
       ->withHeader('Content-Type', 'application/json; charset=utf-8')
       ->withBody($streamFactory->createStreamFromPayload([
           'accepted' => true,
       ]));

Other Stream Sources
--------------------

.. code-block:: php

   $memoryStream = $streamFactory->createStream('plain content');

   $fileStream = $streamFactory->createStreamFromFile('/tmp/report.txt');

   $resource = fopen('php://temp', 'wb+');
   fwrite($resource, 'resource content');
   rewind($resource);

   $resourceStream = $streamFactory->createStreamFromResource($resource);

Gotchas
-------

- ``createStreamFromPayload()`` expects JSON-encodable data
- resources inside the payload are not supported
- remember to close file handles and resources you open yourself
