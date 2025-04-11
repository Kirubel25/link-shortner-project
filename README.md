# 🔗 Link Shortener

A Laravel-based URL shortening service powered by Docker.

---

## 📦 Features

- Laravel 12.x with PHP 8.2
- Dockerized setup (PHP + Apache + MySQL)
- Built-in Admin user seeder
- Simple login/logout system (no Breeze, no Jetstream)

---

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
Once setup is complete, you can log in using:

Email: admin@example.com

Password: password

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