# role
User role library
## Installation
Add the following lines to your composer.json file
```
"require": {
    ......
    "nksquare/role":"^1.0",
    ......
}
....
"repositories": [
{
    "type": "git",
    "url": "https://github.com/nk-square/role.git"
}]
.....
```
Then run composer update
```
composer update
```
Create migration files
```
php artisan role:table
```
Add role columns to you existing user table
```
php artisan make:migration add_role_to_users --table=users
```
Inside the migration file add the role columns
```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->role();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropRole();
    });
}
```
Run the migrations and populate the roles table with your required roles (eg admin,dept,school etc)
```
php artisan migrate
```
Add the HasRole trait to your User model
```php
<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Nksquare\Role\HasRole;

class User extends Authenticatable
{
    use HasRole;
```
Add role to your users using the following code
```php
$user = User::find(1);
$user->setRole('admin');
```
Check if user has role using the following code
```php
$user->hasRole('admin');//true
//check for multiple roles
$user->hasRole('admin|dept|school');//true
$user->hasRole(['admin','dept','school']);//true
```

