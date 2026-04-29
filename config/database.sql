-- ============================================================
--  Pet Clinic — Database Setup Script
--  Run this file in phpMyAdmin or the MySQL CLI:
--      mysql -u root -p < config/database.sql
-- ============================================================

-- Create the database if it does not already exist
CREATE DATABASE IF NOT EXISTS `pet_clinic`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `pet_clinic`;

-- ============================================================
--  Table: users
--  Stores registered client (pet-owner) accounts.
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
    `id`         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(80)     NOT NULL,
    `last_name`  VARCHAR(80)     NOT NULL,
    `email`      VARCHAR(180)    NOT NULL,
    `phone`      VARCHAR(20)     NULL DEFAULT NULL,
    `password`   VARCHAR(255)    NOT NULL COMMENT 'bcrypt hash',
    `role`       ENUM('client','admin','vet') NOT NULL DEFAULT 'client',
    `created_at` DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP
                                 ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE  KEY `uq_users_email` (`email`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Registered user accounts (clients, vets, admins)';
