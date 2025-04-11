# 🔗 Link Shortener

A Laravel-based URL shortening service powered by Docker.

---

## 📦 Features

- Laravel 12.x with PHP 8.2
- Dockerized setup (PHP + Apache + MySQL)
- Built-in Admin user seeder
- Simple login/logout system (no Breeze, no Jetstream)
- URL shortening with unique short codes
- Redirection handling for shortened URLs
- Admin interface to manage shortened URLs and view usage statistics

---
## 🚀 Project Overview & Goals

This project is a URL shortening service built with Laravel, Dockerized for easy deployment, and designed to handle basic URL shortening functionalities:
- Accepting a URL and generating a unique short code.
- Redirecting users to the original URL when visiting the short code.
- Admin interface for managing the shortened URLs and viewing their usage statistics.
- Containerization with Docker to streamline development and deployment.

---

## 🛠 Installation & Setup

### Prerequisites

Before setting up the project, ensure the following tools are installed on your local machine:
- **Docker**: [Install Docker](https://docs.docker.com/get-docker/)
- **Git**: [Install Git](https://git-scm.com/)


## 🚀 Quick Start

### 1. Clone the Repository
```bash
git clone https://github.com/waheed3742/link-shortner.git
cd link-shortner

2. Copy .env File

cp .env.example .env
3. Start Docker

docker-compose up --build
This will:

Build the Docker containers for PHP, Apache, and MySQL.

Run the necessary migrations automatically.

4. Run Seeder to Create Admin Login
After the containers are up and running, run the following command to create the admin user:

docker exec -it link_shortener_web php artisan db:seed --class=AdminUserSeeder
This will add the admin user to the database with the credentials:

Email: admin@example.com

Password: password

🧑‍💻 Admin Login

To access the admin interface, the admin must manually navigate to the /login URL in the browser since there is no login button available on the page. Use the following credentials for logging in:
•	Email: admin@example.com
•	Password: password


🛠 Useful Commands
Run Laravel Artisan Commands

docker exec -it link_shortener_web php artisan <command>
Example:
docker exec -it link_shortener_web php artisan migrate:fresh --seed

🧾 Notes
Don't forget to update .env with the correct DB settings:

DB_HOST=db
DB_PORT=3306
DB_DATABASE=link_shortener
DB_USERNAME=root
DB_PASSWORD=

You can view the application at http://localhost:8000.