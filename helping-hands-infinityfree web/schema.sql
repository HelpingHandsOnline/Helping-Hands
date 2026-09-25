-- Helping Hands Community Assist
-- InfinityFree fresh-install database script
-- IMPORTANT: This script DROPS the five Helping Hands tables before recreating them.
-- Use this for the first installation or when fixing an incomplete/failed import.
-- Do NOT run it on a live site if you need to keep existing data.

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS volunteers;
DROP TABLE IF EXISTS requests;
DROP TABLE IF EXISTS newsletter_subscribers;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(80) NOT NULL,
  last_name VARCHAR(80) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  phone VARCHAR(40) NOT NULL,
  role ENUM('Requester','Volunteer','Both') NOT NULL DEFAULT 'Requester',
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS requests (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  volunteer_id INT UNSIGNED NULL,
  category VARCHAR(100) NOT NULL,
  location VARCHAR(255) NOT NULL,
  preferred_date DATE NOT NULL,
  preferred_time TIME NOT NULL,
  notes TEXT NULL,
  contact_method VARCHAR(40) NOT NULL DEFAULT 'Phone call',
  status ENUM('Pending','Accepted','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  accepted_at DATETIME NULL,
  completed_at DATETIME NULL,
  CONSTRAINT fk_request_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_request_volunteer FOREIGN KEY (volunteer_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_requests_status (status), INDEX idx_requests_user (user_id), INDEX idx_requests_volunteer (volunteer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS volunteers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL UNIQUE,
  areas VARCHAR(255) NOT NULL,
  availability VARCHAR(255) NOT NULL,
  skills TEXT NULL,
  emergency_contact_name VARCHAR(120) NOT NULL,
  emergency_contact_phone VARCHAR(40) NOT NULL,
  motivation TEXT NULL,
  status ENUM('Active','Paused') NOT NULL DEFAULT 'Active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_volunteer_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS contact_messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NULL,
  name VARCHAR(160) NOT NULL,
  email VARCHAR(190) NOT NULL,
  subject VARCHAR(160) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status ENUM('New','Read','Resolved') NOT NULL DEFAULT 'New',
  CONSTRAINT fk_message_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
