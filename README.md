## LiveSchool - Student Management System
LiveSchool is an innovative student and school management software designed to streamline and digitize a wide array of school activities related to students. By transforming traditional school operations into an online format, LiveSchool enhances the efficiency and accessibility of essential educational processes.

## Features
- Realtime Attendance
- Class Test Marks & Details
- Exam Details & Marks
- Performance Indicators
- Live Van Location
- Announcements
- Activity/Events Calendar
- Syllabus/Notes
- Fee Details
- Student Profile

## Installation

Follow the steps to install "LiveSchool":

- Clone the repository
```
git clone https://github.com/harman-codes/LiveSchool.git
```
- Enter into directory
```
cd LiveSchool
```
- Install dependencies
```
composer install
```
```
npm install
```
- Generate .env file
```
cp .env.example .env
```
- Generate app key
```
php artisan key:generate
```
- Add MySQL database details in .env file. For sqlite database, create a file in "database" folder named "database.sqlite"
```
php artisan migrate
```
- Add dummy data
```
php artisan db:seed
```
- Add storage link
```
php artisan storage:link
```
- Run development server
```
npm run dev
```
- Serve the app
```
php artisan serve
```
- open http://localhost:8000 in your browser


## Default Login
Admin Login : 
- Url : http://localhost:8000/admin
- username/Email : admin@test.com
- password : 1234

Parent Login :
- Url : http://localhost:8000/parent
- username/Email : parent@test.com
- password : 1234


You can change the default login at "database/seeders/DatabaseSeeder.php"

## Google Map
Add **MAP_KEY="your_google_map_key"** in .env file

## License

The LiveSchool is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
