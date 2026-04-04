## Bruno (API тестирование) — коротко

### 1. Логин

```http
POST http://localhost/api/v1/auth/login
```

Body:

```json
{
  "email": "admin@example.com",
  "password": "123456"
}
```

→ копируешь token

---

### 2. Добавить token в Bruno

Header:

```
Authorization: Bearer 1|xxxxxxx
```

---

### 3. CRUD Car

### Создать

```http
POST http://localhost/api/v1/car
```

---

### Список

```http
GET http://localhost/api/v1/car?page=1&pageSize=10
```

---

### Один car

```http
GET http://localhost/api/v1/car/{id}
```

---

### Обновить полностью

```http
PUT http://localhost/api/v1/car/{id}
```

---

### Обновить частично

```http
PATCH http://localhost/api/v1/car/{id}
```

---

### Удалить

```http
DELETE http://localhost/api/v1/car/{id}
```

---

### Mock

```http
GET http://localhost/api/v1/car/generate-mock
```

---

Готово.
