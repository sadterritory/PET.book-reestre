# Книжный реест

[sadterritory]: https://github.com/sadterritory

![Postgres](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)
![Postman](https://img.shields.io/badge/Postman-FF6C37?style=for-the-badge&logo=Postman&logoColor=white)
![PhpStorm](http://img.shields.io/badge/-PHPStorm-181717?style=for-the-badge&logo=phpstorm&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=Composer&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

> Created by [@sadterritory][sadterritory]

## Оглавление

1. [Цель проекта](#Цель-проекта)
2. [Задачи и требования проекта](#Задачи-и-требования-проекта)
3. [Технические особенности](#Технические-особенности)
4. [Api-endpoints](#Api-endpoints)
5. [Тестирование работы api](#Тестирование-работы-api)
6. [Сборка проекта](#Сборка-проекта)

## Цель проекта

Реализация системы управления книгами, авторами и жанрами с разграничением прав доступа через REST API.

## Задачи и требования проекта

### Основные сущности

- **Книга** (с обязательными полями: название, тип издания, автор, жанры)
- **Автор** (с базовыми полями: имя, контактные данные)
- **Жанр** (с базовым полем: название)

### Связи между сущностями

- Один автор → Много книг (`1:N`)
- Много книг → Много жанров (`M:M`)
- У каждой книги ровно один автор

### Типы книг (реализация через Enum)

1. Графическое издание
2. Цифровое издание
3. Печатное издание

### Дополнительные требования

- Логирование всех действий с книгами (в БД или файл)
- Разграничение прав:
    - **Администратор** - полный доступ (CRUD)
    - **Автор** - управление только своими книгами

## Технические особенности

- Валидация: запрет дублирования названий книг
- Пагинация на всех списках
- Подробное логирование изменений
- Полнотекстовый поиск по книгам
- Гибкая фильтрация и сортировка

## Api-endpoints

### Публичный доступ

| Метод | Путь                | Описание                          |
|-------|---------------------|-----------------------------------|
| `GET` | `/api/books`        | Список книг с автором (пагинация) |
| `GET` | `/api/books/{id}`   | Данные книги по ID                |
| `GET` | `/api/authors`      | Список авторов с кол-вом книг     |
| `GET` | `/api/authors/{id}` | Данные автора со списком книг     |
| `GET` | `/api/genres`       | Список жанров с кол-вом книг      |

### Авторский доступ (требуется аутентификация)

| Метод    | Путь                          | Описание                |
|----------|-------------------------------|-------------------------|
| `POST`   | `/api/author/logout`          | Logout автора           |
| `PUT`    | `/api/author/books/{id}`      | Обновление своих книг   |
| `DELETE` | `/api/author/books/{id}`      | Удаление своих книг     |
| `PUT`    | `/api/author/authors/profile` | Обновление своих данных |

### Административный доступ

| Метод  | Путь                  | Описание                               |
|--------|-----------------------|----------------------------------------|
| `POST` | `/api/admin/logout`   | Logout администратора                  |
| `CRUD` | `/api/admin/{entity}` | Полное управление (авторы/книги/жанры) |
| `GET`  | `/api/admin/books`    | Расширенный список книг с фильтрами:   |

## Тестирование работы api

Для теста использовался *Postman*. Коллекции (с документацией внутри) лежат в директории *postman_api_test*

## Сборка проекта

```bash
# 0. Clone
git clone <repository-url>

cd <project-directory>

# 1. Set Up .env
cp .env.example .env
# Отредактируйте .env (особенно секции DB)

# Выполнение миграций и сидов
php artisan migrate --seed

# Запуск тестов (не реализованы, но, в случае чего, можно реализовать)
php artisan test

# 2.1 Run locally 
php artisan serve
```
