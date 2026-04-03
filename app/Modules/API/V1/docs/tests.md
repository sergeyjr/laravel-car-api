---

# ## Общие сведения

**Base URL:**

```
http://localhost/api/v1
```

API использует единый формат ответа:

```
success / data / errors
```

---

# ## Авторизация (актуальная схема)

Проект использует **Laravel Sanctum**.

Есть 2 типа авторизации:

## 1. Web авторизация (сайт)

* используется Laravel session (`Auth::attempt`)
* работает через cookie
* НЕ требует токена в JS

## 2. API авторизация (Sanctum token)

* используется Bearer token
* хранится в `personal_access_tokens`
* используется для API запросов (JS / Postman / Bruno)

---

# ## Роли пользователей

Пользователь имеет поле:

```
role: user | admin | api
```

### Методы модели:

* `isUser()`
* `isAdmin()`
* `isApiUser()`

---

# ## Получение токена (Sanctum)

Токен создаётся при логине через сайт или API.

### Запрос:

```
POST /api/v1/auth/login
```

### Body:

```json
{
  "email": "admin@example.com",
  "password": "123456"
}
```

---

### Логика:

* проверка пользователя через `Auth::attempt`
* создание Sanctum token:

```php
$user->createToken('web')->plainTextToken;
```

---

### Ответ:

```json
{
  "success": true,
  "data": {
    "token": "1|xxxxxxxxxxxxxxxx"
  }
}
```

---

# ## Использование токена

Передаётся в заголовке:

```
Authorization: Bearer {token}
```

---

# ## Защита API

Все методы `/car/*` защищены middleware:

```
auth:sanctum
```

---

# ## Важно про токены

* токены НЕ привязаны к роли автоматически
* роль проверяется отдельно (middleware / policy)
* один пользователь может иметь несколько токенов

---

# ## Создание автомобиля

**Запрос:**

```
POST http://localhost/api/v1/car/create
```

### Требует:

* auth:sanctum

---

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

# ## Получение списка автомобилей

```
GET /api/v1/car/list?page=1&pageSize=2
```

---

### Ответ:

```json
{
  "success": true,
  "data": {
    "items": [],
    "page": 1,
    "total": 10,
    "perPage": 2
  }
}
```

---

# ## Получение автомобиля

```
GET /api/v1/car/{id}
```

---

# ## Mock данные

```
GET /api/v1/cars/generate-mock
```

### Требует:

* auth:sanctum

---

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
    "options": [...]
  }
}
```

---

# ## Ошибки

### 401 Unauthorized

```json
{
  "success": false,
  "errors": "Unauthenticated"
}
```

---

### 403 Forbidden (роль)

```json
{
  "success": false,
  "errors": "Forbidden"
}
```

---

### Валидация

```json
{
  "success": false,
  "errors": {
    "field": ["message"]
  }
}
```

---

### Not Found

```json
{
  "success": false,
  "errors": "Car not found"
}
```

---

# ## Порядок работы

1. Войти через `/auth/login`
2. Получить Sanctum token
3. Сохранить token в frontend (localStorage / memory)
4. Передавать:

   ```
   Authorization: Bearer token
   ```
5. Вызывать `/car/*` методы

---

# ## Итог архитектуры

* Web = session auth (Laravel стандарт)
* API = Sanctum tokens
* роли = поле `role`
* доступ = `auth:sanctum`

---
