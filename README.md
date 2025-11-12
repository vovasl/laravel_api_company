# 🐳 Laravel Company API

This project provides a REST API for managing company data and their version history.
It allows you to create, update, and retrieve companies, while automatically tracking every change as a new version in the database.
Built with Laravel and Docker, it's easy to deploy and extend for real-world business needs.

---

## ⚙️ Requirements

- Docker & Docker Compose
- PHP 8.3+
- Composer

---

## 🚀 Getting Started

1. Clone the repository

   `git clone https://github.com/vovasl/laravel_api_company.git`

   `cd laravel_api_company`


2. Configure environment variables. Rename the file: api/.env.example → api/.env


3. Start Docker containers
   `docker-compose up -d`


4. Install Laravel dependencies.
   Enter the Laravel container:
   `docker exec -it laravel_app bash`

   Then run:
   `composer install` and
   `php artisan migrate --seed`


5. Generate API Token (Test User): `php artisan make:test-user`

   This will create a test user and output an API token. Use that token to authenticate your API requests via the header: `Authorization: Bearer <your-token>`

---

## 🌐 Application URLs

API: http://localhost:8080/

---

## 📡 API Endpoints

| Category       | Method | Endpoint                         | Body Example                                                                                                    | Description                                                                                    |
| -------------- | ------ | -------------------------------- | --------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------- |
| **🏢 Company** | `POST` | `/api/company`                   | `{ "name": "ТОВ Українська енергетична біржа", "edrpou": "37027819", "address": "м. Київ, вул. Хрещатик, 44" }` | Creates a new company or updates an existing one. Also automatically creates a version record. |
|                | `GET`  | `/api/company/{edrpou}/versions` | —                                                                                                               | Returns company information along with all its versions.                                       |

---

## 🧪 Running Tests

To ensure everything works as expected, run: `php artisan test`