# MKM Test

## Installation

### Requirements
- PHP ^8.0
- Composer
- Laravel 11
- Laravel Valet (optional, for local development with Valet)

### General Installation Steps

1. **Clone the repository to your local machine**
   ```shell
   git clone https://github.com/ogunsakin01/mkm.git
   ```

2. **Change into the project directory**
   ```shell
   cd mkm
   ```

3. **Install project dependencies using Composer:**
   ```shell
   composer install
   ```

4. **Copy the `.env.example` file to create a new `.env` file**
   ```shell
   cp .env.example .env
   ```

5. **Generate the application key**
   ```shell
   php artisan key:generate
   ```

6. **Generate JWT secret using this command below**
   ```shell
   php artisan jwt:secret
   ```

7. **Create a database in your local environment and update the database connection settings in the `.env` file according to your database setup**
   ```dotenv
   DB_CONNECTION=****
   DB_HOST=****
   DB_PORT=****
   DB_DATABASE=****
   DB_USERNAME=****
   DB_PASSWORD=****
   ```

8. **Run database migrations and seed the database**
   ```shell
   php artisan migrate
   ```

9. **Clear the application cache**
   ```shell
   php artisan optimize:clear
   ```

## Starting the application

- To start the application, you can use the built-in Laravel development server:
  ```shell
  php artisan serve
  ```
- Or you can directly use PHP built-in server:
  ```shell
  php -S localhost:8000 -t public/
  ```
- If you choose to use Laravel Valet, run the command below to have it available at [http://mkm.test](http://mkm.test):
  ```shell
  valet link
  ```
- Or if you wish to test locally with SSL, run the command below to have it available at [https://mkm.test](https://mkm.test):
  ```shell
  valet secure
  ```

## Importing products.csv to the database
- Setup you queue connection in the env file to database
  ```dotenv
   QUEUE_CONNECTION=database
  ```
  
- The import process makes use of Jobs and queues. To start the queue worker, run:
  ```shell
  php artisan queue:listen
  ```

- Ensure the file to export is named **products.csv** and is in the public directory. This CSV file must also have the headers: name, sku, brand, and description.

- If this condition has been met, proceed to access the route `http://127.0.0.1:8000/import`, and the entire process will run in the background.

## API Documentation

- You can find the API documentation [here](https://documenter.getpostman.com/view/3172372/2sA3Bn7D3L).
