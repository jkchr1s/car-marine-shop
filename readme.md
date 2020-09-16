# Car/Marine Shop

## What is this?
This is a project I started in [2016](https://github.com/jkchr1s/car-marine-shop/commit/4a2bcf1670036501d9515422854d583667c09eda) for a friend of mine that ran an auto/boat repair shop. I was going to trade him the app for help doing a V8 conversion on my Jeep Wrangler. Things fell through, and this app was never completed.
* The tag [v1.0.0](https://github.com/jkchr1s/car-marine-shop/releases/tag/v1.0.0) / [starting-point branch](https://github.com/jkchr1s/car-marine-shop/tree/starting-point) is a snapshot of the project when abandoned in 2016.
* I am using this [project board](https://github.com/jkchr1s/car-marine-shop/projects/1) to track things I want to achieve with the project.
* I had a [MySQL Workbench draft of schema I was planning to implement](https://github.com/jkchr1s/car-marine-shop/blob/starting-point/model%20EER.mwb) that helped me quickly refresh where the app was heading.


## Why am I sharing this?
I was asked for an example of my best work, but unfortunately my best work is closed-sourced at the company I work for. It would be unethical to share, and I only have a few days to come up with something to share with you.

Based on the conversation we had, I am pretending that this abandoned project of mine from 2016 is something that a client would bring me that needs a few things added to it. My goals are to:
1. Get the app to [start up and run](https://github.com/jkchr1s/car-marine-shop/commit/c4b0a5767bf8c338b661d13e23d8e69cabbc6985)
2. Update core framework from Laravel 5.2 to Laravel 8 as it was running an unsupported version (these require incremental code changes):
    1. [Upgrade from Laravel 5.2 to 5.3](https://github.com/jkchr1s/car-marine-shop/pull/1)
    2. [Upgrade from Laravel 5.3 to 5.4](https://github.com/jkchr1s/car-marine-shop/pull/2)
    3. [Upgrade from Laravel 5.4 to 5.5](https://github.com/jkchr1s/car-marine-shop/pull/3)
    4. [Upgrade from Laravel 5.5 to 5.6](https://github.com/jkchr1s/car-marine-shop/pull/4)
    5. [Upgrade from Laravel 5.6 to 5.7](https://github.com/jkchr1s/car-marine-shop/pull/5)
    6. [Upgrade from Laravel 5.7 to 5.8](https://github.com/jkchr1s/car-marine-shop/pull/6)
    7. [Upgrade from Laravel 5.8 to 6](https://github.com/jkchr1s/car-marine-shop/pull/7)
    8. [Upgrade from Laravel 6 to 7](https://github.com/jkchr1s/car-marine-shop/pull/8)
    9. [Upgrade from Laravel 7 to 8](https://github.com/jkchr1s/car-marine-shop/pull/9)
3. Document procedure to start up the application
4. Add some new features
    1. [Validate inputs on controllers](https://github.com/jkchr1s/car-marine-shop/issues/30)
    2. [Allow deletion of customer records](https://github.com/jkchr1s/car-marine-shop/issues/28)
    3. [Implmented show customer](https://github.com/jkchr1s/car-marine-shop/issues/25)
    4. [Display error messages in UI](https://github.com/jkchr1s/car-marine-shop/issues/24)
    5. [Modernize JS build process](https://github.com/jkchr1s/car-marine-shop/issues/16)
    6. [Implemented adding vehicles for customers](https://github.com/jkchr1s/car-marine-shop/issues/13)
    7. [Implement middleware to track requests and response times](https://github.com/jkchr1s/car-marine-shop/commit/d561bc0abca042664da12ccc49adf2044d7683bd) to assist with catching issues with slow responses -- useful for telemetry, bug tracking/referring to logs, and trending times to detect issues
    8. Documentation
    9. Docker demo
5. To-do:
    1. Unit tests
    2. Integration tests
    3. Update EER diagram
    4. Evaluate and optimize ORM queries for relationships
    5. Update exception handler to log request IDs for correlation


## Running the demo with Docker
You can build the demo project with Docker by running:
```
docker build . -t auto-marine-shop:latest
```

After building, start up a demo:
```
docker run --name auto-marine-shop --rm -p 8080:80 auto-marine-shop:latest
```
(you can replace `8080` with the port you wish to bind on your local machine -- Apache will be listening on port 80 in the container)

While the demo container is running, create a user:
```
docker exec -it auto-marine-shop /usr/bin/sudo -u www-data php artisan user:create
```

If you've used the default port, you can [open the app up in your browser](http://localhost:8080) and log in with the user you created.


## Requirements
To build the project, you will need:
- A server meeting the [Laravel 8.0 Server Requirements](https://laravel.com/docs/8.x#server-requirements)
- [Composer](https://getcomposer.org/) to install PHP dependencies
- [Node 12 with npm](https://nodejs.org/en/) to build and transpile JavaScript and CSS
- A [database supported by Laravel 8.0](https://laravel.com/docs/8.x/database#introduction)


### Installing Dependencies
Before we can run the application, you first need to install the PHP dependencies. You can do this by running:
```bash
composer install
```

After installing the PHP dependencies, we then need to install the JavaScript dependencies. To do this, run:
```bash
npm ci
```

Finally, we need to run webpack to generate our static assets. Let's kick off Laravel Mix to build our development dependencies by running:
```bash
npm run dev
```


### Configuration
Now that we have our dependencies installed, we need to configure our application. In production environments, we will declare environment variables in our Docker container, but for local development we can use [phpdotenv](https://github.com/vlucas/phpdotenv). First, copy the example file to `.env`:
```bash
cp .env.example .env
```

Since our application requires an encryption key, you'll need to generate a new one:
```bash
php artisan key:generate
```

If you have a database instance readily available, create a new database, user, and password. Alternatively, you can use sqlite after installing the PHP sqlite PDO driver. **If you're using sqlite**, you can create an empty database:
```bash
touch database.sqlite
```

Next, open the `.env` file in your favorite text editor. Refer to [config/database.php](config/database.php) to see which environment variables are required for your database system, and be sure to fill in your `.env` file accordingly. **If you're using sqlite**, you can use these values:
```
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite
```
(be sure to replace `/path/to/database.sqlite` with the fully-qualified path to the sqlite database you're trying to use)


### Get the database up and running
Now that you've configured the database, we need to run our [migrations](database/migrations) to create the tables necessary to run the application. To do this, run:
```bash
php artisan migrate
```

Go ahead and seed the database with some example data:
```bash
php artisan database:seed
```

### Create an initial user account
We're almost up and running! Create an initial user so we can log in to the application by running:
```bash
php artisan user:create
```
(simply answer the questions as prompted)


## Start the application
Now that we have installed our depenencies, migrated, seeded the database, and created a user account, we're ready to start the app! To use the built-in development server, run:
```bash
php artisan serve
```
and [open the application in your browser](http://localhost:8000)


## Additional Notes
My mentality has changed a lot since originally writing (and abandoning) this project. Some notes:
* Several JavaScript assets were included in the [public folder](public/) with no documentation of where these came from. This is bad, and I no longer do this.
* [Original templates](resources/views) are copy and pasting things everywhere... I left the old as-is as an example of picking up a project and not doing re-work, but my [new](resources/views/vehicle_model/index.blade.php) [stuff](resources/views/vehicle/create.blade.php) is utilizing [partials](resources/views/partials). The old-school server-side crud mentality is hard to leave as-is and not modernize as a SPA, but I'm trying to make things fit in to the old project without completely rewriting large chunks of code.
* This project will be a work-in-progress throughout the week.
* [New](app/Http/Controllers/VehicleModelController.php) [controllers](app/Http/Controllers/VehicleController.php) use much better validation rules than existing ones. Ideally, I'd go through and re-work the old ones given the time.
* The [Material Design library](public/js/material.js) is not very accessible -- it does not work with keyboard navigation on drop-down menus. I would not pick this today, but left it as-is.
* This project was built on Bootstrap 3, which inevitably brought jQuery along with it... with ES6, this is overkill, and I wouldn't do this today. See [my common JavaScript shared library](https://github.com/jkchr1s/jkchr1s-libs), also [now being used in this app](resources/js/app.js)
* Error handling needs to be refactored
* Optimize queries so that related models don't perform multiple queries
* This application is still incomplete. It's not possible for me to complete it over a weekend, but hopefully you agree that it's good to see me in action picking up something that I haven't touched in 2016, updating the core framwork, and adding new features to it. I'd love to show it to you, discuss things that are wrong with it, things I'd do differently, etc.
