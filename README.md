# Eloquent Coffee Co

A Laravel-based admin and storefront application for managing a coffee product catalogue — including inventory, pricing, origins, roasts, and types.

---

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/Timalm90/Eloquent-Coffee-Co.git
cd Eloquent-Coffee-Co
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Set up your environment

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and configure your database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eloquent_coffee
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run migrations and seed the database

```bash
php artisan migrate
php artisan db:seed
```

### 5. Install frontend dependencies and start Vite

```bash
npm install
npm run dev
```

> Use `npm run build` instead if you're deploying to production.

### 6. Start the development server

```bash
php artisan serve
```

The application will be available at [http://localhost:8000](http://localhost:8000).

---

## Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Build tool:** Vite
- **Database:** MySQL (or any Laravel-supported driver)