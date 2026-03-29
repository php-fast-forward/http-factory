Stream Usage
============

The StreamFactoryInterface provides methods to create streams from strings, files, or payloads.

When using `createStreamFromPayload`, the returned object is typically an instance of `FastForward\Http\Message\JsonStream`, a PSR-7 compatible stream with extra features for handling JSON data. This allows you to work with the original payload and encoding options, in addition to standard stream operations.

Example: Creating a JSON Stream
-------------------------------

.. code-block:: php

   $streamFactory = $container->get(StreamFactoryInterface::class);
   $jsonStream = $streamFactory->createStreamFromPayload(['foo' => 'bar']);

   // $jsonStream is an instance of FastForward\Http\Message\JsonStream

Other Stream Usages
-------------------

- Create a stream from a string:

  .. code-block:: php

     $stream = $streamFactory->createStream('content');

- Create a stream from a file:

  .. code-block:: php

     $stream = $streamFactory->createStreamFromFile('/path/to/file.txt');

Use Cases:
----------
- Streaming large files
- Sending dynamic content
- Working with PSR-7 compatible middlewares
