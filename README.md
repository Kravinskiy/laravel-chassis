# laravel-chassis

A laravel chassis with support to easily generate or use Repository & Service pattern for a modern application. 
Remove the messyness from your Laravel application by following a Domain Driven Design approach, and add CRUD actions - if needed, with very little or no customization at all.

Designed for micro-service applications, but can be used in any architecture design. 

Supports generating the following layers of your application:

- Route generation
- Requests
- Controllers
- Models
- Services
- Repositories
- Integration Tests

## Installation

Kernel for web:

`src/Http/Kernel.php`

Kernel for console (this will allow resource generation):

`src/Console/Kernel.php`

Error handling:

`src/Exceptions/Handler.php`

## Command

### resource:generate {name} {resources(optional)[]} {--crud}

Resources:
- 'Create', 'Update', 'Get', 'All', 'Delete', 'Store', 'Show', 'Index', 'Destroy'

### Error Handling and Exceptions

Out of box exceptions:

- Entity error exceptions, such as:
  - CanNotCreateEntityException
  - CanNotDeleteEntityException
  - CanNotGetEntityException
  - CanNotUpdateEntityException
  - EntityNotFoundException

- HTTP Response exceptions, such as:

  - ForbiddenException
  - HttpException (generic)
  - InternalErrorException
  - MethodNotAllowedException
  - NotFoundException
  - UnathorizedException

- Console exceptions, such as:

  - InvalidArgumentException

- Validation exceptions, such as:

  - ValidationException
  
  #### Copyright by Mark Kravinskiy @ 2019 - 2020


