API
│
├── app/Modules/API/V1
│   │
│   ├── DTO
│   │   ├── Request
│   │   │   ├── CarCreateRequest.php
│   │   │   ├── CarOptionRequest.php
│   │   │   └── PaginationRequest.php
│   │   │
│   │   └── Response
│   │       ├── CarListResponse.php
│   │       ├── CarOptionResponse.php
│   │       └── CarResponse.php
│   │
│   ├── Helpers
│   │   └── ApiResponse.php
│   │
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── AuthController.php
│   │   │   ├── BaseApiController.php
│   │   │   └── CarController.php
│   │   │
│   │   └── Middleware
│   │       └── FlexibleAuthMiddleware.php
│   │
│   ├── Mappers
│   │   └── CarMapper.php
│   │
│   ├── Models
│   │   ├── ApiUser.php
│   │   ├── Car.php
│   │   └── CarOption.php
│   │
│   ├── Providers
│   │   └── ApiServiceProvider.php
│   │
│   ├── Repositories
│   │   ├── Interfaces
│   │   │   ├── CarOptionRepositoryInterface.php
│   │   │   ├── CarRepositoryInterface.php
│   │   │   └── UserRepositoryInterface.php
│   │   │
│   │   ├── CarOptionRepository.php
│   │   ├── CarRepository.php
│   │   └── UserRepository.php
│   │
│   ├── Routes
│   │   ├── api.php
│   │   └── web.php
│   │
│   └── Services
│       ├── AuthService.php
│       └── CarService.php
│
├── bootstrap
│   └── app.php
│
├── config / .env
│
├── database
│   └── migrations
│       ├── 2026_03_13_212150_create_car_table.php
│       ├── 2026_03_13_212521_create_car_option_table.php
│       ├── 2026_03_15_185048_create_api_user_table.php
│       └── 2026_03_16_120834_seed_car_data.php
│
├── composer.json
│
└── routes
├── api.php
└── web.php
