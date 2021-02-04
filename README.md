# role
User role library
## Installation
Add the following lines to your composer.json file
```
....
"repositories": [
{
    "type": "git",
    "url": "https://github.com/nk-square/role.git"
}],
.....
```
Run composer
```
composer require nksquare/role
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
## Usage
Check if user has role using the following code
```php
$user->hasRole('admin');//true
//check for multiple roles
$user->hasRole('admin|dept|school');//true
$user->hasRole(['admin','dept','school']);//true
```
For adding authorization to routes use the role middleware
```php
Route::get('admin-page','AdminPageController@index')->middleware('role:admin');//only user with admin role can access this route
Route::get('common-page','CommonPageController@index')->middleware('role:admin,dept');//users with admin and dept role can access this route
```
