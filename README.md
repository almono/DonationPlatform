# Laravel Donation Platform application

To build the project:
- Copy the repository
- In the main directory run ```composer install```
- In the frontend directory run ```npm run install```
- In the main directory run ```docker compose build --no-cache``` and after it has finished building ```docker compose up -d```
- Inside the php container make sure you run the laravel migrations ```php artisan migrate``` ( ```php artisan migrate:install``` in case the previous did not work )
- After that generate APP token with ```php artisan key:generate``` and ```php artisan jwt:secret``` ( might require config clear with ```php artisan config:clear``` )
- As the final step please run ```php artisan db:seed``` to seed database with example data

- To run the functional tests run ```./vendor/bin/pest tests/Feature/CampaignControllerTest.php``` inside php container

Your project should be available under these URLs:
- Frontend http://localhost:5137 ( this is the URL that should be used )
- Laravel http://localhost:8000
- Swagger UI http://localhost:8000/api/documentation ( OpenAPI for testing some configured endpoints )
- Mailpit http://localhost:8025 ( this is where the emails coming from the application can be viewed )
- PHPMyAdmin http://localhost:8080 ( user and password are both "laravel" )


# Features

- PHP 8.4
- Vue.js ( version 3 )
- MySQL with PHPMyAdmin
- Nginx
- Mailpit
- Basic authentication ( with user login and registration )
- Swagger UI ( to update Swagger endpoints use ```php artisan l5-swagger:generate``` in the main directory )

# Information

- Admin user credentials: admin@admin.admin / admin
- Normal user credentials: user@user.user / user
- User assigned to a group credentials: group@group.group / user


# Environment Variables

To run this project, you will need to add/update the following environment variables to your .env file

Database:
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_api_db
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

Mailpit:
```
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="laravel-template@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

JWT:
```
JWT_SECRET=XXX
```

# Application Screenshots

## Login Screen
![image](https://github.com/user-attachments/assets/1fbfb026-ff62-42e1-9788-e19a60f6e1ea)

## Admin Dashboard View
![image](https://github.com/user-attachments/assets/c26e77c7-7804-4e28-8752-84152f974711)

## Basic User View
![image](https://github.com/user-attachments/assets/e3695172-784e-4339-852e-d3c3ad200ef5)

## Donation Email ( taken from Mailpit )
![image](https://github.com/user-attachments/assets/e6aec0dd-9af6-43c9-94e9-c3d5cfd6ee3f)

## Test Results
![image](https://github.com/user-attachments/assets/e6992d5c-97a3-4980-9229-21a4db283948)

