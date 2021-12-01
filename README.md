## Property App

## Installation
- Clone the repository with `git clone https://github.com/xqsit94/property-app.git`
- Copy `.env.example` file to `.env` and edit database credentials there
- Run `composer install`
- Run `php artisan key:generate`
- Run `php artisan migrate --seed`
- Compiling Vue `npm i && npm run dev`
- Run the project by `php artisan serve`

** Seeding (--seed) will populate dummy data's for Users table along with Phone number relationship **

## Factories & Postman Collection
- Factories command check [FACTORIES.md](docs/FACTORIES.md)
- [Postman Collection](docs/PropertyApp.postman_collection.json) for properties api

## PHP Unit Testing

- default testing database connection is given 'sqlite' inside [phpunit.xml](phpunit.xml)
```xml
<server name="DB_CONNECTION" value="sqlite"/>
```
- Redundant test methods are written in [TestHelperTrait](app/Traits/TestHelperTrait.php) for "DRY up"
- to run test `php artisan test`
