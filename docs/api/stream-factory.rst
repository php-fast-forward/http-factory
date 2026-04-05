StreamFactory
=============

Namespace: ``FastForward\Http\Message\Factory``

Purpose
-------

``StreamFactory`` is the concrete implementation behind ``FastForward\Http\Message\Factory\StreamFactoryInterface``.
It decorates a PSR-17 stream factory and adds payload-aware JSON stream creation.

Constructor
-----------

.. code-block:: php

   final readonly class StreamFactory implements StreamFactoryInterface
   {
       public function __construct(
           private Psr\Http\Message\StreamFactoryInterface $streamFactory,
       ) {}
   }

Delegated Methods
-----------------

The following methods delegate directly to the wrapped PSR-17 stream factory:

- ``createStream()``
- ``createStreamFromFile()``
- ``createStreamFromResource()``

Special Method
--------------

``createStreamFromPayload()`` creates ``FastForward\Http\Message\JsonStream`` directly.
This means the returned object is both:

- a normal PSR-7 ``StreamInterface``
- a payload-aware stream that retains the original data structure

Example
-------

.. code-block:: php

   use FastForward\Http\Message\Factory\StreamFactory;
   use Nyholm\Psr7\Factory\Psr17Factory;

   $factory = new StreamFactory(new Psr17Factory());

   $stream = $factory->createStreamFromPayload([
       'job' => 'sync-users',
   ]);

   $payload = $stream->getPayload();

Extensibility
-------------

``StreamFactory`` is ``final`` and ``readonly``.
If you want another payload format, register your own implementation for ``FastForward\Http\Message\Factory\StreamFactoryInterface``.
