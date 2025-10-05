# 📝 Activity Tracker for Support Team

This project is an Activity Tracker built with Laravel. It allows the applications support team to track daily activities, update activity statuses, add remarks, view activity histories, and manage handovers between team members.

This system helps improve visibility, accountability, and seamless collaboration among personnel handling activities.

---

## 🚀 Features

-   session-authenticated  for personnel access
- Create, view, edit,  activities
- Update activity status (pending / done) with remarks
- Capture personnel bio details (name, department, position) when updating activities
- Daily view of all activity updates for smooth handover
- Activity history reporting for custom date ranges
- Overview of pending and completed activities
- Role-based access 

---

## 🛠 Tech Stack

- PHP 8.x
- Laravel 12.x
- MySQL / PostgreSQL / SQLite
- Blade templates for frontend
- Tailwind CSS for UI styling 


---



## 📦 Installation

1. **Clone the Repository**

```bash
git clone https://github.com/oys2021/trackSupport.git
cd trackSupport

```


2.**Install Dependencies**
```bash
composer install
npm install
npm run dev

```

3.**Set Up Environment**
```bash


Right-click .env.example file → Copy.

Right-click in the project folder → Paste → rename the copied file to .env.
php artisan key:generate

Edit .env to configure your database:

# Database connection type: mysql, pgsql, sqlite, sqlsrv
DB_CONNECTION=mysql

# MySQL / PostgreSQL settings
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=activity_tracker
DB_USERNAME=root
DB_PASSWORD=secret

# SQLite setting (used only if DB_CONNECTION=sqlite)
# Set the full path to your SQLite file, e.g., database/database.sqlite
DB_SQLITE_DATABASE=/full/path/to/database.sqlite

# Enable foreign key constraints for SQLite
DB_FOREIGN_KEYS=true

```

4.**Run Migrations & Seeders**
```bash
php artisan migrate --seed
```

5. 📘 **Serve the Application**
```bash
php artisan serve
The system will be available at http://127.0.0.1:8000.
```

📖 Usage

Dashboard – View total activities, completed vs pending activities, and team members.

Daily View – See all activity updates for the current day with timestamps and remarks.

Activity Updates – Update the status of an activity with optional remarks. Personnel bio and update time are captured automatically.

Reports – Generate activity history reports based on custom date ranges.

Pending Handover – Lists activities that are not yet completed to ensure smooth transition between team members.


🛠 Development

Controllers: Handle requests for activities, activity updates, and reports.

Models: Activity, ActivityUpdate, User with relationships (Activity hasMany ActivityUpdate).

Views: Blade templates for dashboard, daily view, activity details, and reports.

Routing: RESTful routes defined in web.php and api.php.


