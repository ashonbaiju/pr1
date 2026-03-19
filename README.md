# Massive Tuition Platform

This is a comprehensive, massive web application specifically designed for managing a tuition platform with distinct portals for **Admins**, **Teachers**, and **Students**.

It is built from the ground up using a Custom PHP MVC Architecture to handle any amount of traffic securely. The frontend is fully responsive for mobile devices and desktops, featuring a premium glassmorphic dark mode UI.

## Features Currently Implemented
- **MySQL Database Schema:** Complete structure supporting Users, Batches, Subjects, Attendance, Fees, Marks, and Announcements.
- **Custom PHP Routing Engine:** Lightweight MVC setup mapping URLs to Controllers.
- **Secure Authentication:** `AuthController` handles secure login and redirects users to their specific roles.
- **Premium Frontend:** Modern CSS providing a "wow" factor with Sidebar layouts, stats cards, and action buttons.
- **Admin Dashboard:** Overview of system stats, recent enrollments, and actionable alerts.
- **Teacher Dashboard:** Quick actions for marking attendance, entering marks, and uploading study material.
- **Student Dashboard:** View grades, pending homework, fee statuses, and upcoming live classes. 

## How to Run Locally

1. **Database Setup**
   - Open your MySQL Database managing tool (like phpMyAdmin or MySQL Workbench).
   - Create a database called `tuition_db`.
   - Run the SQL script found at `database.sql` to generate all tables and the default Admin user.
   - *Username:* `admin@tuition.com`
   - *Password:* `password`

2. **Configure Database Connection**
   - If your database needs a password, update the `config/database.php` default credentials to match yours.

3. **Start the PHP Local Server**
   - Open your terminal and change the directory to this project folder.
   - Run the following command:
     ```bash
     php -S localhost:8000 -t public
     ```

4. **Access the Application**
   - Head over to `http://localhost:8000` in your web browser. You'll be greeted by the premium Login Page.

## Next Steps
We can integrate the **Live Class** API (e.g., Jitsi/Zoom integration) and the **AI Chat Bot** once you confirm you are happy with the architecture and the UI!
