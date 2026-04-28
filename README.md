# School Management ERP - Final Implementation

This project is a professional, production-grade School Management ERP built with **Laravel 12**, **MySQL**, and **Tailwind CSS**.

## 🚀 Getting Started

1.  **Install Dependencies**:
    ```bash
    composer install
    npm install
    ```

2.  **Database Setup**:
    Configure your `.env` file and run:
    ```bash
    php artisan migrate --seed
    ```
    *Default Super Admin:* `admin@Gorkhabyte Academy.com` / `password`

3.  **Run Application**:
    ```bash
    php artisan serve
    # And in another terminal:
    npm run dev
    ```

4.  **Storage**:
    ```bash
    php artisan storage:link
    ```

---

## 🛠️ Key Modules
- **Super Admin**: User management & Subscription control.
- **Academic**: Student/Teacher profiles, Attendance, Routines, Exams.
- **Finance**: Fee Invoicing, Teacher Salaries, School Accounting.
- **Documents**: Notice Board & Automated Certificate Generation.

---

## 🔒 Features
- **RBAC**: Role-based access control.
- **Subscription**: Built-in account validity management.
- **UI**: Modern Tailwind CSS design with glassmorphism.
- **Print Support**: Ready for PDF/Print for invoices and certificates.

---

## 🌟 Professional Role Features

### 🏛️ Management & Administration
- **Advanced User Management**: Enterprise-grade RBAC for Super Admins, School Admins, Teachers, Students, and Parents.
- **Financial Intelligence**:
    - **Fee Management**: Automated invoicing, payment tracking, and professional receipt generation.
    - **Payroll System**: Streamlined teacher salary management with status tracking (Paid, Pending, Due).
- **Academic Governance**: Centralized control over classes, sections, subjects, and examination schedules.
- **Dynamic Attendance**: Real-time attendance monitoring and comprehensive reporting for students and staff.
- **Digital Communication**: Professional notice board for school-wide announcements with priority tagging.
- **Subscription & Licensing**: Built-in system for managing school account validity and access expiry.

### 👨‍🏫 Teacher Professional Suite
- **Classroom Orchestration**: Detailed overview of assigned classes, subjects, and student groups.
- **Personalized Scheduling**: Interactive daily routines and class timings for efficient time management.
- **Financial Transparency**: Dedicated salary dashboard to track payment history and upcoming disbursement dates.
- **Mark & Result Management**: Seamless entry and management of student exam scores and performance.
- **Real-time Notifications**: Immediate access to institutional notices and academic updates.
- **Student Engagement**: Automated tools for recording and tracking class-specific attendance.

