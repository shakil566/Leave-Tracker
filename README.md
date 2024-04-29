# Leave-Management-System(Leave Tracker)

## Description
- Laravel version 10
- PHP 8.1
- Installed laravelcollective package
- For good user interface, I installed a free theme (AdminLte)

- In this project two user group admin and Employee. But User group management is here, Admin can ceate multiple user group.
- Admin can create Employee with their info.
- Admin can create Leave Category
- Admin can submit leave application for a Employee with his all info.
- Admin can manage leave application like Approved, Reject with Remarks, after than automatic mail send to employee.
- Admin can see all statistics in Dashboard

- Employee can Register with his info.
- After Registration Employee is inactive, he can not not login. Admin need to activate this employee for login.
- Employee can login with their email and password.
- Employee can edit his profile
- Employe submit leave application with some information, then he got a mail.
- Employee can see his all Leave Application History and Status with admin remarks.

## Installation
- For clone this project run this command: git clone https://github.com/shakil566/Leave-Tracker.git
- Create a database
- Then rename .env.example file to .env file and add database name

- Then run these command: 
- composer update
- npm install
- npm run dev
- php artisan key:generate
- php artisan queue:table (for queue, jobs table)
- php artisan migrate
- php artisan optimize:clear (optional)
- php artisan serve

- For Email send with Queue in Leave Application Submit, Approve and Reject:
- php artisan queue:work

- if you want existing data, then need to run these seeder command or project root directory has leave_tracker_full_db file exists.
- php artisan db:seed --class=UserGroupSeeder
- php artisan db:seed --class=UserSeeder
- php artisan db:seed --class=LeaveCategorySeeder
- php artisan db:seed --class=LaeaveManagementSeeder

- After installation you can login with these credentials if you want. Or you can signup as Admin.

- Admin credentials:
- email:admin@gmail.com
- password:Admin123@

- Employee credentials:
- email:shakils923@gmail.com
- password:Admin123@


## Thank You