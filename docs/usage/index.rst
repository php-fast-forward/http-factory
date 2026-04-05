Usage
=====

This section focuses on day-to-day tasks.
Use it when you already have the package installed and want to know which factory to resolve, which helper to call, and what kind of object you get back.

There are two families of services in this package:

- the standard PSR-17 interfaces, which give you generic request, response, stream, URI, and uploaded-file factories
- the Fast Forward convenience interfaces, which return helper objects such as ``JsonResponse`` and ``JsonStream``

.. toctree::
   :maxdepth: 1
   :caption: Usage

   getting-services
   html-response
   json-response
   text-response
   redirect-response
   empty-response
   stream-usage
   use-cases
