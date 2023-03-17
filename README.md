# About this app
This app was created to learn Symfony 6. It's a lighty app where you can create a post to put an image and a description. Other users can comment your post.

## Project requirements
To run this app you need PHP 8.1 and Symfony 6.1.

## Run the app

Git clone this repository.

run `composer install` to install the vendors.

Start the server with `symfony serve`.

Launch docker containers with `docker compose up -d`

Do the migration `php bin/console doctrine:migration:migrate`

Optionnal : You can load fixtures with the command `php bin/console doctrine:fixtures:load`

## Create an admin user
Use `php bin/console app:add-admin`, simply follow the instructions to create an admin user and get more functionnalities.
