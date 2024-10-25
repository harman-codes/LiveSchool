## Installation

Follow the steps to install "Student Management System" :

- git clone "https://github.com/harmanrulez/student-management-system.git"
- cd student-management-system
- composer install
- npm install
- cp .env.example .env
- php artisan key:generate
- Add MySQL database details in .env file. For sqlite database, create a file in "database" folder named "database.sqlite"
- php artisan migrate
- php artisan db:seed
- php artisan storage:link
- npm run dev
- php artisan serve
- open http://localhost:8000 in your browser

Please Note : "php artisan db:seed" command is used to add dummy data to the database.

## Default Login
- username/Email : admin@test.com
- password : 1234

You can change the default login at "database/seeders/DatabaseSeeder.php"

## License

The "Student Management System" is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
