#  MKM Test
## Installation

### Requirement
- PHP ^8.0
- Composer
- Laravel 11
- Laravel Valet (optional, for local development with Valet)

### General Installation Steps

#### 1. Clone the repository to your local machine
```shell
git clone https://github.com/ogunsakin01/mkm.git
```

#### 2. Change into the project directory
```shell
cd mkm
```

#### 3. Install project dependencies using Composer:
```shell
composer install
```

#### 4. Copy the .env.example file to create a new .env file
```shell
cp .env.example .env
```

#### 5. Generate the application key
```shell
php artisan key:generate
```

#### 6. Generate JWT secret using this command below
```shell
php artisan jwt:secret
```

#### 7. Create a database in your local environment and update the database connection settings in the .env file according to your database setup
```dotenv
DB_CONNECTION=****
DB_HOST=****
DB_PORT=****
DB_DATABASE=****
DB_USERNAME=****
DB_PASSWORD=****
```

#### 8. Run database migrations and seed the database
```shell
php artisan migrate
```

#### 9. Clear the application cache
```shell
php artisan optimize:clear
```

## Starting the application
To start the application, you can use the built-in Laravel development server

```shell
php artisan serve
```
or you can directly use PHP built-in server
```shell
php -S localhost:8000 -t public/
```

or if you choose to use Laravel Valet, run the command below to have it available at [http://e-com-test.test](http://e-com-test.test)
```shell
valet link
```
or if you wish to test locally  with SSL, run the command below to have it available  at [https://e-com-test.test](https://e-com-test.test)
```shell
valet secure
```

