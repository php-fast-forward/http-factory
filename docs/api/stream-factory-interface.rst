StreamFactoryInterface
======================

.. code-block:: php

   interface StreamFactoryInterface extends Psr\Http\Message\StreamFactoryInterface
   {
       public function createStreamFromPayload(array $payload): PayloadStreamInterface;
   }

Description
-----------

Extends the PSR-17 StreamFactoryInterface with additional functionality for creating streams from payloads.

Methods
-------

- **createStreamFromPayload(array $payload): PayloadStreamInterface**

  Creates a JSON stream from an array. The returned stream implements PayloadStreamInterface and is both readable and seekable.

Examples
--------

.. code-block:: php

   $streamFactory = $container->get(StreamFactoryInterface::class);
   $jsonStream = $streamFactory->createStreamFromPayload(['foo' => 'bar']);
