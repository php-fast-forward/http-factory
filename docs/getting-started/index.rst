Getting Started
===============

This section is written for first-time users of the package.
If you are new to PSR-7 or PSR-17, the most useful mental model is:

1. register the service provider
2. resolve the factory you need from the container
3. use the PSR-17 interfaces for generic HTTP objects
4. use the Fast Forward interfaces when you want convenience helpers

The convenience layer is the main value of this package.
It saves you from repeatedly creating JSON, HTML, text, redirect, and no-content responses by hand.

.. toctree::
   :maxdepth: 2

   installation
   quickstart
