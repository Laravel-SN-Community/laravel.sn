<p align="center">
    <img src="https://pbs.twimg.com/profile_images/1882727642266255360/iZnGTRJT_400x400.jpg" width="400" alt="Laravel Senegal community logo with isometric design in Senegalese flag colors.">
</p>

------

## Installation

This is a regular Laravel application; it's built on top of [Laravel 12](https://laravel.com) and uses : 
  -  [Livewire](https://livewire.laravel.com/) 
  -  [AlpineJs](https://alpinejs.dev/)
  -  [Tailwind CSS](https://tailwindcss.com/)  

In terms of local development, you can use the following requirements:

- PHP 8.2^
- Node.js 16 or more recent
- sqlite as database

If you have these requirements, you can start by cloning the repository and installing the dependencies:

```bash
git clone https://github.com/Laravel-SN-Community/laravel.sn

cd laravel.sn

git checkout -b feature/your-feature # or fix/your-fix
```

> **Don't push directly to the `main` or `dev` branch**. Instead, create a new branch and push it to your branch.

Next, install the dependencies using [Composer](https://getcomposer.org) and [NPM](https://www.npmjs.com):

```bash
composer install

npm install
```

After that, set up your `.env` file:

```bash
cp .env.example .env

php artisan key:generate
```

Prepare your database and run the migrations:

```bash
php artisan migrate --seed
```

Link the storage to the public folder:

```bash
php artisan storage:link
```

In a **separate terminal**, build the assets in watch mode:

```bash
npm run dev
```

Finally, start the development server:

```bash
php artisan serve
```
# Admin credentials
- Email: admin1@gmail.com
- Password: passer

> Create GEMINI_API_KEY in your .env file to enable AI features.

> You can now access the application at [http://localhost:8000](http://localhost:8000) and the admin panel at [http://localhost:8000/admin](http://localhost:8000/admin).

> Note: By default, emails are sent to the `log` driver. You can change this in the `.env` file to something like `mailtrap`.

Once you are done with the code changes, be sure to run the test suite to ensure everything is still working:

```bash
composer test
```

If everything is green, push your branch and create a pull request:

```bash
git commit -am "Your commit message"

git push
```

Visit [github.com/Laravel-SN-Community/laravel.sn/pulls](https://github.com/Laravel-SN-Community/laravel.sn/pulls) and create a pull request.

## Tooling

Laravel.sn uses a few tools to ensure the code quality and consistency. Of course, [Pest](https://pestphp.com) is the testing framework of choice, and we also use [PHPStan](https://phpstan.org) for static analysis.

In terms of code style, we use [Laravel Pint](https://laravel.com/docs/11.x/pint) to ensure the code is consistent and follows the Laravel conventions.

You run these tools individually using the following commands:

```bash
# Lint the code using Pint
composer lint
composer test:lint

# Run PHPStan
composer test:types

# Run the test suite
composer test:unit

# Run all the tools
composer test
```

## Production

Laravel.sn is hosted on [DigitalOcean](https://www.digitalocean.com) and uses [Laravel Forge](https://forge.laravel.com) to manage the server and deployments.
---

## Licence
this is an open-sourced software licensed under the **[GNU Affero General Public License](LICENSE.md)**
