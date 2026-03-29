Empty Response
==============

The `createEmptyResponse` method generates a response with no body, typically used for status codes like 204 (No Content).

Example:
--------

.. code-block:: php

   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $emptyResponse = $responseFactory->createEmptyResponse();

   // With custom status code
   $customEmpty = $responseFactory->createEmptyResponse(202);

Use Cases:
----------
- Indicating successful processing with no content to return
- HTTP OPTIONS or DELETE responses

Best Practices:
---------------
- Use appropriate status codes (204, 202, etc.)
- Add headers if needed (e.g., Allow for OPTIONS)
