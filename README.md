# Leave-Management-System
This task from Business Automation Ltd.

## Description
- Laravel version 10
- PHP 8.1
- Installed laravelcollective package
- For good user interface, I installed a free theme (AdminLte)
- In this project two user group admin and Employee. But User group management is here, Admin can ceate multiple user group.
- Admin can signup from register module and after manager login, Admin can create Employee with their info.

- Employee can login with their email and password.

## Installation
- For clone this project run this command: git clone https://github.com/shakil566/Leave-Tracker.git
- Create a database
- Then rename .env.example file to .env file and add database name

- Then run these command: 
- composer update
- npm install
- npm run dev
- php artisan key:generate
- php artisan migrate
- php artisan optimize:clear (optional)
- php artisan serve

- if you want existing data, then need to run these seeder command or project root directory has lms_full_database file exists.
- php artisan db:seed --class=UserGroupSeeder
- php artisan db:seed --class=UserSeeder
- php artisan db:seed --class=LeaveCategorySeeder
- php artisan db:seed --class=LaeaveManagement

- After installation you can login with these credentials if you want. Or you can signup as Admin.

- Admin credentials:
- email:admin@gmail.com
- password:Admin123@

- Employee credentials:
- email:shakils923@gmail.com
- password:Admin123@