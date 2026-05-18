-- PetSync — Database Schema
-- Optimized for reliability, integrity, and scalability.
-- Last Updated: 2026-05-12

CREATE DATABASE IF NOT EXISTS `pet_clinic`;
USE `pet_clinic`;

SET FOREIGN_KEY_CHECKS=0;

-- 1. USERS
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(80) NOT NULL DEFAULT '',
  `last_name` varchar(80) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','vet','nurse','owner') NOT NULL DEFAULT 'owner',
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Demo Users (Password: password)
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `role`, `status`) VALUES 
(1, 'System', 'Admin', 'admin@test.com', '555-0100', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'approved'),
(2, 'John', 'Vet', 'vet@test.com', '555-0200', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vet', 'approved'),
(3, 'Sarah', 'Nurse', 'nurse@pet.com', '555-0300', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nurse', 'approved'),
(4, 'Mark', 'Owner', 'owner@pet.com', '555-0400', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', 'approved');

-- 2. PETS
DROP TABLE IF EXISTS `pets`;
CREATE TABLE `pets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL COMMENT 'e.g., Dog, Cat, Bird',
  `breed` varchar(100) NOT NULL,
  `age` int(10) unsigned NOT NULL,
  `dob` date DEFAULT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `owner_phone` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pets_owner` (`owner_id`),
  CONSTRAINT `fk_pets_owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. APPOINTMENTS
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pet_id` int(11) DEFAULT NULL,
  `pet_name` varchar(100) DEFAULT NULL,
  `owner_id` int(11) NOT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `appointment_date` datetime NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','confirmed','checked-in','ready','in-consultation','completed','cancelled','approved') DEFAULT 'pending',
  `appointment_type` enum('general','vaccination') DEFAULT 'general',
  `weight` varchar(20) DEFAULT NULL,
  `temperature` varchar(20) DEFAULT NULL,
  `vitals_notes` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `checked_in_at` datetime DEFAULT NULL,
  `ready_at` datetime DEFAULT NULL,
  `consultation_started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_appt_pet` (`pet_id`),
  KEY `fk_appt_owner` (`owner_id`),
  KEY `fk_appt_nurse` (`nurse_id`),
  CONSTRAINT `fk_appt_owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appt_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_appt_nurse` FOREIGN KEY (`nurse_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. NURSE NOTES
DROP TABLE IF EXISTS `nurse_notes`;
CREATE TABLE `nurse_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointment_id` int(11) NOT NULL,
  `weight` varchar(20) DEFAULT NULL,
  `temperature` varchar(20) DEFAULT NULL,
  `symptoms` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_nn_appt` (`appointment_id`),
  KEY `fk_nn_creator` (`created_by`),
  CONSTRAINT `fk_nn_appt` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_nn_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. MEDICAL RECORDS
DROP TABLE IF EXISTS `medical_records`;
CREATE TABLE `medical_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pet_id` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `treatment_date` date NOT NULL,
  `diagnosis` varchar(255) NOT NULL,
  `treatment` text NOT NULL,
  `medicines` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_mr_pet` (`pet_id`),
  KEY `fk_mr_vet` (`vet_id`),
  CONSTRAINT `fk_mr_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_mr_vet` FOREIGN KEY (`vet_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. VACCINE TEMPLATES
DROP TABLE IF EXISTS `vaccine_templates`;
CREATE TABLE `vaccine_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pet_type` varchar(50) NOT NULL,
  `vaccine_name` varchar(100) NOT NULL,
  `recommended_age_weeks` int(11) NOT NULL,
  `booster_interval_months` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Templates
INSERT INTO `vaccine_templates` (`id`, `pet_type`, `vaccine_name`, `recommended_age_weeks`, `booster_interval_months`, `description`) VALUES 
(1, 'dog', 'Rabies', 12, 12, 'Protects against Rabies virus.'),
(2, 'dog', 'DHPPi / 5-in-1', 6, 12, 'Distemper, Hepatitis, Parvovirus, Parainfluenza.'),
(3, 'dog', 'Parvo Booster', 9, 0, 'Follow-up parvovirus booster.'),
(4, 'dog', 'Distemper Booster', 9, 0, 'Follow-up distemper booster.'),
(5, 'cat', 'Rabies', 12, 12, 'Protects against Rabies virus.'),
(6, 'cat', 'FVRCP', 8, 12, 'Feline Viral Rhinotracheitis, Calicivirus, Panleukopenia.'),
(7, 'cat', 'Feline Leukemia', 12, 12, 'Protects against FeLV.');

-- 7. VACCINATION SCHEDULE
DROP TABLE IF EXISTS `vaccination_schedule`;
CREATE TABLE `vaccination_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pet_id` int(11) NOT NULL,
  `vaccine_template_id` int(11) DEFAULT NULL,
  `vaccine_name` varchar(100) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('Upcoming','Completed','Overdue') DEFAULT 'Upcoming',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_vs_pet` (`pet_id`),
  KEY `fk_vs_template` (`vaccine_template_id`),
  CONSTRAINT `fk_vs_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_vs_template` FOREIGN KEY (`vaccine_template_id`) REFERENCES `vaccine_templates` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. VACCINATIONS
DROP TABLE IF EXISTS `vaccinations`;
CREATE TABLE `vaccinations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointment_id` int(11) DEFAULT NULL,
  `pet_id` int(11) NOT NULL,
  `vaccine_name` varchar(100) NOT NULL,
  `date_given` date NOT NULL,
  `next_due_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `batch_number` varchar(50) DEFAULT NULL,
  `vet_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_v_pet` (`pet_id`),
  KEY `fk_v_appt` (`appointment_id`),
  KEY `fk_v_vet` (`vet_id`),
  CONSTRAINT `fk_v_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_v_appt` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_v_vet` FOREIGN KEY (`vet_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. PET VACCINATION HISTORY (Imported)
DROP TABLE IF EXISTS `pet_vaccination_history`;
CREATE TABLE `pet_vaccination_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pet_id` int(11) NOT NULL,
  `vaccine_name` varchar(100) NOT NULL,
  `date_given` date NOT NULL,
  `next_due_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `uploaded_document` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pvh_pet` (`pet_id`),
  CONSTRAINT `fk_pvh_pet` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. STATUS LOGS
DROP TABLE IF EXISTS `status_logs`;
CREATE TABLE `status_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appointment_id` int(11) NOT NULL,
  `old_status` varchar(50) DEFAULT NULL,
  `new_status` varchar(50) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_sl_appt` (`appointment_id`),
  KEY `fk_sl_user` (`updated_by`),
  CONSTRAINT `fk_sl_appt` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sl_user` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
