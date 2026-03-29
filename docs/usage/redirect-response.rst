Redirect Response
=================

The `createRedirectResponse` method creates a redirect response to a given URI, with a customizable status code (default 302).

Example:
--------

.. code-block:: php

   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $redirect = $responseFactory->createRedirectResponse('/login');

   // With custom status code
   $permanentRedirect = $responseFactory->createRedirectResponse('/new-url', 301);

Use Cases:
----------
- Redirecting after form submissions
- Enforcing authentication or authorization
- URL rewrites and canonicalization

Best Practices:
---------------
- Use 301 for permanent redirects, 302 for temporary
- Always validate and sanitize redirect URIs
