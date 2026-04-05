HTML Response
=============

``createResponseFromHtml()`` creates a ready-to-send HTML response.
It returns an instance of ``FastForward\Http\Message\HtmlResponse``, which is still a regular PSR-7 response.

Default Behavior
----------------

- status code: ``200``
- content type: ``text/html; charset=utf-8``
- body: the HTML string you pass in

Example
-------

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactoryInterface;

   $responseFactory = $container->get(ResponseFactoryInterface::class);

   $response = $responseFactory
       ->createResponseFromHtml('<h1>Hello, world!</h1>')
       ->withHeader('Cache-Control', 'no-store');

If You Need A Different Status Code
-----------------------------------

The helper starts with ``200 OK``.
Because the returned object is immutable and PSR-7 compatible, you can still change the status afterward.

.. code-block:: php

   $response = $responseFactory
       ->createResponseFromHtml('<p>Created</p>')
       ->withStatus(201);

Good Uses
---------

- small HTML pages
- status or maintenance pages
- simple error pages produced without a template engine

Gotcha
------

This helper does not sanitize user input.
Escape or sanitize untrusted values before inserting them into the HTML string.
