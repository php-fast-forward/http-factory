<?php

declare(strict_types=1);

require $argv[1] ?? dirname(__DIR__, 4) . '/vendor/autoload.php';

use FastForward\Http\Message\Factory\ResponseFactory;
use FastForward\Http\Message\Factory\StreamFactory;
use Nyholm\Psr7\Factory\Psr17Factory;

$psr17 = new Psr17Factory();
$responses = new ResponseFactory($psr17);
$streams = new StreamFactory($psr17);
$response = $responses->createResponseFromPayload(['ready' => true]);
if ($response->getPayload() !== ['ready' => true]
    || json_decode((string) $response->getBody(), true, flags: JSON_THROW_ON_ERROR) !== ['ready' => true]
    || $responses->createResponseNoContent()->getStatusCode() !== 204
    || (string) $streams->createStream('hello') !== 'hello') {
    throw new RuntimeException('Message factory output differs.');
}
try {
    $streams->createStreamFromFile(__DIR__ . '/does-not-exist.txt');
    throw new RuntimeException('A missing file unexpectedly opened.');
} catch (\RuntimeException $error) {
    if ($error->getMessage() === 'A missing file unexpectedly opened.') {
        throw $error;
    }
}

echo "fast-forward-http-factory: ok\n";
