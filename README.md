<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## System Login and Access Control

With this system API, you can manage your users by your system. Here you have a CRUD for users, and you can use the roles create by default or can create your own roles and permissions.

- PHP 8.0+
- Laravel 11.0+
- MySQL 8.0+

## Start your project
Clone this repository.

``` 
    git clone https://github.com/danielcandidocel/access_control.git "project_name"
```

Enter in the project folder and run the following commands:

``` 
    cd project_name 
    docker-compose up -d --build
```

Run composer to install all dependencies:

```
    composer install
```

Create your .env file.

```
    cp .env.example .env
```

After that, you need to enter in your repository:

``` 
    docker-compose exec app bash
```

Run your migrations and seeders with the following command:

``` 
    php artisan migrate --seed
```
This command will create a user with the following credentials:

``` 
    email:superadmin@example.com
    password:password
    or
    email: admin@example.com
    password: password
```

Also will create the following roles:

``` 
    Super Admin
    Admin
    User
```

You can see the permissions in the database. By default, the Super Admin has all permissions.

You can create your own roles and permissions.
Or you can sync the roles with the users.

All the functions you can see in the route files.

``` 
    routes/api.php
```

You can use this user to access the system and create your own users, roles, and permissions.

Always you create a rote and you define a name for it, and run the seeders, the system will create a permission with the same name. And SuperAmin role will have this permission.



## Contact

If you would want to talk to me, please send an e-mail to me [danielcandidocel@gmail.com](mailto:danielcandidocel@gmail.com). I will be happy to help you.
