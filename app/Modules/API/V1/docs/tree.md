├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── AuthController.php
│   │   │   ├── CarsController.php
│   │   │   ├── Controller.php
│   │   │   └── SiteController.php
│   │   │
│   │   └── Middleware
│   │       └── Authenticate.php
│   │
│   ├── Models
│   │   ├── Contact.php
│   │   └── User.php
│   │
│   ├── Modules
│   │   └── API
│   │       └── V1
│   │           ├── docs
│   │           │   ├── logics.md
│   │           │   ├── requirements.md
│   │           │   ├── tests.md
│   │           │   └── tree.md
│   │           │
│   │           ├── DTO
│   │           │   ├── Request
│   │           │   │   ├── CarCreateRequest.php
│   │           │   │   ├── CarOptionRequest.php
│   │           │   │   └── PaginationRequest.php
│   │           │   │
│   │           │   └── Response
│   │           │       ├── CarListResponse.php
│   │           │       ├── CarOptionResponse.php
│   │           │       └── CarResponse.php
│   │           │
│   │           ├── Exceptions
│   │           │   ├── ApiUserException.php
│   │           │   ├── RepositoryException.php
│   │           │   └── ServiceException.php
│   │           │
│   │           ├── Helpers
│   │           │   └── ApiResponse.php
│   │           │
│   │           ├── Http
│   │           │   ├── Controllers
│   │           │   │   ├── ApiAuthController.php
│   │           │   │   ├── BaseApiController.php
│   │           │   │   └── CarController.php
│   │           │   │
│   │           │   └── Middleware
│   │           │       └── FlexibleAuthMiddleware.php
│   │           │
│   │           ├── Mappers
│   │           │   └── CarMapper.php
│   │           │
│   │           ├── Models
│   │           │   ├── ApiUser.php
│   │           │   ├── Car.php
│   │           │   └── CarOption.php
│   │           │
│   │           ├── Repositories
│   │           │   ├── Interfaces
│   │           │   │   ├── ApiUserRepositoryInterface.php
│   │           │   │   ├── CarOptionRepositoryInterface.php
│   │           │   │   └── CarRepositoryInterface.php
│   │           │   │
│   │           │   ├── ApiUserRepository.php
│   │           │   ├── CarOptionRepository.php
│   │           │   └── CarRepository.php
│   │           │
│   │           └── Services
│   │               ├── AuthService.php
│   │               └── CarService.php
│   │
│   └── Providers
│       └── AppServiceProvider.php
│
├── bootstrap
│   └── app.php
│
├── config
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
│
├── database
│   ├── .gitignore
│   ├── database.sqlite
│   │
│   ├── factories
│   │   ├── ApiUserFactory.php
│   │   └── UserFactory.php
│   │
│   ├── migrations
│   │   ├── 2026_03_13_212150_create_car_table.php
│   │   ├── 2026_03_15_185048_create_api_user_table.php
│   │   └── 2026_04_02_104814_create_contacts_table.php
│   │
│   └── seeders
│       ├── ApiUserSeeder.php
│       ├── CarSeeder.php
│       ├── DatabaseSeeder.php
│       └── UserSeeder.php
│
├── public
│   ├── .htaccess
│   ├── favicon.ico
│   ├── index.php
│   ├── php.php
│   ├── robots.txt
│   │
│   ├── css
│   │   ├── bootstrap.min.css
│   │   └── cars.css
│   │
│   └── js
│       ├── bootstrap.bundle.min.js
│       └── cars.js
│
├── resources
│   ├── css
│   │   └── app.css
│   │
│   ├── js
│   │   ├── app.js
│   │   └── bootstrap.js
│   │
│   └── views
│       ├── auth
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       │
│       ├── cars
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       │
│       ├── components
│       │   ├── button.blade.php
│       │   └── card.blade.php
│       │
│       ├── dashboard
│       │   ├── index.blade.php
│       │   └── profile.blade.php
│       │
│       ├── layouts
│       │   └── app.blade.php
│       │
│       ├── pages
│       │   ├── about.blade.php
│       │   ├── contact.blade.php
│       │   └── home.blade.php
│       │
│       └── partials
│           ├── alerts.blade.php
│           ├── footer.blade.php
│           ├── header.blade.php
│           └── navbar.blade.php
│
├── routes
│   ├── api.php
│   └── web.php
│
├── .env
├── README.md
└── vite.config.js
