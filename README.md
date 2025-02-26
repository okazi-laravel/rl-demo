# rl-demo

## Step 1: Install Laravel
```sh
composer create-project laravel/laravel rl-demo
```

## Step 2: Install the Reusable Library
```sh
cd rl-demo  # Navigate to the project root
composer install
composer require bjitgroup/reusable-lib-laravel
```

## Step 3: Configure the .env File
Ensure the correct database connection and APP_URL settings:
```dotenv
APP_URL=http://localhost:8000
```

## Step 4: Install the Reusable Library
```sh
php artisan bjit:reusable-lib-install
```

## Step 5: Install Sanctum
```sh
php artisan install:api
```

## Step 6: Serve the Application
```sh
php artisan serve
```

### API Documentation (Swagger)
Access the API documentation by opening your browser and navigating to:
```
http://localhost:8000/api/documentation
```

**NB:** The `tymon/jwt-auth` package appears to have been abandoned and isn’t compatible with Laravel 11. We have a new package on top of `tymon/jwt-auth` which is `php-open-source-saver/jwt-auth`. Follow these blogs for details:
1. [Implementing JWT Authentication in Laravel 11](https://blog.logrocket.com/implementing-jwt-authentication-laravel-11/)
2. [How to Implement JWT in Laravel API](https://dev.to/germanlozickyj/how-to-implement-jwt-in-laravel-api-4590)
```
