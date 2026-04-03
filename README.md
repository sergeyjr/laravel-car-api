---

## Документация проекта

Вся основная информация по проекту разделена по отдельным документам:

* **Логика системы и бизнес-правила**
  `\app\Modules\API\V1\docs\logics.md`

* **Требования и окружение проекта**
  `\app\Modules\API\V1\docs\requirements.md`

* **Структура проекта (дерево модулей/файлов)**
  `\app\Modules\API\V1\docs\tree.md`

* **Тестирование**
  находится в отдельном документе:
  `\app\Modules\API\V1\docs\tests.md`

---

## Требования

Перед запуском убедиться, что установлены:

* PHP >= 8.2
* Composer
* Node.js >= 18
* NPM
* PostgreSQL
* Redis (опционально, для кэша)
* Docker + Docker Compose (опционально)

---

## Клонирование проекта

```bash
git clone <repo_url>
cd <project>
````

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
APP_DEBUG=false
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

## Миграции

```bash
php artisan migrate
```

---

## Сборка frontend (Vite)

### Режим разработки

```bash
npm run dev
```

* dev-сервер Vite
* hot reload (мгновенное применение изменений)
* файлы не сохраняются в `public/build`
* используется только для разработки

---

### Production build

```bash
npm run build
```

* сборка в статические файлы
* создается `public/build`
* код оптимизируется (минификация, удаление лишнего)
* используется без dev-сервера

---

### Кратко

* `npm run dev` — разработка (live-обновления, без оптимизации)
* `npm run build` — продакшен (оптимизированные статические файлы)

---

## Запуск приложения

### Вариант 1: без Docker

```bash
php artisan serve
npm run dev
```

API будет доступно:

```
http://localhost/api/v1
```

---

### Вариант 2: с Docker

```bash
docker-compose up -d
```

---

## Проверка авторизации

### Получение токена

```http
POST http://localhost/api/v1/auth/login?login=admin&password=123456
```

---

### Использование

```http
Authorization: Bearer <token>
```

---

## Быстрая проверка API

### Создание авто

```http
POST http://localhost/api/v1/car/create
```

### Получение списка

```http
GET http://localhost/api/v1/car/list?page=1&pageSize=2
```

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

## Итог (DEV запуск)

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

## Docker запуск

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate

docker-compose up -d
php artisan migrate
```

```
```
