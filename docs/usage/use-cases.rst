Use Cases
=========

This section presents real-world scenarios for using FastForward HTTP Factory in your applications.

REST API Example
----------------

.. code-block:: php

   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $data = ['user' => ['id' => 1, 'name' => 'Alice']];
   $response = $responseFactory->createResponseFromPayload($data);

HTML Page Rendering
-------------------

.. code-block:: php

   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $html = '<h1>Welcome!</h1>';
   $response = $responseFactory->createResponseFromHtml($html);

Redirect After Login
--------------------

.. code-block:: php

   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $response = $responseFactory->createRedirectResponse('/dashboard');

Streaming a File
----------------

.. code-block:: php

   $streamFactory = $container->get(StreamFactoryInterface::class);
   $stream = $streamFactory->createStreamFromFile('/tmp/report.pdf');
   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $response = $responseFactory->createResponse(200)->withBody($stream);

See the API Reference for more advanced usage and customization options.
