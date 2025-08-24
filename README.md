# 🎓 Webinar & Course Registration System

A simple yet powerful **PHP-based web application** for managing webinars and courses.  
It provides a **registration form for participants** and a **secure admin dashboard** to manage events.  
Built with **pure PHP**, **MySQL**, and **Bootstrap 5**, this project is lightweight, responsive, and production-ready.

---

## ✨ Features

### 👨‍💻 User Side
- View available **active webinars/courses**.
- Register easily with:
  - Full name
  - Email
  - Phone (optional)
- Real-time validation and success/error messages.
- Mobile-friendly **responsive design** with Bootstrap.

### 🔑 Admin Side
- **Secure Login** system using `password_hash` & `password_verify`.
- **CRUD Management** for:
  - Webinars
  - Courses
- Toggle **active/inactive** status for each event.
- View and search **registrations** by email or webinar/course.
- Session-secured admin dashboard.

### ⚡ Security
- **CSRF protection** for all forms.
- **Session hardening** with secure cookie params.
- **Rate limiting** on registration (per IP & session).
- Clean separation between **public** and **src** code.

---

## 📂 Project Structure

registration-form/
│
├── public/ # Publicly accessible files (index.php, register.php, assets)
│ ├── index.php # User-facing: list webinars/courses + registration form
│ ├── register.php # Handles registration requests
│ └── admin/ # Admin panel (login, dashboard, CRUD pages)
│
├── src/
│ ├── config/ # bootstrap.php, database config
│ ├── models/ # Webinar.php, Course.php, Registration.php
│ ├── security/ # CSRF + RateLimiter
│ └── utils/ # Helpers
│
├── vendor/ # Composer dependencies
├── .env # Environment variables (DB credentials)
└── README.md # Project documentation



---

## 🚀 Getting Started

### 1. Clone Repository
```bash
git clone https://github.com/your-username/webinar-registration.git 
cd webinar-registration 
```
2️⃣ Setup Database

Import the database.sql file into MySQL.

Update .env with your DB credential
```bash
DB_HOST=127.0.0.1
DB_NAME=registration_db
DB_USER=root
DB_PASS=
BASE_URL=http://localhost/registration-form/public
```
3️⃣ Install Dependencies
```bash
composer install
```
4️⃣ Run Locally
If using XAMPP/WAMP, place the project inside htdocs and visit:
```bash
http://localhost/registration-form/public
```
🔒 Security Highlights

CSRF protection for all forms

Password hashing with password_hash() & password_verify()

Session hardening (httponly, secure, samesite=strict)

Rate limiting on registration requests

🚀 Future Improvements

📧 Email notifications after registration

📊 Export participants as CSV/Excel

🌐 Multi-language support

🔔 Real-time updates with WebSockets
