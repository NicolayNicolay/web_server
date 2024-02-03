# Проект для сбора данных о состоянии работы сервера по api
Краткое описание проекта: Проект для отслеживания состояний составляющих компонентов, по средствам обращения к Api внешнего сервера.

## Installation

```bash
git clone git@github.com:NicolayNicolay/web_server.git web_server.local
cd web_server.local
composer install
```

Copy the .env file and change the database connection settings

```bash
cp .env.example .env
```

```bash
php artisan key:generate
php artisan storage:link
```

```bash
npm install
```

```bash
npm run build
```

For development mode, use the command

```bash
npm run dev
```

