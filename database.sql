CREATE DATABASE IF NOT EXISTS klinik_care CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE klinik_care;
CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120) NOT NULL,
 email VARCHAR(160) NOT NULL UNIQUE, password_hash VARCHAR(255) NOT NULL,
 role ENUM('admin','dokter','pasien') NOT NULL, is_active TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE admins (id INT AUTO_INCREMENT PRIMARY KEY,user_id INT NOT NULL UNIQUE,FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE);
CREATE TABLE doctors (id INT AUTO_INCREMENT PRIMARY KEY,user_id INT NOT NULL UNIQUE,specialization VARCHAR(120),FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE);
CREATE TABLE patients (id INT AUTO_INCREMENT PRIMARY KEY,user_id INT NOT NULL UNIQUE,phone VARCHAR(30),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE);
CREATE TABLE doctor_schedules (id INT AUTO_INCREMENT PRIMARY KEY,doctor_id INT NOT NULL,day_of_week TINYINT NOT NULL,start_time TIME NOT NULL,end_time TIME NOT NULL,FOREIGN KEY(doctor_id) REFERENCES doctors(id) ON DELETE CASCADE);
CREATE TABLE appointments (id INT AUTO_INCREMENT PRIMARY KEY,patient_id INT NOT NULL,doctor_id INT NOT NULL,appointment_date DATE NOT NULL,appointment_time TIME NOT NULL,status ENUM('menunggu','disetujui','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(patient_id) REFERENCES patients(id),FOREIGN KEY(doctor_id) REFERENCES doctors(id));
CREATE TABLE medical_records (id INT AUTO_INCREMENT PRIMARY KEY,appointment_id INT NOT NULL UNIQUE,complaint TEXT,examination TEXT,diagnosis TEXT,treatment TEXT,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(appointment_id) REFERENCES appointments(id) ON DELETE CASCADE);
CREATE TABLE diagnoses (id INT AUTO_INCREMENT PRIMARY KEY,medical_record_id INT NOT NULL,diagnosis TEXT NOT NULL,FOREIGN KEY(medical_record_id) REFERENCES medical_records(id) ON DELETE CASCADE);
CREATE TABLE prescriptions (id INT AUTO_INCREMENT PRIMARY KEY,medical_record_id INT NOT NULL,notes TEXT,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(medical_record_id) REFERENCES medical_records(id) ON DELETE CASCADE);
CREATE TABLE prescription_details (id INT AUTO_INCREMENT PRIMARY KEY,prescription_id INT NOT NULL,medicine_name VARCHAR(160) NOT NULL,dosage VARCHAR(120),quantity INT,FOREIGN KEY(prescription_id) REFERENCES prescriptions(id) ON DELETE CASCADE);
-- Buat admin awal menggunakan hash password yang dihasilkan PHP password_hash().
