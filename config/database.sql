-- ============================================================
--  Pet Clinic — Database Setup Script
-- ============================================================

-- Create the database if it does not already exist
CREATE DATABASE IF NOT EXISTS `pet_clinic`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `pet_clinic`;

-- ============================================================
--  Table: users
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
    `id`         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(80)     NOT NULL,
    `last_name`  VARCHAR(80)     NOT NULL,
    `email`      VARCHAR(180)    NOT NULL,
    `phone`      VARCHAR(20)     NULL DEFAULT NULL,
    `password`   VARCHAR(255)    NOT NULL COMMENT 'bcrypt hash',
    `role`       ENUM('admin','vet','nurse','owner') NOT NULL DEFAULT 'owner',
    `status`     ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    `created_at` DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP
                                 ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- Seed Data
INSERT IGNORE INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `role`, `status`) VALUES
(1, 'System', 'Admin', 'admin@petclinic.com', '1112223333', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'approved'),
(2, 'Sarah', 'Vet', 'dr.sarah@petclinic.com', '2223334444', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vet', 'approved'),
(3, 'John', 'Nurse', 'john.nurse@petclinic.com', '3334445555', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nurse', 'approved'),
(4, 'Jane', 'Owner', 'jane.owner@example.com', '4445556666', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', 'approved');

-- ============================================================
--  Table: pets
-- ============================================================
CREATE TABLE IF NOT EXISTS `pets` (
    `id`         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `owner_id`   INT UNSIGNED    NOT NULL,
    `name`       VARCHAR(100)    NOT NULL,
    `type`       VARCHAR(50)     NOT NULL COMMENT 'e.g., Dog, Cat, Bird',
    `breed`      VARCHAR(100)    NOT NULL,
    `age`        INT UNSIGNED    NOT NULL,
    `photo`      VARCHAR(255)    NULL,
    `created_at` DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP
                                 ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_pets_owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- ============================================================
--  Table: medical_records
-- ============================================================
CREATE TABLE IF NOT EXISTS `medical_records` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `pet_id`         INT UNSIGNED NOT NULL,
    `vet_id`         INT UNSIGNED NOT NULL,
    `treatment_date` DATE         NOT NULL,
    `diagnosis`      VARCHAR(255) NOT NULL,
    `treatment`      TEXT         NOT NULL,
    `medicines`      TEXT         NULL,
    `notes`          TEXT         NULL,
    `created_at`     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_mr_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_mr_vet` FOREIGN KEY (`vet_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- ============================================================
--  Table: appointments
-- ============================================================
CREATE TABLE IF NOT EXISTS `appointments` (
    `id`               INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `pet_id`           INT UNSIGNED NOT NULL,
    `owner_id`         INT UNSIGNED NOT NULL,
    `appointment_date` DATETIME     NOT NULL,
    `reason`           TEXT         NOT NULL,
    `status`           ENUM('pending','approved','completed','cancelled') DEFAULT 'pending',
    `created_at`       DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_appt_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_appt_owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
