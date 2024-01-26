<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Specifications

- Laravel v10.39.0
- PHP v8.1.27
- Apache v2.4.54 VS16
- Composer v2.6.6
- MySQL v8.0.30

## Setup Project

- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan migrate
- php artisan db:seed --class=UnitTestingSeeder
- php artisan passport:install
- php artisan serve

## Custom Command

- php artisan local:test --with-code-fix

- php artisan make:mc-controller Example
- php artisan make:mc-service Example
- php artisan make:mc-repository-contract Example
- php artisan make:mc-request Example
- php artisan make:mc-resource Example

- php artisan make:mc-crud Example
