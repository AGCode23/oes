# Online Examination System

## About

The **Online Examination System** is a web-based platform designed for Senior High School students and teachers. This system allows for the creation, management, and taking of exams through a modern online interface. It bridges the gap between traditional examination methods and the evolving technological landscape. The system supports various features for both students and teachers to enhance the learning and assessment experience.

The project is built using **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**, offering a seamless user experience while ensuring security, scalability, and ease of use.

---

## Features

### For Students:

- **User Registration & Login**: Students can register and log in to access their exams.
- **View Available Exams**: Students can view the list of available exams.
- **Take Exams Online**: Students can take exams online with a timer and various question types (e.g., multiple-choice, true/false).
- **Exam Results**: View results in real-time after completing exams.
- **Progress Tracking**: Track completed exams, scores, and performance over time.

### For Teachers:

- **Teacher Dashboard**: Manage profiles and access a dashboard for exam-related tasks.
- **Create Exams**: Create new exams with multiple question types (e.g., multiple-choice, true/false, short/long answers).
- **Exam Scheduling**: Schedule exams for students.
- **View Results**: Access student exam results and performance analytics.
- **Question Bank**: Store and reuse questions for future exams.

### Admin Features:

- **Admin Dashboard**: Manage users (students and teachers) and exams.
- **User Management**: Enable, disable, or delete users.
- **Data Security**: Securely manage user and exam data using MySQL.

---

## Installation

To install and run this project locally, follow these steps:

1. **Clone the repository:**

   ```bash
   git clone https://github.com/your-username/online-examination-system.git
   ```

2. **Install dependencies:**

   - Ensure you have **PHP** and **MySQL** installed on your machine.
   - Use tools like **XAMPP** or **WAMP** to set up a local server.

3. **Create a database in MySQL:**

   - Import the database schema provided in the project (if available).

4. **Configure the Database:**

   - Rename the `.env.example` file to `.env`.
   - Update the `.env` file with your database credentials:
     ```
     DB_HOST=your-database-host
     DB_USER=your-database-username
     DB_PASS=your-database-password
     DB_DATABASE=your-database-name
     ```

5. **Start the server:**
   - Use your local server (e.g., XAMPP/WAMP) to serve the project files.
   - Access the application in your browser at `http://localhost`.

---

## Usage

### For Students:

1. Register or log in to access the dashboard.
2. View available exams and take them online.
3. Check your results and track your progress.

### For Teachers:

1. Log in to access the teacher dashboard.
2. Create and schedule exams for students.
3. View student results and manage questions.

### For Admins:

1. Log in to the admin panel.
2. Manage users and exams.
3. Monitor system activity and ensure data security.

---

## Technologies Used

- **Backend**: PHP, MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Frameworks/Libraries**: Chart.js (for analytics), Fetch API (for AJAX requests)
- **Environment Management**: dotenv
- **Server**: Apache (via XAMPP/WAMP)

---

## Contributing

Contributions are welcome! If you'd like to contribute:

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Submit a pull request with a detailed description of your changes.

---

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

---

## Contact

For any inquiries or support, please contact [agcodinghub@gmail.com].
