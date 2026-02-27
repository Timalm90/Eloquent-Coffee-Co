# Eloquent-Coffee-Co

**Project:** Laravel Coffee Admin Tool  
**Due Date:** March 13th, 09:00  
**Group Members:** [Your Name], [Collaborator Name]

---

## Project Description

Eloquent-Coffee-Co is an admin interface for managing coffee products. The system allows users to:

- Create, read, update, and delete coffee products.
- Filter products by attributes like intensity, origin, type, and more.
- View coffee products with associated images.
- Demonstrate accessible design (a11y) best practices.

> Note: This is **not a storefront**. The project is focused on the admin management side.

---

## MVP Features

### Core Functionality

1. **Database & Models**
    - `Product` table with:
        - `id`, `name`, `type_id`, `intensity`, `origin`, `image_url`, `price` (optional) - CHECK!
    - `Type` table (e.g., `whole beans`, `capsules`, `ground`) with associated image. - Done type table, associative image with if statement in blade?
    - Seeder and factory to generate realistic mock data for products and types. - CHECK!

2. **CRUD Operations**
    - Admin can **Create, Read, Update, Delete** coffee products. (In app/Http/Controllers)
    - Forms should be labeled clearly and provide accessible error messages. (In blade files)

3. **Filtering**
    - Filter products by at least **two attributes** (e.g., intensity, origin). (In app/Http/Controllers)
    - Optional: filter by type or price range.

4. **Frontend**
    - Display list of products with:
        - Image
        - Name
        - Intensity
        - Origin
        - Type
    - Pagination for VG grade.
    - Accessible design:
        - Semantic HTML
        - Proper labels on forms
        - Sufficient color contrast
        - Avoid relying solely on color for meaning
        - Legible fonts that scale correctly

5. **Seeded Data**
    - Use realistic coffee names, origins, and intensities.
    - One image per type.

---

## 🔨 Step-by-Step Development Plan

### Step 1: Setup & Configuration

- **Both**: Setup Laravel project and GitHub repo with proper branches (`main`, `dev`, `feature/*`).
- **Both**: Configure database connection, install dependencies.

### Step 2: Database & Models

- **Person A**: Create migrations for `products` and `types`.
- **Person B**: Setup Eloquent models with relationships:
    - `Product` belongs to `Type`.
    - `Type` has many `Products`.
- **Both**: Create factories and seeders with realistic mock data.

### Step 3: Backend CRUD

- **Person A**: Implement `ProductController` with CRUD methods.
- **Person B**: Implement routes and resourceful routing in `web.php`.

### Step 4: Frontend & Filtering

- **Person A**: Design list view with semantic HTML, accessible forms, and pagination.
- **Person B**: Implement filtering functionality by intensity, origin, or type.
- **Both**: Ensure filters work dynamically and UI updates accordingly.

### Step 5: Accessibility & Styling

- **Both**:
    - Ensure semantic HTML is used.
    - Check color contrast.
    - Verify font scaling works.
    - Add error messages and proper labels for forms.

### Step 6: Testing & Demo Prep

- **Both**:
    - Test CRUD and filters.
    - Populate database with seed data.
    - Zoom test for responsive/a11y.
    - Prepare README with installation instructions.

---

## File/Variable Naming Guidelines

- Controllers: `ProductController.php`
- Models: `Product.php`, `Type.php`
- Views: `products/index.blade.php`, `products/create.blade.php`, etc.
- Routes: Use resourceful naming (`products.index`, `products.create`, etc.)
- Variables: descriptive, e.g., `$coffee`, `$productType`, `$filteredProducts`.

---

## Installation Instructions

1. Clone repo:
    ```bash
    git clone [repo_url]
    cd eloquent-coffee-co
    ```
