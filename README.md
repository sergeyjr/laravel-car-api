## Требования

Перед запуском убедиться, что установлены:

* PHP >= 8.2
* Composer
* Node.js >= 18
* NPM
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
npm install
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

Тестовый набор данных уже включен в миграции, поэтому `db:seed` не требуется.

---

## Сборка frontend (Vite)

### Режим разработки

```bash
npm run dev
```

### Production build

```bash
npm run build
```

После сборки появится директория:

```
public/build
```

---

## Запуск приложения

### Вариант 1: без Docker

В разных терминалах:

```bash
php artisan serve
npm run dev
```

API будет доступно:

```
http://localhost/api/v1
```

Frontend будет автоматически подхватываться через Vite.

---

### Вариант 2: с Docker

```bash
docker-compose up -d
```

Frontend:

* либо собирается через `npm run build`
* либо поднимается отдельно через `npm run dev`

---

## Проверка авторизации

### Получение токена

```http
POST http://localhost/api/v1/auth/login?login=admin&password=123456
```

Скопировать токен из ответа.

---

### Использование

```http
Authorization: Bearer <token>
```

или

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
```

---

### Получение по id

```http
GET http://localhost/api/v1/car/1
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
→ проверить `.env`

**401 Unauthorized**
→ проверить токен или `API_KEY`

**Нет стилей / пустая страница**
→ запустить:

```bash
npm install
npm run dev
```

---

## Итог

### Минимальный запуск (DEV):

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate

php artisan serve
npm run dev
```

---

### Docker вариант:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate

docker-compose up -d
php artisan migrate
```

---

После этого проект полностью готов к работе (backend + frontend).
