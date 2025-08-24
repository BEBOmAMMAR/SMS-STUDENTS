
CREATE DATABASE IF NOT EXISTS sms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sms;

-- جدول الطلاب
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول المعلمين
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    subject_speciality VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول المواد
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    teacher_id INT,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
);

-- جدول الامتحانات
CREATE TABLE exams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT NOT NULL,
    exam_date DATE,
    total_marks INT,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- جدول نتائج الامتحانات
CREATE TABLE exam_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    exam_id INT NOT NULL,
    marks_obtained INT,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE
);

-- جدول المدفوعات
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    amount DECIMAL(10,2),
    payment_date DATE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- جدول المصروفات
CREATE TABLE expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    amount DECIMAL(10,2),
    expense_date DATE
);

-- بيانات تجريبية
INSERT INTO students (name, phone, email) VALUES
('أحمد علي', '01011111111', 'ahmed@example.com'),
('سارة محمد', '01022222222', 'sara@example.com'),
('محمود حسن', '01033333333', 'mahmoud@example.com');

INSERT INTO teachers (name, phone, email, subject_speciality) VALUES
('د. خالد', '01044444444', 'khaled@example.com', 'رياضيات'),
('أ. منى', '01055555555', 'mona@example.com', 'لغة عربية');

INSERT INTO subjects (name, description, teacher_id) VALUES
('رياضيات', 'مقرر الرياضيات للصف الثالث الثانوي', 1),
('لغة عربية', 'النحو والأدب', 2);

INSERT INTO exams (subject_id, exam_date, total_marks) VALUES
(1, '2025-01-15', 100),
(2, '2025-01-20', 100);

INSERT INTO exam_results (student_id, exam_id, marks_obtained) VALUES
(1, 1, 85),
(2, 1, 90),
(3, 2, 75);

INSERT INTO payments (student_id, amount, payment_date) VALUES
(1, 500, '2025-01-01'),
(2, 500, '2025-01-01');

INSERT INTO expenses (description, amount, expense_date) VALUES
('إيجار القاعة', 2000, '2025-01-02'),
('طباعة أوراق', 500, '2025-01-03');
