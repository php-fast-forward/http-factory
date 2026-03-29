HTML Response
=============

The `createResponseFromHtml` method allows you to quickly generate an HTTP response with HTML content and the correct Content-Type header.

In most cases, this method returns an instance of `FastForward\Http\Message\HtmlResponse`, a PSR-7 compatible response object with extra features for working with HTML content. You can use it as a standard response, but it also provides convenient access to the original HTML and related options.

Example:
--------

.. code-block:: php

   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $htmlResponse = $responseFactory->createResponseFromHtml('<h1>Hello, World!</h1>');

   // $htmlResponse is an instance of FastForward\Http\Message\HtmlResponse

Use Cases:
----------
- Rendering HTML pages in web applications
- Returning error or informational pages

Best Practices:
---------------
- Always sanitize user input before rendering in HTML
- Set additional headers as needed using PSR-7 methods
