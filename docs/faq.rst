FAQ
===

**Which PSR interfaces are supported?**

- PSR-7 (HTTP Message)
- PSR-17 (HTTP Factory)
- PSR-11 (Container, for service provider)

**Do I need to use fast-forward/container?**

Not necessarily, but integration is easier and automatic when used.

**How do I customize the implementations?**

You can override any service registered in the container by providing your own implementation for the desired interfaces.

**How do I access the current ServerRequest?**

Just get `Psr\Http\Message\ServerRequestInterface` from the container, which will be resolved via `fromGlobals()`.
