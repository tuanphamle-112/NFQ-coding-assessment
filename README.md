
# Laravel Project Setup Guide

## Prerequisites
- **PHP**: Version 8.0 or higher
- **Composer**: Installed globally
- **MySQL**
- **Cloudinary** account (for image uploading)
- **Git** (optional, for version control)

## Project Setup

### 1. Clone the Repository
Clone the project repository to your local machine:
```bash
git clone https://github.com/tuanphamle-112/NFQ-coding-assessment.git
cd NFQ-coding-assessment
```

### 2. Install Dependencies
Install the PHP dependencies using Composer:
```bash
composer install
```

### 3. Environment Configuration
Copy the example `.env` file and create your own environment configuration:
```bash
cp .env.example .env
```

Open the `.env` file and modify the following values as needed:

#### Database Configuration
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

#### App Key Generation
Generate an application key:
```bash
php artisan key:generate
```

### 4. Run Migrations
Run the database migrations to set up your database schema:
```bash
php artisan migrate
```

### 5. Seed the Database 
Run seeder database to create sample account for authentication:
```bash
php artisan db:seed
```

### 6. Update Autoload and Dump Autoload
Run the following command to regenerate the autoload files:
```bash
composer dump-autoload
```

### 7. Serve the Application
Start the Laravel development server:
```bash
php artisan serve
```
Access your project at `http://127.0.0.1:8000`.

## Assessment Result

## 1. Initialize items
To initialize items from the REST API endpoint, run the following command:

```bash
php artisan items:import
```

## 2. Running the schedule for testing the updateQuality function
To test the scheduling feature (daily update of Quality and SellIn), run the following command:

```bash
php artisan schedule:run
```

## 3. Using Postman to Test the API
  First, access the login API and send a request with the seeded account to get an access token.
  Then, use the access token to test the Upload Image API.

## 4. Running Unit Tests
To ensure everything is set up correctly and test the functionality (e.g., `WolfService`), run the following command:
```bash
php artisan test
```