```md
# API Documentation (v1)

---

# Общие сведения

**Base URL:**

```

[http://localhost/api/v1](http://localhost/api/v1)

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

POST /auth/login

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
$user->createToken('web')->plainTextToken;
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

Все методы `/car/*` защищены middleware:

```
auth:sanctum
```

---

# Важно про токены

* токены НЕ привязаны к роли автоматически
* роль проверяется отдельно (middleware / policy)
* один пользователь может иметь несколько токенов

---

# Car API (CRUD)

---

## Создание автомобиля

```
POST /car
```

### Требует:

* auth:sanctum

### Body:

```json
{
  "title": "Audi A4",
  "description": "German sedan",
  "price": 18000,
  "photo_url": "https://example.com/audi.jpg",
  "contacts": "admin@example.com",
  "options": [
    {
      "brand": "Audi",
      "model": "A4",
      "year": 2018,
      "body": "sedan",
      "mileage": 120000
    }
  ]
}
```

---

## Получение списка автомобилей

```
GET /car?page=1&pageSize=10
```

### Ответ:

```json
{
  "success": true,
  "data": {
    "items": [],
    "page": 1,
    "total": 10,
    "perPage": 10
  }
}
```

---

## Получение автомобиля

```
GET /car/{id}
```

---

## Обновление автомобиля (полное)

```
PUT /car/{id}
```

---

## Обновление автомобиля (частичное)

```
PATCH /car/{id}
```

---

## Удаление автомобиля

```
DELETE /car/{id}
```

---

## Mock данные

```
GET /car/generate-mock
```

### Требует:

* auth:sanctum

### Ответ:

```json
{
  "success": true,
  "data": {
    "title": "...",
    "description": "...",
    "price": 123,
    "photo_url": "...",
    "contacts": "...",
    "options": []
  }
}
```

---

# Ошибки

## 401 Unauthorized

```json
{
  "success": false,
  "errors": "Unauthenticated"
}
```

---

## 403 Forbidden (роль)

```json
{
  "success": false,
  "errors": "Forbidden"
}
```

---

## 422 Validation error

```json
{
  "success": false,
  "errors": {
    "field": ["message"]
  }
}
```

---

## 404 Not Found

```json
{
  "success": false,
  "errors": "Car not found"
}
```

---

# Порядок работы

1. Войти через `/auth/login`
2. Получить Sanctum token
3. Сохранить token (frontend / Postman)
4. Передавать:

```
Authorization: Bearer token
```

5. Вызывать `/car/*` методы

---

# Итог архитектуры

* Web = session auth (Laravel стандарт)
* API = Sanctum tokens
* роли = поле `role`
* доступ = `auth:sanctum`

```
```
