# OTP Authentication System

## Project Description

The project is a simple registration API with [Laravel 8](https://laravel.com) and uses Twilio's verify system for OTP authentication.
## Project Setup

### Cloning the GitHub Repository.

Clone the repository to your local machine by running the terminal command below.

```bash
git clone https://github.com/Ojsholly/camvid-location
```

### Setup Database

Create your a MySQL database and note down the required connection parameters. (DB Host, Username, Password, Name)

### Install Composer Dependencies

Navigate to the project root directory via terminal and run the following command.

```bash
composer install
```

### Create a copy of your .env file

Run the following command

```bash
cp .env.example .env
```

This should create an exact copy of the .env.example file. Name the newly created file .env and update it with your local environment variables (database connection info and others).

### Generate an app encryption key

```bash
php artisan key:generate
```

### Migrate the database

```bash
php artisan migrate
```

### License

[MIT](https://choosealicense.com/licenses/mit/)
