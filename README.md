# Laravel Authentication Log

## Installation

> Laravel Authentication Log requires PHP 7.0+.

You may use Composer to install Laravel Authentication Log into your Laravel project:

    composer require malekk/laravel-auth-log

### Configuration

Once installed, if you are not using automatic package discovery, then you need to register the `Malekk\LaravelAuthLog\AuthLogServiceProvider` service provider in your config/app.php.

You need to migrate your database, the laravel-auth-log migration will create the table to store authentication logs:

    php artisan migrate

Finally, add the `AuthenticationLogable` trait to your `User` model (by default, `App\Models\User` model). The trait provide various methods to allow you to get common authentication log data, such as last login time, last login IP address:

```php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Malekk\LaravelAuthLog\Models\AuthenticationLogable;

class User extends Authenticatable
{
    use AuthenticationLogable;
}
```

### Basic Usage

Get all authentication logs for the user:

```php
User::find(1)->authentications;
```

Get the user last login info:

```php
User::find(1)->lastLoginAt();

User::find(1)->lastLoginIp();
```

## Contributing

Thank you for considering contributing to the laravel-auth-log!

## License

Laravel-Auth-Log is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
