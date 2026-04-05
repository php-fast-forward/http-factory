StreamFactoryInterface
======================

Namespace: ``FastForward\Http\Message\Factory``

Purpose
-------

``StreamFactoryInterface`` extends the PSR-17 stream factory contract with one extra method for payload-aware JSON streams.

Contract
--------

.. code-block:: php

   interface StreamFactoryInterface extends Psr\Http\Message\StreamFactoryInterface
   {
       public function createStreamFromPayload(array $payload): PayloadStreamInterface;
   }

What The Extra Method Adds
--------------------------

``createStreamFromPayload()`` returns a ``PayloadStreamInterface`` implementation, which means the stream stays PSR-7 compatible while also exposing payload helpers such as ``getPayload()`` and ``withPayload()``.

When To Use It
--------------

- when you want a JSON stream but still need to assemble the response manually
- when a status or header combination does not match the built-in response helpers
- when you want payload-aware stream handling in tests or middleware

See Also
--------

- :doc:`stream-factory`
- :doc:`../usage/stream-usage`
