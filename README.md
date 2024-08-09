## SIMBIOTIK-Backend

### Setup and Run Project

- Clone Project
```
git clone https://github.com/SIMBIOTIK-project/SIMBIOTIK-backend.git
```

- Install composer
```
composer install
```

- Edit .env.example to .env and edit file to this
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_simbiotik (Change with with your database)
DB_USERNAME=root
DB_PASSWORD=

```

- Migrate project
```
php artisan migrate
```

- Run Server
```
php artisan serve
```

#### Route API
- Register
```
localhost/api/register
```
- Login
```
localhost/api/login
```
- Logout
```
localhost/api/logout
```
- Get user
```
localhost/api/user
```

#### Fix Error (Use this if any errors)
- if error jwt.php
```
php artisan key:generate
php artisan jwt:secret
php artisan cache:clear
php artisan config:clear
```