Aliases and Factories
=====================

All PSR-17 aliases are resolved to a single instance of `Nyholm\Psr7\Factory\Psr17Factory`, ensuring consistency and resource efficiency.

Details:
--------

- **Singleton Pattern**: The same instance is reused for all PSR-17 interfaces, reducing memory usage and initialization overhead.
- **Custom Implementations**: You can override any alias by registering your own implementation in the container.
- **ServerRequestInterface**: Resolved using the static `fromGlobals()` method from `Nyholm\Psr7Server\ServerRequestCreator`, providing easy access to the current HTTP request.
- **Extensibility**: The provider is designed to be extensible, allowing you to add or replace factories as needed for your application.
