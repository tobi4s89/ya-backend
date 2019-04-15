## Documentation Yonego assignment back-end

#### Install and manage project

[Laravel Valet](https://laravel.com/docs/5.8/valet) is one of the recommended virtual machines. Ensure that you have installed [Composer](https://getcomposer.org/doc/00-intro.md) on your local system. 
    
#### Implement Git repository to your own project root folder

    git clone https://github.com/tobi4s89/ya-backend.git
    cd ya-backend

#### Install packages

    composer install
    
#### Database

Make sure you've added a new mysql database. For example: 'yonego_assignment'

#### .env file

Copy the .env.example file, which can be found in the root folder, and rename it to .env. Add the correct data:

    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=yonego_assignment
    DB_USERNAME=root
    DB_PASSWORD=**secret**

#### Application key generate

    php artisan key:generate

#### Database migration

    php artisan migrate
    
#### Dependencies

[Yonego assignment Front-end](https://github.com/tobi4s89/ya-frontend)

## Project information

#### Frameworks

For this project I opted for a laravel back-end, and a VueJS front-end application. I made this choice because I already have some knowledge of both, which means that they can be realized quickly.

#### Algorithm

The algorithm behind this concept is designed to systematically match a requesting user with an offered user. Think of a recruitment and / or dating platform.

#### Back-end data

Data that is saved in a database are properties, users, and a pivot table to connect both of them using one-to-many and many-to-many relationships.

#### Front-end data

As a user you have the option to save reports of the matches they have requested. I chose this method because it is only relevant data for the user himself.
