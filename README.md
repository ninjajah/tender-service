# 🏗️ Tender Service API

Микросервис для управления тендерами с REST API на Laravel 11

## 🚀 Быстрый старт

### Требования
- Docker + Docker Compose
- PHP 8.2+
- Composer

```bash
git clone https://github.com/ninjajah/tender-service.git
cd tender-service
cp .env.example .env
docker-compose up -d --build
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

## 🔧 Импорт данных
```bash
php artisan import:tenders database/csv/test_task_data.csv
```

## 🌐 API Endpoints

| Метод | Endpoint                          | Параметры                                                                                                                                                          | Описание                  |
|-------|-----------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------|---------------------------|
| GET   | `/api/tenders`                    | -                                                                                                                                                                  | Получить список тендеров  |
| GET   | `/api/tenders`                    | `?name={строка}`                                                                                                                                                   | Поиск по названию        |
| GET   | `/api/tenders`                    | `?date={dd.mm.yyyy}`                                                                                                                                               | Фильтр по дате изменения |
| POST  | `/api/tenders`                    | ```json{"external_code": "string", "number": "string","status": ["Открыто"\|"Закрыто"\|"Отменено"], "name": "string", "change_date": "dd.mm.YYYY HH:ii:ss"}``` | Создать новый тендер     |
| GET   | `/api/tenders/{id}`               | -                                                                                                                                                                  | Получить тендер по ID    |


