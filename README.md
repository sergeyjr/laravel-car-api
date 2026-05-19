## О проекте

В процессе поиска работы мне предложили выполнить тестовое задание — разработать небольшое API на Yii2.
Несмотря на то, что сотрудничество с компанией в итоге не состоялось, я решил довести задачу до конца, чтобы проверить свои навыки.
Так появился вариант проекта, с которым можно ознакомиться здесь:  
https://github.com/sergeyjr/yii2-car-api

Позже я решил реализовать аналогичный проект на Laravel (версия 13), параллельно изучая возможности этого фреймворка.
Со временем проект развивался: я добавил frontend-часть на Vue 3 с использованием Vite, что позволило сделать интерфейс более интерактивным.

В результате получился полноценный проект, включающий:
- SPA-фронтенд, работающий без перезагрузки страниц
- внешнее API
- внутреннее API
- простую панель управления с авторизацией
- а также дополнительный функционал, расширяющий базовые возможности системы.

Проект стал для меня практическим полигоном для изучения архитектуры, работы с API и современного frontend-стека.

По мере изучения новых "фишек" проект обновляется и дополняется.

---

## Документация проекта

Вся основная информация по проекту разделена по отдельным документам:

* **Логика системы и бизнес-правила**  
  [logics.md](./docs/logics.md)

* **Требования и окружение проекта**  
  [requirements.md](./docs/requirements.md)

* **Структура проекта (дерево модулей/файлов) Clean Architecture**  
  [tree.md](./docs/tree.md)

* **Структура проекта (дерево модулей/файлов) DDD**  
  [tree_ddd.md](./docs/tree_ddd.md)

* **Тестирование**  
  [tests.md](./docs/tests.md)

---

## Требования

Перед запуском убедиться, что установлены:

* PHP >= 8.2
* Composer
* Node.js >= 18
* NPM
* PostgreSQL
* Redis (опционально, для кэша)
* Docker (опционально)

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
cp /docs/.env.example .env
```

Сгенерировать ключ:

```bash
php artisan key:generate
```

---

## Конфигурация .env

Минимально настроить: см. env.example

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

### Production build

```bash
npm run build
```

---

## Запуск приложения

### Вариант 1: без Docker

```bash
php artisan serve
npm run dev
```

---

### Вариант 2: с Docker

```bash
docker-compose up -d
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

## Тестирование

Проект использует Laravel PHPUnit.

Все тесты находятся в:

```
tests/Feature/
```

Основные тесты:

* `AuthTest.php`
* `CarListTest.php`
* `CarShowTest.php`

---

### Тестовое окружение

Для тестов используется отдельная конфигурация .env.testing:

```env
APP_ENV=testing
APP_DEBUG=true

DB_CONNECTION=sqlite
DB_DATABASE=:memory:

CACHE_STORE=array
SESSION_DRIVER=array
QUEUE_CONNECTION=sync
```

---

### Запуск тестов

Запустить все тесты:

```bash
php artisan test
```

Запустить конкретный тест:

```bash
php artisan test --filter AuthTest
php artisan test --filter CarListTest
php artisan test --filter CarShowTest
```
