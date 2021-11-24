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
