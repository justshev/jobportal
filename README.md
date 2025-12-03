# Job Portal - Laravel 11 Application

A complete, production-ready Job Portal web application built with **Laravel 11**, **Blade Templates**, and **Tailwind CSS**.

## Features

### Role-Based Access Control

-   **Job Seekers (user)**: Browse jobs, apply for positions, track applications
-   **HR/Employers (hr)**: Post job listings, manage applications, review candidates
-   **Super Admin (admin)**: Oversee all jobs, users, and handle reports

### Job Seeker Features

-   Browse and search job listings with filters (keyword, location, employment type)
-   View detailed job descriptions and requirements
-   Apply for jobs with optional cover letter
-   Track application status (submitted, in review, shortlisted, accepted, rejected)
-   Dashboard with application statistics

### HR Features

-   Post and manage job listings
-   Edit and close job postings
-   View all applicants for each job
-   Update application statuses
-   Dashboard with posting and applicant statistics

### Admin Features

-   View all users with role filtering
-   Manage all job postings (edit/remove any job)
-   Handle user reports
-   System-wide statistics dashboard

### Design

-   **Minimalist & Clean**: Professional UI with excellent UX
-   **Fully Responsive**: Mobile-first design using Tailwind CSS
-   **Consistent Design System**: Reusable components and patterns
-   **Excellent Typography**: Clear hierarchy and readability

## Tech Stack

-   **Backend**: Laravel 11 (PHP 8.2+)
-   **Frontend**: Blade Templates + Tailwind CSS
-   **Authentication**: Laravel Breeze
-   **Database**: MySQL
-   **Build Tool**: Vite

## Requirements

-   PHP 8.2 or higher
-   Composer
-   MySQL 5.7+ or MariaDB 10.3+
-   Node.js 18+ and NPM

## Installation

### 1. Clone the Repository

```bash
cd /path/to/your/projects
git clone <your-repo-url> jobportal
cd jobportal
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

```bash
cp .env.example .env
```

Edit `.env` and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobportal
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create Database

Create a MySQL database named `jobportal`:

```bash
mysql -u your_username -p
```

```sql
CREATE DATABASE jobportal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 7. Run Migrations

```bash
php artisan migrate
```

### 8. Seed Database

```bash
php artisan db:seed
```

This will create:

-   1 Admin user
-   2 HR users
-   5 Job Seekers
-   6 Sample job postings
-   Sample applications and reports

### 9. Build Frontend Assets

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

### 10. Start Development Server

```bash
php artisan serve
```

Visit: http://localhost:8000

## Default User Accounts

After seeding, you can login with:

### Admin

-   **Email**: admin@jobportal.com
-   **Password**: password

### HR Users

-   **Email**: hr1@company.com or hr2@company.com
-   **Password**: password

### Job Seekers

-   **Email**: seeker1@example.com (through seeker5@example.com)
-   **Password**: password

## Database Structure

### Tables

#### users

-   id, name, email, password
-   role: ENUM('user', 'hr', 'admin') - default: 'user'
-   timestamps

#### job_postings

-   id, title, company_name, location
-   employment_type (full-time, part-time, contract, internship, remote)
-   salary_range (nullable)
-   description, requirements
-   posted_by (foreign key to users)
-   status: ENUM('active', 'closed', 'removed') - default: 'active'
-   timestamps

#### applications

-   id
-   job_id (foreign key to job_postings)
-   user_id (foreign key to users)
-   cover_letter (nullable)
-   status: ENUM('submitted', 'in_review', 'shortlisted', 'rejected', 'accepted')
-   timestamps

#### reports

-   id
-   job_id (foreign key to job_postings)
-   user_id (foreign key to users)
-   reason (text)
-   status: ENUM('new', 'reviewed', 'resolved')
-   timestamps

## Project Structure

```
jobportal/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminDashboardController.php
│   │   │   ├── AdminJobController.php
│   │   │   ├── AdminUserController.php
│   │   │   ├── ApplicationController.php
│   │   │   ├── ApplicantController.php
│   │   │   ├── HRDashboardController.php
│   │   │   ├── JobBrowseController.php
│   │   │   ├── JobPostController.php
│   │   │   ├── ReportController.php
│   │   │   └── UserDashboardController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── Application.php
│       ├── JobPosting.php
│       ├── Report.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2025_12_02_*_create_job_postings_table.php
│   │   ├── 2025_12_02_*_create_applications_table.php
│   │   └── 2025_12_02_*_create_reports_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── jobs/
│   │   │   ├── users/
│   │   │   └── reports/
│   │   ├── hr/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── jobs/
│   │   │   └── applicants/
│   │   ├── user/
│   │   │   ├── dashboard.blade.php
│   │   │   └── applications/
│   │   ├── jobs/
│   │   │   ├── index.blade.php
│   │   │   └── show.blade.php
│   │   ├── layouts/
│   │   │   └── main.blade.php
│   │   └── welcome.blade.php
│   └── css/
│       └── app.css (Tailwind)
└── routes/
    └── web.php
```

## Routes

### Public Routes

-   `GET /` - Landing page
-   `GET /jobs` - Browse all jobs
-   `GET /jobs/{id}` - Job details

### Job Seeker Routes (role: user)

-   `GET /dashboard` - User dashboard
-   `GET /user/applications` - My applications
-   `POST /user/applications` - Apply for a job

### HR Routes (role: hr)

-   `GET /hr/dashboard` - HR dashboard
-   Resource: `/hr/jobs` - CRUD for job postings
-   `GET /hr/jobs/{jobId}/applicants` - View applicants
-   `PATCH /hr/applications/{id}/status` - Update application status

### Admin Routes (role: admin)

-   `GET /admin/dashboard` - Admin dashboard
-   `GET /admin/jobs` - All job postings
-   `GET /admin/users` - All users
-   `GET /admin/reports` - All reports
-   `PATCH /admin/reports/{id}` - Update report status

## Development

### Running Tests

```bash
php artisan test
```

### Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Database Reset

```bash
php artisan migrate:fresh --seed
```

## Deployment

### Production Build

```bash
npm run build
```

### Environment Variables

Set the following in production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### Optimize for Production

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## License

This project is open-source and available under the MIT License.

## Support

For issues or questions, please create an issue in the repository.

---

**Built with ❤️ using Laravel 11 and Tailwind CSS**
