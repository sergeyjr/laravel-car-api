# Общая архитектура

API построено по слоистой архитектуре с элементами Clean Architecture:

```text
Controller → DTO → Service → Repository → Model → DB
                         ↓
                      Mapper → Response DTO
```

Каждый слой имеет строгую ответственность:

- Controller — HTTP уровень
- DTO — валидация и нормализация данных
- Service — бизнес-логика
- Repository — доступ к данным
- Model — Eloquent ORM
- Mapper — преобразование моделей в DTO/response формат

---

# Точка входа

Все API запросы проходят через:

```text
routes/api.php
```

Основные группы:

```text
/api/v1/auth
/api/v1/car
```

---

# Аутентификация

## Middleware слой

Используется:

- `auth:sanctum`
- `EnsureApiRole`

### Поток:

```text
Request
  ↓
auth:sanctum
  ↓
EnsureApiRole
  ↓
Controller
```

### Логика auth:sanctum:

- проверяет Bearer token
- если токен отсутствует или невалидный → AuthenticationException
- пользователь не передаётся дальше

### EnsureApiRole:

```text
auth()->user() → проверка role === 'api'
```

---

# Авторизация (API Role Guard)

Middleware:

```text
EnsureApiRole
```

Проверяет:

- пользователь авторизован
- роль пользователя = `api`

Ответ:

- 401 — нет токена
- 403 — нет доступа

---

# Логин пользователя

```text
POST /api/v1/auth/login
```

Поток:

```text
AuthController
  ↓
AuthService
  ↓
UserRepository
  ↓
DB (api_user)
```

### Логика:

1. поиск пользователя по login
2. проверка пароля
3. генерация Sanctum token
4. сохранение токена
5. возврат токена клиенту

---

# Создание автомобиля

```text
POST /api/v1/car/create
```

Поток:

```text
CarController
  ↓
CarCreateRequest (DTO + validation)
  ↓
CarService
  ↓
CarRepository (transaction)
  ↓
DB (car + car_options)
  ↓
CarMapper
  ↓
ApiResponse
```

### Логика:

1. валидация DTO
2. создание записи `cars`
3. если передан `options`:
    - создаётся `car_options`
4. загрузка связи
5. маппинг в response DTO
6. возврат результата

---

# Получение автомобиля

```text
GET /api/v1/car/{id}
```

Поток:

```text
CarController
  ↓
CarService
  ↓
Cache (remember)
  ↓
CarRepository
  ↓
Car::with('option')
  ↓
CarMapper
  ↓
Response DTO
```

### Логика:

1. проверка cache `car:{id}`
2. если нет:
    - запрос в БД
3. загрузка `option`
4. преобразование через Mapper
5. кеширование результата
6. возврат

---

# Список автомобилей

```text
GET /api/v1/car/list
```

Поток:

```text
CarController
  ↓
PaginationRequest DTO
  ↓
CarService
  ↓
CarRepository (query builder)
  ↓
paginate()
  ↓
CarMapper
  ↓
Response DTO
```

### Логика:

1. получение параметров:
    - page
    - perPage
    - sort
2. формирование запроса
3. eager loading `option`
4. пагинация
5. маппинг каждого элемента
6. возврат списка

---

# Работа с options

## Структура

```json
{
  "brand": "BMW",
  "model": "X5",
  "year": 2020,
  "body": "SUV",
  "mileage": 50000
}
```

## Правила:

- options — объект `{}` (не массив)
- может быть `null`
- может быть частично заполнен (PATCH)
- валидация зависит от сценария:

### Create:
- поля обязательны

### Update:
- частично допустимо

### Patch:
- только переданные поля (`sometimes`)

---

# Mapper (важный слой)

Mapper отвечает за единый формат API.

### БД → API:

```text
CarOption (model) → options (object)
```

### Правило:

- всегда возвращается объект
- никогда не возвращается массив

---

# Кэширование

Используется:

```text
Cache::remember
```

## Логика:

- key: `car:{id}`
- ttl: 600 секунд

### При изменениях:

```text
Cache::forget(car:{id})
```

### Особенность:

- в кэш сохраняется массив, а не модель

---

# Обработка ответов API

Единый формат:

```json
{
  "success": true,
  "data": {},
  "errors": null
}
```

При ошибке:

```json
{
  "success": false,
  "data": null,
  "message": ""
}
```

---

# Итоговая архитектура

```text
Request
  ↓
Middleware (auth + role)
  ↓
Controller
  ↓
DTO (validation + normalization)
  ↓
Service (business logic)
  ↓
Repository (DB access)
  ↓
Model (Eloquent)
  ↓
Mapper (API format)
  ↓
Response DTO
```

---

# Ключевые принципы проекта

- Controllers максимально "тонкие"
- DTO отделяют API от бизнес-логики
- Repository скрывает Eloquent
- Service содержит всю бизнес-логику
- Mapper гарантирует единый API формат
- options всегда объект, не массив

---
