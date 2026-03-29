JSON Response
=============

The `createResponseFromPayload` method creates a JSON response from an associative array, automatically setting the Content-Type to `application/json`.

In most cases, this method returns an instance of `FastForward\Http\Message\JsonResponse`, a PSR-7 compatible response object with extra features for working with JSON payloads. You can use it as a standard response, but it also provides convenient access to the original payload and encoding options.

Example:
--------

.. code-block:: php

   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $jsonResponse = $responseFactory->createResponseFromPayload(['success' => true, 'data' => [1, 2, 3]]);

   // $jsonResponse is an instance of FastForward\Http\Message\JsonResponse

Use Cases:
----------
- Building REST APIs
- Returning AJAX responses
- Sending structured data to clients

Best Practices:
---------------
- Ensure your payload is serializable to JSON
- Handle encoding errors gracefully
- Set appropriate status codes for errors or success
