# Eloquent Coffee Co


<p align="center">
<img src="public/images/logos/banner.png" alt="Eloquent Coffee Co" width="100%">

</p>
```
A Laravel-based admin and storefront application for managing a coffee
product catalogue --- including inventory, pricing, origins, roasts, and
types.

------------------------------------------------------------------------

## Requirements

Before setting up the project, make sure your system has the following
installed:

-   **PHP 8.2+**
-   **Composer**
-   **Node.js 20+**
-   **npm**
-   **MySQL 8+** (or any Laravel-supported database)

You can verify your installations with:

``` bash
php -v
composer -V
node -v
npm -v
```

### Required PHP Extensions

Ensure the following PHP extensions are enabled in your `php.ini` file:

-   `pdo_mysql`
-   `fileinfo`
-   `mbstring`
-   `openssl`
-   `tokenizer`
-   `xml`
-   `ctype`
-   `json`

You can check enabled extensions with:

``` bash
php -m
```

------------------------------------------------------------------------

## Getting Started

### 1. Clone the repository

``` bash
git clone https://github.com/Timalm90/Eloquent-Coffee-Co.git
cd Eloquent-Coffee-Co
```

### 2. Install PHP dependencies

``` bash
composer install
```

### 3. Configure the environment

``` bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure your database

Create a database named:

``` sql
CREATE DATABASE eloquent_coffee;
```

Then open `.env` and configure your database connection:

``` env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eloquent_coffee
DB_USERNAME=root
DB_PASSWORD=your_password
```

> If your database is running on a different port, update `DB_PORT`
> accordingly.

------------------------------------------------------------------------

### 5. Run migrations and seed the database

``` bash
php artisan migrate:fresh --seed
```

This will:

-   Create all database tables
-   Populate the database with sample data

------------------------------------------------------------------------

### 6. Install frontend dependencies

``` bash
npm install
```

------------------------------------------------------------------------

### 7. Run the development build

``` bash
npm run dev
```

For production builds:

``` bash
npm run build
```

------------------------------------------------------------------------

### 8. Start the Laravel development server

Open a new terminal window and run:

``` bash
php artisan serve
```

The application will be available at:

    http://localhost:8000

------------------------------------------------------------------------

## Default Admin Credentials

  Field      Value
  ---------- --------------
  Username   `admin`
  Password   `coffeebean`

------------------------------------------------------------------------

## Troubleshooting

### MySQL: "Access denied for user 'root'"

Update the database credentials in your `.env` file to match your MySQL
username and password.

------------------------------------------------------------------------

### MySQL: "Unknown database"

Create the database manually before running migrations:

``` sql
CREATE DATABASE eloquent_coffee;
```

------------------------------------------------------------------------

### Laravel: "could not find driver"

Enable the `pdo_mysql` extension in your `php.ini` file.

------------------------------------------------------------------------

### Composer error: "ext-fileinfo missing"

Enable the `fileinfo` extension in your `php.ini`.

------------------------------------------------------------------------

### Vite error: Node version too old

Make sure you are using **Node.js 20 or higher**.

Check with:

``` bash
node -v
```

------------------------------------------------------------------------

### Laravel config caching issues

If configuration changes are not reflected, clear caches:

``` bash
php artisan config:clear
php artisan cache:clear
```

------------------------------------------------------------------------

## Tech Stack

-   **Backend:** Laravel (PHP)
-   **Frontend:** Blade, Tailwind CSS, Alpine.js
-   **Build Tool:** Vite
-   **Database:** MySQL (or any Laravel-supported driver)

------------------------------------------------------------------------

## License

This project is open-source and available under the MIT License.
