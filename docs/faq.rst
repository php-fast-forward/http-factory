FAQ
===

What is the difference between the PSR response factory and the Fast Forward response factory?
-----------------------------------------------------------------------------------------------

``Psr\Http\Message\ResponseFactoryInterface`` gives you plain PSR-17 response creation.
``FastForward\Http\Message\Factory\ResponseFactoryInterface`` adds helper methods such as ``createResponseFromPayload()`` and ``createResponseRedirect()``.

Do I need to use ``fast-forward/container``?
--------------------------------------------

No.
You can instantiate ``ResponseFactory`` and ``StreamFactory`` directly.
However, the included service provider is designed specifically for ``fast-forward/container``.

Which services are registered by the provider?
----------------------------------------------

It registers aliases for the standard PSR-17 factory interfaces, aliases for the Fast Forward convenience factories, ``ServerRequestCreatorInterface``, and ``ServerRequestInterface`` built from globals.

Can I use the package without a PSR-11 container?
-------------------------------------------------

Yes.
Create ``Nyholm\Psr7\Factory\Psr17Factory`` manually and inject it into ``ResponseFactory`` and ``StreamFactory``.

Why does ``createResponseNoContent()`` always return ``204``?
-------------------------------------------------------------

Because it is meant to represent the specific HTTP "No Content" case.
If you need another empty status code, use the standard ``createResponse()`` method.

Why does ``createResponseRedirect()`` take a boolean instead of a numeric status?
---------------------------------------------------------------------------------

The helper is intentionally focused on the two most common redirect cases:
temporary ``302`` and permanent ``301``.
For other redirect statuses, build the response manually.

What concrete classes do the helper methods return?
---------------------------------------------------

They return classes from ``fast-forward/http-message`` such as ``HtmlResponse``, ``JsonResponse``, ``TextResponse``, ``EmptyResponse``, ``RedirectResponse``, and ``JsonStream``.

Are those returned objects still PSR-7 compatible?
--------------------------------------------------

Yes.
The specialized objects still implement the appropriate PSR-7 interfaces and can be used anywhere a PSR-7 response or stream is expected.

What happens if my JSON payload contains a resource?
----------------------------------------------------

JSON payload helpers rely on ``JsonStream``.
Resources are not JSON-encodable there, so an exception will be raised.

How do I access the current request?
------------------------------------

Resolve ``Psr\Http\Message\ServerRequestInterface`` from the container.
The provider creates it by calling ``ServerRequestCreator::fromGlobals()``.

Should I keep ``ServerRequestInterface`` in a singleton service?
---------------------------------------------------------------

Usually no.
It represents the current HTTP request state, so in long-running processes it should be resolved per request.

How do I override the default implementations?
----------------------------------------------

Register your own implementation for the service id you want to replace.
For example, you can replace ``FastForward\Http\Message\Factory\ResponseFactoryInterface`` with your own class if you need custom helper behavior.
