# TinyURL Test Project

This repository is submitted by John Lioneil Dionisio, for testing and reviewing.

## Get Started

Download the repository.

In the terminal, go into the project directory and run:

```bash
composer install
php artisan key:generate
```

Fill up the database section in the `.env` file generated. Run the migration after:

```bash
php artisan migrate
```

Data can be pre-populated by running the seed command:

```bash
php artisan db:seed
```

This will perform:
- Seed Tags table, 100 entries
- Seed Destinations table, 500 entries
- Each destination will be assigned random status
- Each destination will have 1-10 tags attached
- 100 randomly selected destinations will be soft deleted

**Note:** Caveats when running the seeder again: since tag names and destination aliases are unique in the migrations, an error will most likely be encountered when `faker` generates the same random words. A workaround is to directly edit the values in the `database/seeders/DatabaseSeeder.php` file to a higher number if desired.
