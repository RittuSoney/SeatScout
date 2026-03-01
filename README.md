# 🪑 SeatScout: Automated Exam Seating System

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![Vanilla JS](https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E)

## 📌 The Problem
During university examinations, distributing seating arrangements via unstructured PDFs or physical notice boards creates massive bottlenecks. Students scramble to find their halls, and administrators waste hours manually mapping roll numbers to specific seats.

## 💡 The Solution
**SeatScout** is a lightweight, zero-friction web application designed to automate the exam seating process. It allows administrators to bulk-upload sanitized seating data via CSV and provides students with an instant, real-time search portal to locate their exact Exam Hall, Block, and Seat Number using only their Register Number.

---

## 🚀 Key Features

* **Instant Student Lookup:** A frictionless, no-login search interface utilizing AJAX/Fetch API for real-time querying.
* **Bulk CSV Ingestion:** An admin dashboard equipped with `fgetcsv()` parsing to ingest hundreds of seating allocations in milliseconds.
* **Emergency Manual Override:** A dedicated control panel for administrators to handle last-minute "walk-in" students or data corrections on the fly.
* **Privacy-First Design:** Stripped of PII (Personally Identifiable Information like Names); relies strictly on Register Numbers to comply with student data protection norms.
* **Responsive Vanilla UI:** Built completely with semantic HTML and custom CSS—zero heavy frameworks or dependencies.

---

## 📸 Screenshots

*(Replace these placeholder links with actual screenshots of your project once you upload it!)*

| Student Search Interface | Admin Control Panel |
| :---: | :---: |
| ![Student UI](put_link_to_student_image_here.jpg) | ![Admin UI](put_link_to_admin_image_here.jpg) |

---

## ⚙️ System Architecture & Database Schema

The system utilizes a Client-Server architecture running on an Apache/MySQL stack (XAMPP). 

**Table:** `seats`
| Column Name | Data Type    | Constraints | Description |
| :---        | :---         | :---        | :---        |
| `id`        | INT          | PK, AI      | Unique Row ID |
| `reg_no`    | VARCHAR(50)  | UNIQUE, NN  | Student Register Number |
| `hall_no`   | VARCHAR(50)  | NN          | Exam Hall (e.g., Room 304) |
| `block_no`  | VARCHAR(20)  | NN          | Hall Block (e.g., Block A) |
| `seat_no`   | INT          | NN          | Exact Seat Number |

*(Note: Prepared Statements are utilized across all SQL queries to mitigate SQL Injection vulnerabilities.)*

---

## 💻 Local Installation Guide

Want to run this locally? Follow these steps:

1. **Prerequisites:** Install [XAMPP](https://www.apachefriends.org/index.html) (or any LAMP/WAMP stack).
2. **Clone the Repo:**
   ```bash
   git clone [https://github.com/YOUR_USERNAME/SeatScout.git](https://github.com/YOUR_USERNAME/SeatScout.git)