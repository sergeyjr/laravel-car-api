# API Documentation (v1)

---

# Общие сведения

**Base URL:**

```

[http://laravel/api/v1](http://laravel/api/v1)

```

API использует единый формат ответа:

```

success / data / errors

```

---

# Авторизация (актуальная схема)

Проект использует **Laravel Sanctum**.

## 1. Web авторизация (сайт)

- используется Laravel session (`Auth::attempt`)
- работает через cookie
- НЕ требует токена в JS

## 2. API авторизация (Sanctum token)

- используется Bearer token
- хранится в `personal_access_tokens`
- используется для API запросов (Postman / Bruno / frontend)

---

# Роли пользователей

Пользователь имеет поле:

```

role: user | admin | api

```

## Методы модели:

- `isUser()`
- `isAdmin()`
- `isApiUser()`

---

# Получение токена (Sanctum)

Токен создаётся при логине через API.

## Запрос:

```

POST http://laravel/api/v1/auth/login?email=admin@example.com&password=123456

````

## Body:

```json
{
    "email": "admin@example.com",
    "password": "123456"
}
````

## Логика:

* проверка пользователя через `Auth::attempt`
* создание Sanctum token:

```php
$user->createToken('api_token')->plainTextToken;
```

## Ответ:

```json
{
    "success": true,
    "data": {
        "token": "1|xxxxxxxxxxxxxxxx"
    }
}
```

---

# Использование токена

Передаётся в заголовке:

```
Authorization: Bearer {token}
```

---

# Защита API

Все методы `/api/v1/car/*` защищены middleware:

```
auth:sanctum
```

---

# Важно про токены

* токены НЕ привязаны к роли автоматически
* роль проверяется отдельно (middleware / policy)
* один пользователь может иметь несколько токенов

---

# Car API

---

## Создание автомобиля

```
POST http://laravel/api/v1/car/create
```

### Body:

```json
{
    "title": "Audi A4",
    "description": "German sedan",
    "price": 18000,
    "photo_url": "https://example.com/audi.jpg",
    "contacts": "admin@example.com",
    "options": {
        "brand": "Audi 66",
        "model": "A4",
        "year": 2018,
        "body": "sedan",
        "mileage": 120000
    }
}
```

---

## Получение списка автомобилей

```
GET http://laravel/api/v1/car/list?page=1&perPage=2&sort=id&direction=desc
```

### Ответ:

```json
{
    "success": true,
    "data": {
        "items": [
            {
                "id": 1,
                "title": "BMW X5",
                "description": "Comfortable SUV",
                "price": 25000,
                "photo_url": "/storage/cars/car.jpg",
                "contacts": "admin@example.com",
                "options": {
                    "brand": "BMW",
                    "model": "X5",
                    "year": 2020,
                    "body": "SUV",
                    "mileage": 50000
                }
            },
            {
                "id": 2,
                "title": "BMW X3",
                "description": "Compact premium SUV",
                "price": 22000,
                "photo_url": "/storage/cars/car.jpg",
                "contacts": "admin@example.com",
                "options": {
                    "brand": "BMW",
                    "model": "X3",
                    "year": 2020,
                    "body": "SUV",
                    "mileage": 50000
                }
            }
        ],
        "page": 1,
        "total": 16,
        "perPage": 2
    },
    "errors": null
}
```

---

## Получение автомобиля

```
GET http://laravel/api/v1/car/1
```

### Ответ:

```json
{
    "success": true,
    "data": {
        "id": 52,
        "title": "Volkswagen Passat",
        "description": "Business sedan",
        "price": 16000,
        "photo_url": "/storage/cars/car.jpg",
        "contacts": "admin@example.com",
        "options": {
            "brand": "Volkswagen",
            "model": "Passat",
            "year": 2020,
            "body": "Sedan",
            "mileage": 50000
        }
    },
    "errors": null
}
```

---

## Обновление автомобиля (полное)

```
PUT http://laravel/api/v1/car/update/1
```

### Body:

```json
{
    "title": "Audi A4",
    "description": "German sedan",
    "price": 18000,
    "photo_url": "https://example.com/audi.jpg",
    "contacts": "admin@example.com",
    "options": {
        "brand": "Audi 66",
        "model": "A4",
        "year": 2018,
        "body": "sedan",
        "mileage": 0
    }
}
```

### Ответ:

```json
{
    "success": true,
    "data": {
        "id": 52,
        "title": "Audi A4",
        "description": "German sedan",
        "price": 18000,
        "photo_url": "https://example.com/audi.jpg",
        "contacts": "admin@example.com",
        "options": {
            "brand": "Audi 66",
            "model": "A4",
            "year": 2018,
            "body": "sedan",
            "mileage": 0
        }
    },
    "errors": null
}
```

---

## Обновление автомобиля (частичное)

```
PATCH /car/{id}
```

### Body:

```json
{
    "price": 20000,
    "options": {
        "brand": "Audi 2",
        "body": "sedan 2"
    }
}
```

### Ответ:

```json
{
    "success": true,
    "data": {
        "id": 52,
        "title": "Audi A4",
        "description": "German sedan",
        "price": 20000,
        "photo_url": "https://example.com/audi.jpg",
        "contacts": "admin@example.com",
        "options": {
            "brand": "Audi 2",
            "model": "A4",
            "year": 2018,
            "body": "sedan 2",
            "mileage": 0
        }
    },
    "errors": null
}
```

---

## Удаление автомобиля

```
DELETE /car/{id}
```

### Ответ:

```json
{
    "success": true,
    "data": {
        "message": "Машина с ID 52 удалена"
    },
    "errors": null
}
```

---

## Mock данные

```
GET /car/generate-mock
```

Для тестов на вебе, в АПИ не используется.

---

# Порядок работы

1. Войти через `/api/v1/auth/login`
2. Получить Sanctum token
3. Сохранить token (frontend / Postman / Bruno)
4. Передавать: Authorization: Bearer token
5. Вызывать `/car/*` методы

---

# Итог архитектуры

* Web = session auth (Laravel стандарт)
* API = Sanctum tokens
* роли = поле `role`
* доступ = `auth:sanctum`
