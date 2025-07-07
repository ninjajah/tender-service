<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tender Service API</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles -->
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #FDFDFC;
            color: #1b1b18;
            line-height: 1.5;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .dark body {
            background-color: #0a0a0a;
            color: #EDEDEC;
        }

        h1, h2, h3 {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        h2 {
            font-size: 1.5rem;
            margin-top: 2rem;
            border-bottom: 1px solid #e3e3e0;
            padding-bottom: 0.5rem;
        }

        .dark h2 {
            border-color: #3E3E3A;
        }

        code {
            background-color: #f3f3f1;
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            font-family: monospace;
        }

        .dark code {
            background-color: #1b1b18;
            color: #EDEDEC;
        }

        pre {
            background-color: #f3f3f1;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1rem 0;
        }

        .dark pre {
            background-color: #1b1b18;
            color: #EDEDEC;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e3e3e0;
        }

        .dark th, .dark td {
            border-color: #3E3E3A;
        }

        th {
            font-weight: 600;
            background-color: #f8f8f7;
        }

        .dark th {
            background-color: #161615;
        }

        .endpoint-method {
            font-weight: 600;
            color: #1b1b18;
        }

        .dark .endpoint-method {
            color: #EDEDEC;
        }

        .get {
            color: #2e7d32;
        }

        .post {
            color: #1565c0;
        }

        .put {
            color: #7b1fa2;
        }

        .delete {
            color: #c62828;
        }
    </style>
</head>
<body class="dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
<h1>🏗️ Tender Service API</h1>
<p>Микросервис для управления тендерами с REST API на Laravel 11</p>

<h2>🚀 Быстрый старт</h2>
<h3>Требования</h3>
<ul>
    <li>Docker + Docker Compose</li>
    <li>PHP 8.2+</li>
    <li>Composer</li>
</ul>

<pre><code>git clone https://github.com/ninjajah/tender-service.git
cd tender-service
cp .env.example .env
docker-compose up -d --build
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate</code></pre>

<h2>🔧 Импорт данных</h2>
<pre><code>php artisan import:tenders database/csv/test_task_data.csv</code></pre>

<h2>🌐 API Endpoints</h2>
<table>
    <thead>
    <tr>
        <th>Метод</th>
        <th>Endpoint</th>
        <th>Параметры</th>
        <th>Описание</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><span class="endpoint-method get">GET</span></td>
        <td><code>/api/tenders</code></td>
        <td>-</td>
        <td>Получить список тендеров</td>
    </tr>
    <tr>
        <td><span class="endpoint-method get">GET</span></td>
        <td><code>/api/tenders</code></td>
        <td><code>?name={строка}</code></td>
        <td>Поиск по названию</td>
    </tr>
    <tr>
        <td><span class="endpoint-method get">GET</span></td>
        <td><code>/api/tenders</code></td>
        <td><code>?date={dd.mm.yyyy}</code></td>
        <td>Фильтр по дате изменения</td>
    </tr>
    <tr>
        <td><span class="endpoint-method post">POST</span></td>
        <td><code>/api/tenders</code></td>
        <td>
                        <pre>{
  "external_code": "string",
  "number": "string",
  "status": ["Открыто"|"Закрыто"|"Отменено"],
  "name": "string",
  "change_date": "dd.mm.YYYY HH:ii:ss"
}</pre>
        </td>
        <td>Создать новый тендер</td>
    </tr>
    <tr>
        <td><span class="endpoint-method get">GET</span></td>
        <td><code>/api/tenders/{id}</code></td>
        <td>-</td>
        <td>Получить тендер по ID</td>
    </tr>
    </tbody>
</table>

</body>
</html>
