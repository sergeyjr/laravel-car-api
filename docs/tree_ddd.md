# Laravel Project Structure (DDD)

```text
├── app
│   ├── Application
│   │   ├── Car
│   │   │   ├── UseCases
│   │   │   │   ├── CreateCar.php
│   │   │   │   ├── DeleteCar.php
│   │   │   │   ├── GetCar.php
│   │   │   │   ├── GetCars.php
│   │   │   │   ├── GetCarsCount.php
│   │   │   │   ├── PatchCar.php
│   │   │   │   └── UpdateCar.php
│   │   │   │
│   │   │   └── Mapper
│   │   │       ├── CarMapper.php
│   │   │       └── CarOptionMapper.php
│   │   │
│   │   ├── Shared
│   │   │   └── Pagination
│   │   │
│   │   └── User
│   │       └── UserMapper.php
│   │
│   ├── Domain
│   │   ├── Car
│   │   │   ├── Car.php
│   │   │   ├── CarOption.php
│   │   │   └── Repositories
│   │   │       ├── CarRepositoryInterface.php
│   │   │       └── CarOptionRepositoryInterface.php
│   │   │
│   │   ├── Contact
│   │   │   └── Contact.php
│   │   │
│   │   ├── Page
│   │   │   └── Page.php
│   │   │
│   │   ├── User
│   │   │   └── User.php
│   │   │
│   │   ├── Shared
│   │   │   └── Pagination.php
│   │   │
│   │   └── Exceptions
│   │       ├── RepositoryException.php
│   │       └── DomainException.php
│   │
│   ├── Infrastructure
│   │   └── Persistence
│   │       ├── Eloquent
│   │       │   ├── CarModel.php
│   │       │   ├── CarOptionModel.php
│   │       │   ├── ContactModel.php
│   │       │   └── PageModel.php
│   │       │
│   │       ├── Repositories
│   │       │   ├── EloquentCarRepository.php
│   │       │   └── EloquentCarOptionRepository.php
│   │
│   ├── Http
│   │   ├── Api
│   │   │   └── V1
│   │   │       ├── Controllers
│   │   │       │   ├── ApiAuthController.php
│   │   │       │   └── ApiCarController.php
│   │   │       │
│   │   │       └── DTO
│   │   │           ├── Request
│   │   │           │   ├── CarCreateRequest.php
│   │   │           │   ├── CarOptionRequest.php
│   │   │           │   ├── CarPatchRequest.php
│   │   │           │   ├── CarUpdateRequest.php
│   │   │           │   └── PaginationRequest.php
│   │   │           │
│   │   │           └── Response
│   │   │               ├── CarResponse.php
│   │   │               ├── CarOptionResponse.php
│   │   │               └── CarListResponse.php
│   │   │
│   │   ├── Controllers
│   │   │   └── Web
│   │   │       ├── AuthController.php
│   │   │       ├── CarController.php
│   │   │       ├── Controller.php
│   │   │       ├── DashboardController.php
│   │   │       ├── FileController.php
│   │   │       ├── ProfileController.php
│   │   │       └── SiteController.php
│   │   │
│   │   └── Middleware
│   │       ├── Authenticate.php
│   │       ├── EnsureApiRole.php
│   │       ├── FixJsonMiddleware.php
│   │       └── RedirectIfAuthenticated.php
│   │
│   ├── Models
│   │   └── User.php
│   │
│   └── Providers
│       └── AppServiceProvider.php
```
