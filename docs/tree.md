API
│
├── routes/api.php
│
├── app/Http/Controllers/Api/V1
│   ├── AuthController.php
│   └── CarController.php
│
├── app/Http/Middleware
│   ├── FlexibleAuthMiddleware.php
│   └── ApiKeyMiddleware.php
│
├── app/Services
│   ├── AuthService.php
│   └── CarService.php
│
├── app/Repositories
│   ├── UserRepository.php
│   ├── CarRepository.php
│   ├── CarOptionRepository.php
│   └── Interfaces
│       ├── UserRepositoryInterface.php
│       ├── CarRepositoryInterface.php
│       └── CarOptionRepositoryInterface.php
│
├── app/Models
│   ├── ApiUser.php
│   ├── Car.php
│   └── CarOption.php
│
├── app/DTO
│   ├── Request
│   │   ├── CreateCarDTO.php
│   │   └── PaginationDTO.php
│   └── Response
│       ├── CarResponse.php
│       └── CarListResponse.php
│
├── app/Mappers
│   └── CarMapper.php
│
├── app/Helpers
│   └── ApiResponse.php
│
└── config / .env
├── API_KEY
└── AUTH_MODE
