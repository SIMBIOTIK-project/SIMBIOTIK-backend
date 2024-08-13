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

- Change .env.example to .env and edit file to this
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_simbiotik (Change with with your database)
DB_USERNAME=root
DB_PASSWORD=

JWT_SHOW_BLACKLIST_EXCEPTION=true

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
Note: For All using Bearer Token except Register, and Login
header:
| Key   | Value  |
|-----------|-----------|
| Accept | application/json |
| Content-Type | application/json|
| Authorization | Bearer <spasi> Token |

1. Authentication
- Register (POST)
```
localhost/api/register
```
body/form-data:
| Key   | Value  |
|-----------|-----------|
| name | Fill in according to your preference |
| email | Fill in according to your preference |
| password | Fill in according to your preference|
| password_confirmation | Fill in according to password field |
| nik | Fill in according to your preference |
| phone_number | Fill in according to your preference |
| address | Fill in according to your preference |
| status | nasabah/admin/owner |
- Login (POST)
```
localhost/api/login
```
body/form-data:
| Key   | Value  |
|-----------|-----------|
| email | The email address used during registration |
| password | The password address used during registration|
- Logout (POST)
```
localhost/api/logout
```
- Get user (GET)
```
localhost/api/user
```
2. Waste Types
- Get list waste type (GET)
```
/wastetypes
```
- Get detail by id (GET)
```
/wastetype/{id}
```
- Create new waste type (POST)
```
/wastetypes
```
body/x-www-form-urlencoded:
| Key   | Value  |
|-----------|-----------|
| type | Name of waste |
| price | Value of price waste /kg |
- Update waste type data (PUT)
```
/wastetypes/{id}
```
body/x-www-form-urlencoded:
| Key   | Value  |
|-----------|-----------|
| type | Name of waste |
| price | Value of price waste /kg |
- Delete waste type data (DELETE)
```
/wastetype/{id}
```

#### Fix Error (Use this if any errors)
- if error jwt.php
```
php artisan key:generate
php artisan jwt:secret
php artisan cache:clear
php artisan config:clear
```