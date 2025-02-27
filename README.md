# Learning Management System (LMS) in PHP & MySQl

## Overview 

The Learning Management System (LMS) is a role-based educational platform built using PHP and MySQL. It provides user authentication, course management, quizzes, and progress tracking.

## Features

## 1. User Authentication
- Users can register and log in using token-based authentication.
- Roles include Admin, Instructor, and Student.
- JSON Web Token (JWT) is used for secure authentication.

## 2. Role-Based Access Control

- Admin:
    - Manage users.
    - Oversee all system activities.

- Instructor:
    - Create courses and quizzes.
    - Add questions to quizzes.
    - Track student progress.

- Student:
    - Enroll in courses.
    - View course list.
    - Take quizzes.
    - Track their own progress.

## 3. Course Management

- Instructors can create and manage courses.
- Students can enroll in courses.
- Role-based restrictions prevent students from modifying courses.

## 4. Quizzes & Questions
- Instructors can create quizzes for their courses.
- Quizzes contain multiple questions.
- Students can take quizzes and view their scores.

## 5. Progress Tracking
- Instructors can monitor student progress in their courses.
- Students can track their own quiz results and course progress.

## Technologies Used
- Backend: PHP 
- Database: MySQL
- Authentication: Firebase JWT
- Server: Apache (XAMPP)

## Installation Guide

## 1. Clone the Repository

     git clone https://github.com/your-repo/lms-php-mysql.git
     cd lms-php-mysql

## 2. Set Up Database

- Import the database.sql file into your MySQL database.
- Update database credentials in config/database.php.

## 3. Set Up Environment Variables

- Create a .env file and add:

         SECRET_KEY=your_secret_key
         DB_HOST=localhost
         DB_NAME=lms_db
         DB_USER=root
         DB_PASS=your_password

## API Endpoints

| Method | Endpoint    | Description        | Role               |
| ------ | ----------- | ------------------ | ------------------ |
| `POST` | `/register` | User registration  | All                |
| `POST` | `/login`    | User login         | All                |
| `GET`  | `/courses`  | Fetch all courses  | All                |
| `POST` | `/courses`  | Create a course    | Instructor         |
| `POST` | `/enroll`   | Enroll in a course | Student            |
| `POST` | `/quizzes`  | Create a quiz      | Instructor         |
| `GET`  | `/progress` | Fetch progress     | Student/Instructor |

## Contribution
- Fork the repository.
- Create a feature branch (git checkout -b feature-name).
- Commit changes (git commit -m "Added new feature").
- Push to the branch (git push origin feature-name).
- Open a Pull Request.

## Contact

For support or inquiries, reach out at swetarajak001@gmail.com