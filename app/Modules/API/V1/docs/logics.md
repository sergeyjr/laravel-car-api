## Общая архитектура

API построено по слоистой архитектуре:

```text
Controller → Service → Repository → Model → DB
                      ↓
                    Mapper → Response
```

Каждый слой отвечает только за свою задачу:

* Controller — HTTP уровень
* Service — бизнес-логика
* Repository — работа с БД
* Model — ORM (Eloquent)
* Mapper — преобразование в DTO

---

## Точка входа

Все запросы идут через:

```text
routes/api.php
```

Группировка:

```text
/api/v1/auth
/api/v1/car
```

---

## Авторизация

Перед попаданием в контроллер срабатывает:

```text
FlexibleAuthMiddleware
```

Логика:

1. Определяется режим (`AUTH_MODE` из `.env`)
2. Проверяются заголовки:

    * `X-API-KEY`
    * `Authorization: Bearer ...`
3. Если есть токен:

    * вызывается `AuthService`
    * далее `UserRepository`
    * проверка в таблице `api_user`

Результат:

* доступ разрешён → дальше в контроллер
* нет → ошибка 401

---

## Логин пользователя

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

Что происходит:

1. Поиск пользователя по login
2. Проверка пароля
3. Генерация токена
4. Сохранение токена в БД
5. Возврат токена

---

## Создание автомобиля

```text
POST /api/v1/car/create
```

Поток:

```text
CarController
  ↓
CreateCarDTO (сбор и валидация)
  ↓
CarService
  ↓
CarRepository (транзакция)
  ↓
DB (car + car_option)
  ↓
CarMapper
  ↓
ApiResponse
```

Логика:

1. Проверка, что не пришёл массив объектов
2. Формирование DTO
3. Валидация
4. Сохранение:

    * создаётся запись в `car`
    * если есть `options` → создаётся `car_option`
5. Загружается связь `option`
6. Преобразование в массив
7. Возврат клиенту

---

## Получение автомобиля

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
Model (Car::with('option'))
  ↓
Mapper
  ↓
Response
```

Логика:

1. Проверка кэша (`car:{id}`)
2. Если нет:

    * запрос в БД с `with('option')`
3. Преобразование модели в массив
4. Сохранение в кэш
5. Возврат

---

## Получение списка автомобилей

```text
GET /api/v1/car/list
```

Поток:

```text
CarController
  ↓
PaginationDTO
  ↓
CarService
  ↓
CarRepository (query builder)
  ↓
paginate()
  ↓
CarMapper
  ↓
Response
```

Логика:

1. Получение параметров (page, pageSize, sort)
2. Формирование запроса
3. Подгрузка `option` через `with()`
4. Пагинация
5. Каждый элемент:

    * преобразуется в массив
    * маппится в DTO
6. Возврат списка

---

## Работа с опциями (CarOption)

Связь:

```text
Car hasOne CarOption
```

При сохранении:

* данные приходят как массив `options`
* для каждой записи вызывается:

```text
CarOptionRepository::saveOption
```

При получении:

```text
Car::with('option')
```

Laravel сам:

* делает JOIN (или отдельный запрос)
* кладёт результат в `$car->option`

---

## Mapper (ключевой момент)

Mapper приводит данные к единому формату API:

Из БД:

```text
option → объект
```

В API:

```text
options → массив
```

Даже если опция одна:

```json
"options": [ { ... } ]
```

Если нет:

```json
"options": []
```

---

## Кэширование

Используется:

```text
Cache::remember
```

Логика:

* ключ: `car:{id}`
* TTL: 600 секунд
* при создании:

```text
Cache::forget(car:id)
```

Важно:

* в кэш кладётся массив, не модель
* это избегает проблем сериализации

---

## Обработка ответа

Все ответы проходят через:

```text
ApiResponse
```

Формат:

```json
{
  "success": true,
  "data": ...,
  "errors": null
}
```

---

## Итоговая логика

```text
Request
  ↓
Middleware (auth)
  ↓
Controller
  ↓
DTO (валидация)
  ↓
Service (логика)
  ↓
Repository (БД)
  ↓
Model (Eloquent)
  ↓
Mapper (формат API)
  ↓
Response (единый JSON)
```

---

## Ключевые особенности

* гибкая авторизация (token / api key)
* разделение слоёв
* кэширование
* DTO для валидации
* единый формат ответа
* приведение структуры данных (option → options)

---

Если упростить:

```text
это CRUD API + авторизация + кэш + нормализация данных
```
