# Laravel Hobbies Test App
A little app to hobbies crud operation
# Requirements
PHP 7+ and Composer are required.

# Installation
After cloning the repository, Run:
1. Composer update
2. Copy .env.example to a new file .env
3. Edit database configuration in .env, change

   	DB_DATABASE=

	DB_USERNAME=
    	
	DB_PASSWORD=

4. Run php artisan migrate
6. Run npm install
7. Run `php artisan create:categories` to create the default categories (which can be found on config/default)

# Usage
1. Run php artisan serve to run on the default port 8000 or php artisan serve --port=*** to run on your preferred port.
2. Run npm run dev to run the vue.js

# Contributing
All contributions are welcomed and can be made in form of pull requests

# Security Vulnerabilities
If you discover a security vulnerability within RMS, please send an e-mail to Fadayini Timothy at timothy33.tf@gmail.com 

# License
Book test app is open-sourced software licensed under the MIT license.


