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

### 3. Configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

> If your database is running on a port other than `3306`, update `DB_PORT` in `.env` accordingly.

### 4. Run migrations and seed the database

```bash
php artisan migrate:fresh --seed
```

### 5. Install frontend dependencies and compile assets

```bash
npm install
npm run dev
```

### 6. Start the development server

Open a new terminal window and run:

```bash
php artisan serve
```

The application will be available at [http://localhost:8000](http://localhost:8000).

**Default credentials**

| Field    | Value        |
|----------|--------------|
| Username | `admin`      |
| Password | `coffeebean` |

---

## Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Build tool:** Vite
- **Database:** MySQL (or any Laravel-supported driver)
