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
