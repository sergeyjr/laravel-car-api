````md
# Backend API сервис объявлений автомобилей

## Цель

Создать backend API сервис для управления объявлениями автомобилей.

---

## Обзор

Разработать REST API сервис с использованием:

- PHP 8  
- Yii2  
- PostgreSQL  

Требования к архитектуре:

- многослойная архитектура  
- использование паттернов:
  - Service  
  - Repository  
  - Entity  
  - DataMapper  
- соблюдение принципов SOLID  
- использование Dependency Injection  

---

## Требования

### 1. REST API методы

#### POST /car/create

Создаёт новое объявление.

**Тело запроса:**
```json
{
  "title": "string",
  "description": "string",
  "price": 10000,
  "photo_url": "string",
  "contacts": "string",
  "options": [
    {
      "brand": "string",
      "model": "string",
      "year": 2020,
      "body": "string",
      "mileage": 10000
    }
  ]
}
````

`options` может быть `null`.

**Ответ:**

```
201 Created
```

---

#### GET /car/{id}

Возвращает одно объявление.

**Ответ:**

```
200 OK
```

Содержит:

* данные автомобиля
* технические характеристики (если есть)

---

#### GET /car/list

Возвращает список объявлений с пагинацией.

**Параметры:**

```
?page=1
```

**Ответ:**

```
200 OK
```

Массив объявлений.

---

### 2. База данных

Используется PostgreSQL.

#### Таблица `car`

* id (serial, PK)
* title (varchar)
* description (text)
* price (decimal)
* photo_url (varchar)
* contacts (varchar)
* created_at (timestamp)

---

#### Таблица `car_option`

* id (serial, PK)
* car_id (integer, FK)
* brand (varchar)
* model (varchar)
* year (integer)
* body (varchar)
* mileage (integer)

---

#### Связь

```
car_option.car_id → car.id
```

Тип связи:

```
has-one
```

Особенности:

* опции необязательны
* если опции создаются — все поля обязательны

---

#### Миграции

Использовать:

```bash
php yii migrate/create
```

Применение:

```bash
php yii migrate/up
```

---

### 3. Git

Требования:

* создать репозиторий (GitHub / GitLab)
* писать понятные коммиты:

    * setting Yii2 project
    * create car module
    * create REST API

---

#### README.md должен содержать

* инструкцию по установке
* инструкцию по запуску

---

#### Базовый pipeline

```bash
git clone <url-репозитория>
cd <project>

composer install

php yii migrate/up

php yii serve
```

---

### 4. Опционально

* написать unit-тест для Service слоя (создание объявления)
* завернуть проект в Docker

---

## Итог

Результат:

* REST API для управления объявлениями автомобилей
* PostgreSQL база данных
* чистая архитектура
* готовность к расширению и тестированию

```
```
