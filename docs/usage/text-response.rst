Text Response
=============

``createResponseFromText()`` creates a plain-text response backed by ``FastForward\Http\Message\TextResponse``.

Default Behavior
----------------

- status code: ``200``
- content type: ``text/plain; charset=utf-8``
- body: the string you pass in

Example
-------

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactoryInterface;

   $responseFactory = $container->get(ResponseFactoryInterface::class);

   $response = $responseFactory
       ->createResponseFromText('Service is warming up')
       ->withStatus(503);

Good Uses
---------

- health and readiness endpoints
- debugging endpoints
- CLI-oriented or webhook responses where structured JSON is unnecessary

Tip
---

If the output is structured data, prefer :doc:`json-response`.
Plain text is best when humans will read the body directly.
