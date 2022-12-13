# Example App

Example [Laravel 9](https://laravel.com/docs/9.x/) app

## Installation

### System

#### Copy `.env.example` to `.env`.

#### **Recommended**: Set a Nova licence key in the .env file:

```dotenv
NOVA_LICENSE_KEY=xyz
```

#### Install requirements

```shell
composer install
```

#### Building und starting Docker container

```shell
./vendor/bin/sail up -d
```

#### Generate App Key

```shell
php artisan key:generate
```

#### Link Storage

```shell
php artisan storage:link
```

#### Migrate database and seed example data

**! Using database Artisan commands in the Laravel Docker Container !**

```shell
php artisan migrate:fresh --seed
```

### Public Page

#### Install node requirements

```shell
npm i
```

#### Run one time production

```shell
npm run build
```

## Update after pull

```shell
composer install
```

**! Using database Artisan commands in the Laravel Docker Container !**

```shell
php artisan migrate
```

**Clear Browser Cache**

## Informationen

* Admin Account: `admin@example.app`
* Password for every seeded account: `password`
* Public Page: http://localhost (Get Server Error without run one time npm prod)
* Administration: http://localhost/admin
* API: http://localhost/api (Postman Collection: [example-app.postman-collection.json](example-app.postman_collection.json))
* API Authentication is made possible with [Laravel Sanctum](https://laravel.com/docs/9.x/sanctum)

### A small overview

* Models `Article` & `Comment` using [Soft Deleting](https://laravel.com/docs/9.x/eloquent#soft-deleting)
* Model `User` have a [„One To Many“](https://laravel.com/docs/9.x/eloquent-relationships#one-to-many) relation to `Article` & `Story` Models
* Model `User` have a nullable [„One To Many“](https://laravel.com/docs/9.x/eloquent-relationships#one-to-many) relation to `Comment` Model
* Model `Comment` have a [„One To Many (Polymorphic)“](https://laravel.com/docs/9.x/eloquent-relationships#one-to-many-polymorphic-relations) relation to `Article` & `Story` Models
* Models `Article` & `Story` have tags by using [Laravel-tags by Spatie](https://spatie.be/docs/laravel-tags/v4/introduction)
* Model activities will be logged with [Laravel-activitylog by Spatie](https://spatie.be/docs/laravel-activitylog/v4)
* Activity API index with filter options
* A small playground with roles and permissions. See [RoleSeeder](database/seeders/RoleSeeder.php)
* Seeder: Every user with a role and 50% of users without a role have an Avatar
* Fallback image for user Avatar

### Packages

* [Laravel Nova 4](https://nova.laravel.com/)
* [Inertia.js](https://inertiajs.com/)
* [Laravel-tags by Spatie](https://spatie.be/docs/laravel-tags/v4)
* [norman-huth/api-controller](https://github.com/Muetze42/api-controller)
* [Laravel-activitylog by Spatie](https://spatie.be/docs/laravel-activitylog/v4)
* [Laravel-medialibrary by Spatie](https://spatie.be/docs/laravel-medialibrary/v10)
* [Laravel-permission by Spatie](https://spatie.be/docs/laravel-permission/v5)
* [dmitrybubyakin/nova-medialibrary-field](https://github.com/dmitrybubyakin/nova-medialibrary-field) (Nova Article)
* [ebess/advanced-nova-media-library](https://github.com/ebess/advanced-nova-media-library) (Nova User)

For Frontend Assets:

* [Vite](https://vitejs.dev/) + [Laravel Vite Plugin](https://laravel.com/docs/9.x/vite)
* [Tailwind CSS](https://tailwindcss.com/)
* [Vue.js 3](https://vuejs.org/)
* [Headless UI](https://headlessui.com/)
