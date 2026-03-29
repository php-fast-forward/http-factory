ResponseFactoryInterface
=======================

.. code-block:: php

   interface ResponseFactoryInterface extends Psr\Http\Message\ResponseFactoryInterface
   {
       public function createResponseFromHtml(string $html): ResponseInterface;
       public function createResponseFromPayload(array $payload): PayloadResponseInterface;
       public function createResponseFromText(string $text): ResponseInterface;
       public function createRedirectResponse(UriInterface|string $uri, int $status = 302): ResponseInterface;
       public function createEmptyResponse(int $status = 204): ResponseInterface;
   }

Description
-----------

Extends the PSR-17 ResponseFactoryInterface and adds convenient methods for creating common HTTP responses, such as HTML, JSON, plain text, redirects, and empty responses.

Methods
-------

- **createResponseFromHtml(string $html): ResponseInterface**

  Creates a response with HTML content and the appropriate Content-Type header.

- **createResponseFromPayload(array $payload): PayloadResponseInterface**

  Creates a JSON response from an associative array. The response will have the Content-Type set to application/json.

- **createResponseFromText(string $text): ResponseInterface**

  Creates a plain text response with Content-Type text/plain.

- **createRedirectResponse(UriInterface|string $uri, int $status = 302): ResponseInterface**

  Creates a redirect response to the given URI. The status code defaults to 302.

- **createEmptyResponse(int $status = 204): ResponseInterface**

  Creates a response with no body (status 204 by default).

Examples
--------

.. code-block:: php

   $responseFactory = $container->get(ResponseFactoryInterface::class);
   $htmlResponse = $responseFactory->createResponseFromHtml('<h1>Hello</h1>');
   $jsonResponse = $responseFactory->createResponseFromPayload(['ok' => true]);
   $redirect = $responseFactory->createRedirectResponse('/login');
