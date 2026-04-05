Redirect Response
=================

``createResponseRedirect()`` creates a redirect response backed by ``FastForward\Http\Message\RedirectResponse``.

Default Behavior
----------------

- accepts either a string URI or a ``UriInterface``
- uses ``302 Found`` by default
- uses ``301 Moved Permanently`` when ``$permanent`` is ``true``
- always sets the ``Location`` header

Examples
--------

.. code-block:: php

   use FastForward\Http\Message\Factory\ResponseFactoryInterface;
   use Nyholm\Psr7\Uri;

   $responseFactory = $container->get(ResponseFactoryInterface::class);

   $temporaryRedirect = $responseFactory->createResponseRedirect('/login');

   $permanentRedirect = $responseFactory->createResponseRedirect(
       new Uri('/new-home'),
       true,
       ['X-Redirect-By' => 'FastForward']
   );

When To Use It
--------------

- redirecting an unauthenticated user to a login page
- moving an old path to a new permanent location
- handling simple post-action redirects

Important Limitation
--------------------

The helper covers the common ``301`` and ``302`` cases.
If you need ``303``, ``307``, or ``308``, create a standard PSR-17 response and add the ``Location`` header yourself.

.. code-block:: php

   use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactoryInterface;

   $psrResponseFactory = $container->get(PsrResponseFactoryInterface::class);

   $response = $psrResponseFactory
       ->createResponse(303)
       ->withHeader('Location', '/orders/10');
