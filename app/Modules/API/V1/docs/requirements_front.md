---

````md
# Frontend + API сервис получения автомобилей

## Цель

Реализовать отображение списка автомобилей на фронтенде через REST API микросервиса с авторизацией и загрузкой изображений без использования `storage:link`.

---

## Обзор

Система состоит из:

- Frontend (Vue 3 SPA внутри Blade)
- Backend API (Laravel микросервис автомобилей)
- Storage файлов через кастомный роут `/files/*` (без symlink)

Взаимодействие:

Frontend → REST API → Backend → PostgreSQL  
Frontend → `/files/*` → Backend → storage/app/public

---

## Аутентификация

### Bearer Token

- токен хранится в `localStorage`
- передаётся в заголовке:

```http
Authorization: Bearer {token}
````

### Логин

```
POST /api/v1/auth/login
```

---

## Требования

---

### 1. REST API методы

#### GET /api/v1/car/list

Возвращает список автомобилей с пагинацией.

**Параметры:**

```
?page=1
&pageSize=5
```

**Ответ:**

```json
{
  "data": {
    "items": [
      {
        "id": 1,
        "title": "BMW X5",
        "price": 25000,
        "photo_url": "cars/1.jpg"
      }
    ],
    "page": 1,
    "total": 100,
    "perPage": 5
  }
}
```

---

#### GET /api/v1/car/{id}

Возвращает один автомобиль.

```json
{
  "data": {
    "id": 1,
    "title": "BMW X5",
    "price": 25000,
    "description": "text",
    "photo_url": "cars/1.jpg"
  }
}
```

---

## 2. Frontend (Vue 3 внутри Blade)

---

### Страница списка автомобилей

#### Отображает:

* изображение
* title
* price

---

#### Загрузка данных:

* через axios
* с Bearer token
* пагинация

---

#### Изображения:

Формирование URL:

```js
img src = `/files/${car.photo_url}`
```

---

### Пример fallback изображения:

```
/images/cars/default.jpg
```

---

## 3. Загрузка изображений (ВАЖНО)

### Файлы хранятся:

```
storage/app/public/cars/
```

### Доступ через кастомный роут:

```
GET /files/{path}
```

---

### Пример реализации:

```php
Route::get('/files/{path}', function ($path) {
    return Storage::disk('public')->response($path);
})->where('path', '.*');
```

---

## 4. Frontend состояния

Обязательно обработка:

* loading
* error
* empty list
* 401 Unauthorized → logout + redirect

---

## 5. Нефункциональные требования

* API response ≤ 300 ms
* поддержка пагинации
* работа без storage:link
* работа после git clone без дополнительных команд
* корректная загрузка изображений через `/files/*`

---

## 6. Пример сценария

1. Пользователь открывает страницу `/cars`
2. Vue делает запрос:

```
POST /api/v1/auth/login
```

3. Получает token
4. Делает:

```
GET /api/v1/car/list?page=1&pageSize=5
```

5. Отображает список
6. Картинки загружаются через:

```
/files/cars/1.jpg
```

---

## Итог

Результат:

* frontend (Vue) отображает список автомобилей
* данные получаются через API с авторизацией
* изображения грузятся через кастомный файловый роут
* проект запускается без дополнительных artisan-команд
* storage:link не используется

```
