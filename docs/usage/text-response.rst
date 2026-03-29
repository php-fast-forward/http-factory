Text Response
=============

The `createResponseFromText` method generates a plain text response with the Content-Type set to `text/plain`.

Example:
--------

.. code-block:: php

   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $textResponse = $responseFactory->createResponseFromText('Plain text output');

Use Cases:
----------
- Returning logs or debug output
- Simple status messages

Best Practices:
---------------
- Use for endpoints where HTML or JSON is not required
- Set status codes to reflect the result (e.g., 200 for OK, 400 for errors)
