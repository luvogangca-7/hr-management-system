
# 🌐 MODERNTECH HR SYSTEM

A secure, scalable Human Resource Management System built by Group 10 under ModernTech Solutions — *"Where Innovation Meets Patient Care."*  
This project is designed to manage employee data, attendance, leave, payroll, and role-based access using modern web technologies.

---

## 👥 Team Members

- **Project Manager:** Farah Moses  
- **Software Developer:** Luvo Gangca  
- **UI Designer:** Likhona Benayo  

---

## 🛠️ Technologies Used

- **PHP 8.1** — backend API and logic  
- **MySQL** — relational database  
- **Axios** — for sending HTTP requests from frontend to backend  
- **Bootstrap 5** — for responsive and modern UI  
- **HTML & CSS** — structure and styling  
- **jsPDF** — for generating downloadable PDF reports  
- **jsPDF-AutoTable** — for creating tables inside PDFs  

---

## 🎯 Features

1. Secure login with role-based access (HR Admin, Employee)  
2. Leave request system  
3. Attendance tracking  
4. Automated payroll calculations with tax  
5. Generate PDF reports (payroll)  
6. Password reset and recovery system  
7. Scalable user dashboard for both desktop and mobile  
8. Data security compliant with POPIA and other regulations  
9. Responsive and user-friendly interface  
10. Perfomance review, where the employee can see their reviews and the manager's comment

---

## 🚀 Phase Highlights

### ✅ Phase 1 Achievements

- User-friendly and responsive UI  
- Mobile and desktop compatibility  
- Leave request interface completed  
- Payroll logic and calculations simulated  

### 🎯 Phase 2 Goals

- Build secure backend infrastructure with PHP & SQL  
- Fully connect frontend and backend via Axios  
- Support for multiple HR roles with dynamic access  
- Prepare for international scalability  

---

## 🔐 Role-Based Access

| Role     | Access Level                      |
|----------|-----------------------------------|
|HR Admin    | Full access (employees, payrolls) |
| Employee | View profile, payroll, submit leave |

---

## 🧰 Installation & Setup

### 📦 Prerequisites

- PHP 8.1 or higher  
- MySQL (via XAMPP)  
- Browser (Chrome, Edge, etc.)  

---

### 🧪 Steps to Run Locally

#### 1. Backend Setup

- Place the project folder into:  
  `C:\xampp\htdocs\`  

- Start **Apache** and **MySQL** using XAMPP  

- Open phpMyAdmin and import the file:  
  `hr_project.sql`  

- Update database connection settings in `hr_database.php`:

```php
<?php
$dbServerName = 'localhost';
$dbUsername = 'root';
$dbPassword = ''; // your MySQL root password
$dbName = 'hr_project';
$conn = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName);
?>
```

#### 2. Frontend Setup

```bash
cd hr-frontend
npm install
npm run serve
```

Make sure your development server is running at:  
**Frontend URL:** `http://localhost:8080`

#### 3. Start Backend Server

- Open XAMPP
- Start **Apache** and **MySQL**
- Visit: `http://localhost/hr-management-system`
  

---

## 🔑 Login Credentials

### ✅ Admin Login

- **Username:** `admin`  
- **Password:** `1234`  

### ✅ Employee (Staff) Login

- **Username Format:** First initial of first name + surname  
  - Example: `Sibongile Nkosi` → `snkosi`  
- **Password Format:** `hr-emp-[employee_id]`  
  - Example: Employee with ID `1` → `hr-emp-1`  

> All passwords are securely hashed using PHP’s `password_hash()` function.

---

## 📐 Architecture Highlights

- Pure PHP backend connected to a MySQL database  
- Axios is used to send requests from frontend to backend    
- PDF generation with jsPDF and AutoTable for payroll and attendance reports  
- Clean and modular file structure for maintainability  


---

