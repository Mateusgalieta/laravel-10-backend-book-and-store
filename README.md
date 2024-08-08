This is a demo project of a Rest API built in Laravel 10 for an API with user authentication for registering books and stores and the possibility of linking them in a ternary table.

In addition to building a simple API, this project addressed some concepts widely used in software architecture, such as DDD (Domain Driven Design) and Clean Architecture. Despite Laravel being a somewhat rigid framework, we were able to apply the layers of useCase, domain, repositories and adapters in an easy way.

The choice to use this architecture pattern is the advantage that the domain is always protected in its business rules, so in the flow, from the useCase onwards, it will always have the same behavior, regardless of which adapter calls the useCase, be it a Controller, a job or a command for example.

Error handling and implementation of DTOs (Data Transfer Object) for calls between layers were also implemented. In addition, the project has End-to-end coverage.

A structured Dockerfile was also implemented to support the application, thus facilitating the manipulation of containers both in production environments and for the developer on their local machine.
