ResponseFactoryInterface
========================

Namespace: ``FastForward\Http\Message\Factory``

Purpose
-------

``ResponseFactoryInterface`` extends the PSR-17 response factory contract with convenience methods for the response shapes you create most often in applications.

Contract
--------

.. code-block:: php

   interface ResponseFactoryInterface extends Psr\Http\Message\ResponseFactoryInterface
   {
       public function createResponseFromHtml(string $html): ResponseInterface;

       public function createResponseFromPayload(array $payload): PayloadResponseInterface;

       public function createResponseFromText(string $text): ResponseInterface;

       public function createResponseNoContent(array $headers): ResponseInterface;

       public function createResponseRedirect(
           string|UriInterface $uri,
           bool $permanent,
           array $headers,
       ): ResponseInterface;
   }

Method Summary
--------------

.. list-table::
   :header-rows: 1

   * - Method
     - Returns
     - Typical use
   * - ``createResponse()``
     - ``ResponseInterface``
     - Standard PSR-17 response creation
   * - ``createResponseFromHtml()``
     - ``ResponseInterface``
     - Returning HTML
   * - ``createResponseFromPayload()``
     - ``PayloadResponseInterface``
     - Returning JSON from arrays and payload data
   * - ``createResponseFromText()``
     - ``ResponseInterface``
     - Returning plain text
   * - ``createResponseNoContent()``
     - ``ResponseInterface``
     - Returning ``204 No Content`` with optional headers
   * - ``createResponseRedirect()``
     - ``ResponseInterface``
     - Returning ``301`` or ``302`` redirects

Notes For New Users
-------------------

- This is **not** the same interface as ``Psr\Http\Message\ResponseFactoryInterface``
- The PSR interface gives you generic responses
- This Fast Forward interface gives you convenience helpers on top of the PSR contract

See Also
--------

- :doc:`response-factory`
- :doc:`../usage/json-response`
- :doc:`../usage/redirect-response`
