Troubleshooting
===============

I resolved ``Psr\\Http\\Message\\ResponseFactoryInterface`` but the helper methods do not exist
-----------------------------------------------------------------------------------------------

You resolved the PSR-17 interface, not the Fast Forward convenience interface.
Use ``FastForward\Http\Message\Factory\ResponseFactoryInterface`` when you need methods such as ``createResponseFromPayload()`` or ``createResponseRedirect()``.

I resolved ``Psr\\Http\\Message\\StreamFactoryInterface`` but ``createStreamFromPayload()`` is missing
------------------------------------------------------------------------------------------------------

The same rule applies to streams.
Resolve ``FastForward\Http\Message\Factory\StreamFactoryInterface`` for payload-aware helpers.

``createResponseNoContent()`` does not let me choose another status code
------------------------------------------------------------------------

That method is intentionally specialized for ``204 No Content``.
For ``202 Accepted`` or other empty responses, call the standard PSR-17 ``createResponse()`` method instead.

I need a redirect status other than ``301`` or ``302``
------------------------------------------------------

``createResponseRedirect()`` only models the common temporary and permanent redirect cases.
Build the response manually if you need ``303``, ``307``, or ``308``.

My JSON payload throws an exception
----------------------------------

The payload must be JSON-encodable.
Resources are not supported, and invalid data will surface as an exception from ``JsonStream``.

The current request looks stale in a long-running process
---------------------------------------------------------

``ServerRequestInterface`` is created from PHP globals when it is resolved.
In long-running servers or workers, resolve it for each request and avoid keeping it as a singleton.

I use another container and the service provider does not plug in automatically
-------------------------------------------------------------------------------

That can happen because the provider uses Fast Forward container helper factories.
In non-Fast-Forward containers, manually register the equivalent services.
