# EDMOL – Matadi Baptist High School Management System Monrovia, Liberia 

## Project Overview

The **EDMOL School Management System** is a private, custom-built web application designed to support the academic and administrative operations of **EDMOL – Matadi Baptist High School Monrovia, Liberia**.

The platform provides a centralized digital system for managing students, academic records, grading, and administrative activities within the school. It is designed to improve efficiency, accuracy, and organization in school data management.

⚠️ **Note:** This project is a **private internal system** developed specifically for EDMOL – Matadi Baptist High School and is not intended for public distribution.

---

## Student Management Admin Interface

The system includes a fully interactive **Student Management Dashboard** that allows administrators to manage and monitor student records efficiently.

### Dynamic Status Tabs

Students are categorized by the following statuses:

* Candidate
* Admitted
* Registered
* Active
* Dropout
* Completed

Each status tab is:

* **Interactive:** Updates the student table dynamically without reloading the page.
* **Responsive:** Works seamlessly across desktop and mobile devices.
* **Enhanced with icons:** Each status includes visual icons for quick identification.
* **Student count badges:** Displays the total number of students per category.

---

### Search and Filter Functionality

Administrators can quickly filter student records using reactive filters.

Available filters include:

* Student name or Student ID
* Intake
* Shift

Filtering works instantly using **Livewire reactive components**, allowing the table to update automatically whenever a filter or status tab is selected.

---

### Excel Export Functionality

The system allows administrators to export student data into Excel format for reporting or offline analysis.

Features include:

* Export filtered student lists
* Export based on status, search results, intake, or shift
* Flexible export structure allowing additional columns or formatting

Export implementation is handled by:

```
app/Exports/StudentsExport.php
```

The system uses **Laravel Excel (Maatwebsite package)** for generating downloadable Excel files.

---

## Academic Grading System

The platform includes a structured grading module used for recording and calculating student academic performance.

Features include:

* Teacher grade entry interface
* Semester-based academic assessments
* Automatic subject average calculations
* Automatic overall academic average calculation
* Student ranking based on performance

### Overall Academic Average Calculation

The overall yearly academic average is calculated using the following formula:

Overall Average =
(Sum of all semester averages across all subjects) ÷ (Number of subjects × 2 semesters)

Example:

| Subject | Semester 1 | Semester 2 |
| ------- | ---------- | ---------- |
| Math    | 78         | 82         |
| English | 75         | 80         |
| Biology | 70         | 74         |

Overall Average = **76.5**

---

### Student Ranking Logic

Student ranking is determined by comparing the overall academic averages of students within the same grade level.

Steps involved:

1. Calculate each subject's semester averages.
2. Calculate the yearly subject average.
3. Compute the student's overall academic average.
4. Sort students from highest to lowest average to determine class ranking.

Example:

| Student   | Average | Rank |
| --------- | ------- | ---- |
| Student A | 88      | 1st  |
| Student B | 84      | 2nd  |
| Student C | 79      | 3rd  |

---

## Role and Permission Management

The system implements **role-based access control** using the **Spatie Laravel Permission package**.

This allows administrators to manage user permissions based on their responsibilities within the school.

Capabilities include:

* Creating multiple administrator accounts
* Assigning specific permissions to each administrator
* Restricting system modules based on roles
* Tailoring system access to match daily administrative tasks

This permission system ensures that each user only has access to the features required for their role.

Example roles include:

* Administrator
* Teacher
* Student

Permissions can be assigned dynamically to control access to different system modules such as:

* Student management
* Grade entry
* Report generation
* System administration

---

## Livewire Reactive Interface

The system uses **Livewire** to create a reactive user interface without requiring heavy JavaScript frameworks.

Benefits include:

* Real-time updates to tables and dashboards
* Instant search and filtering
* Reduced page reloads
* Simplified frontend and backend integration
* Cleaner and more maintainable codebase

Livewire components handle most of the dynamic interactions within the admin dashboard.

---

## Technologies Used

| Technology                  | Description                    |
| --------------------------- | ------------------------------ |
| Laravel 12.21               | Backend application framework  |
| Livewire 4.1                | Reactive frontend components   |
| Tailwind CSS                | User interface styling         |
| Spatie Laravel Permission   | Role and permission management |
| Laravel Excel (Maatwebsite) | Excel export functionality     |
| PHP 8.3                     | Server-side programming        |
| MySQL                       | Database management            |
| Laragon                     | Local development environment  |

---

## System Architecture

The system follows a modern Laravel architecture including:

* MVC (Model–View–Controller) design pattern
* Livewire component-based UI interactions
* Role-based access control
* Structured relational database schema for academic data

---

## Future Enhancements

Planned improvements include:

* WhatsApp parent notification system using Twilio
* Student dashboard portal
* Teacher academic dashboard
* Printable report card generation
* Online payment integration

---

## Developer

**Potiphar Vaye**
Software Developer & System Designer

This system was designed and developed as a **custom digital solution** to support the academic and administrative operations of **EDMOL – Matadi Baptist High School**.

---

## License

This software is a **private proprietary system** developed exclusively for **EDMOL – Matadi Baptist High School Monrovia, Liberia**.

Unauthorized copying, modification, distribution, or use of this software without permission from the developer or the institution is strictly prohibited.
