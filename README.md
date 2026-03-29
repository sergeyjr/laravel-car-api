## Требования

Перед запуском убедиться, что установлены:

* PHP >= 8.2
* Composer
* PostgreSQL (или другая БД, если адаптируешь конфиг)
* Redis (опционально, для кэша)
* Docker + Docker Compose (опционально, если хочешь изолированное окружение)

---

## Клонирование проекта

```bash
git clone <repo_url>
cd <project>
```

---

## Установка зависимостей

```bash
composer install
```

---

## Настройка окружения

Скопировать `.env`:

```bash
cp .env.example .env
```

Сгенерировать ключ:

```bash
php artisan key:generate
```

---

## Конфигурация .env

Минимально настроить:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

API_KEY=kpR85bh5hge%$
AUTH_MODE=any
```

Если Redis не используешь:

```env
CACHE_DRIVER=file
```

---

## Поднятие инфраструктуры (варианты)

### Без Docker

* поднять PostgreSQL
* создать БД
* (опционально) поднять Redis

---

### Через Docker

```bash
docker-compose up -d
```

Если `docker-compose.yml` отсутствует — инфраструктуру нужно поднять вручную.

---

## Миграции и сиды

```bash
php artisan migrate
```

Тестовый набор данных уже включен в файлы миграции, поэтому отдельный запуск команды php artisan db:seed не нужен.

---

## Запуск приложения

### Вариант 1: без Docker

```bash
php artisan serve
```

API будет доступно:

```text
http://localhost/api/v1
или
http://localhost:8080/api/v1
```

---

### Вариант 2: с Docker

```bash
docker-compose up -d
```

В этом случае:

```text
php artisan serve НЕ используется
```

API будет доступно по адресу и порту, указанным в `docker-compose.yml`, например:

```text
http://localhost/api/v1
или
http://localhost:8080/api/v1
```

---

## Проверка авторизации

### Получение токена

```http
POST http://localhost/api/v1/auth/login?login=admin&password=123456
```

(порт зависит от способа запуска)

Скопировать токен из ответа.

---

### Использование

Либо:

```http
Authorization: Bearer <token>
```

Либо:

```http
X-API-KEY: <key>
```

---

## Быстрая проверка API

### Создание авто

```http
POST http://localhost/api/v1/car/create
Content-Type: application/json
Authorization: Bearer <token> либо X-API-KEY: <key>

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

### Получение списка

```http
GET http://localhost/api/v1/car/list?page=1&pageSize=2
Content-Type: application/json
Authorization: Bearer <token> либо X-API-KEY: <key>
```

---

### Получение по id

```http
GET http://localhost/api/v1/car/1
Content-Type: application/json
Authorization: Bearer <token> либо X-API-KEY: <key>
```

---

## Очистка и отладка

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---

## Типовые проблемы

**Redis недоступен**
→ установить `CACHE_DRIVER=file`

**Ошибка подключения к БД**
→ проверить `.env` и доступность сервера

**401 Unauthorized**
→ проверить заголовки и режим `AUTH_MODE`

---

## Итог

Минимальный pipeline запуска:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Если используется Docker:

```bash
composer install
cp .env.example .env
php artisan key:generate
docker-compose up -d
php artisan migrate
```

После этого API готово к тестированию.
