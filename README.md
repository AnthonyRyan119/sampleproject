<p align="center"><a target="_blank"><img src="<a href="https://www.freepik.com/free-vector/user-verification-unauthorized-access-prevention-private-account-authentication-cyber-security-people-entering-login-password-safety-measures_12146011.htm#fromView=search&page=1&position=0&uuid=32b76eef-5bce-44de-8dba-0a80f0213445">Image by vectorjuice on Freepik</a>" width="180"></a></p>

<h1 align="center">Sample Laravel Project</h1>

## Table of Contents 
- [Introduction](#introduction)
- [Installation](#installation)
- [Features](#features)
- [Credits](#credits)
- [License](#license)

## Introduction

A very simple web application built with laravel and Vue.js.

The application is designed and tested to use conveniently without any issues.

## Features

- Built with Laravel 7
- Vue.js
- Login
- Dashboard
- Manage user accounts
    .Create user
    .Update user
    .Delete user
    .View user
- Manage product accounts
    .Create product
    .Update product
    .Delete product
    .View product
- Upload product images
- Responsive UI
- Many more features....

## Installation

- Clone this repo using any method (https, ssh, gh cli)

- Set the configuration file using the command 
``` copy .env.example .env ```

- Install all required packages via composer. ``` composer install ```

- Set up Database configuration inside .env file.

- Run the migration

```
php artisan migrate
```

- Install all dependencies via `npm` and Compile all assets based on your deployment environment. 

#### Npm
```bash
#Install all dependencies
npm install

#Development
npm dev

#Production
npm prod
```

- Create symbolic link 
```
php artisan storage:link
```

- Start the local server using the command
```
php artisan serve
```

### Current Admin Credentials

- Run the seeder to create a default admin credentials
```
php artisan db:seed --class=UserSeeder
```

You may use these credentials to log into the website. you can change these credentials shortly on admin maintenance after logging in.
You may also either use the admin email or username to log into the website.

**Email** : Admin@gmail.com<br>
**Username** : Admin<br>
**Password** : password


## Generating Sample Product

Creates dummy product using seeder.

```
php artisan db:seed --class=ProductSeeder
```

## Credits

- [@AnthonyRyan119](https://github.com/AnthonyRyan119)

## License

[MIT](LICENSE) © AnthonyRyan119
