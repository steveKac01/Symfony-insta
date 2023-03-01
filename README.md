# About this app
This app was created to learn Symfony 6. It's a lighty app where you can create a post to put an image and a description. Other users can comment your post.

## Project requirements
To run this app you need PHP 8.1 and Symfony 6.1.

## Configuration
Configure your .env:

A SQLITE database was created and already populated with some fixtures for demo purpose. Feel free to use your own SGBDR.

Start the server `symfony serve`.

## Create an admin user
Use `php bin/console app:add-admin`, simply follow the instructions to create an admin user and get more functionnalities.
