JSON Response
=============

``createResponseFromPayload()`` is the most convenient way to return JSON from this package.
It creates a ``FastForward\Http\Message\JsonResponse`` and returns it as ``PayloadResponseInterface``.

Default Behavior
----------------

- status code: ``200``
- content type: ``application/json; charset=utf-8``
- body: a JSON encoding of the provided payload
- extra capability: access to the original payload through ``getPayload()``

Example
-------

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactoryInterface;

   $responseFactory = $container->get(ResponseFactoryInterface::class);

   $response = $responseFactory
       ->createResponseFromPayload([
           'success' => true,
           'data' => ['id' => 10, 'name' => 'Alice'],
       ])
       ->withStatus(201);

Reading Or Replacing The Payload
--------------------------------

The returned response body is a payload-aware JSON stream.
That means you can inspect or replace the payload without decoding the body manually.

.. code-block:: php

   $payload = $response->getPayload();

   $updatedResponse = $response->withPayload([
       ...$payload,
       'meta' => ['cached' => false],
   ]);

When To Prefer A Payload Stream Instead
---------------------------------------

Use :doc:`stream-usage` when you want to attach JSON to a response with a custom status or manually controlled headers.

Gotchas
-------

- The payload must be JSON-encodable
- Resources are not allowed and will raise an exception
- Invalid JSON encoding will bubble up from the underlying ``JsonStream``
