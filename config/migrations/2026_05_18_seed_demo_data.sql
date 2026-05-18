-- Seed demo data for Pet Clinic Management System.
-- Adds at least 5 rows for every application table.
-- Safe to re-run: fixed high IDs plus INSERT IGNORE avoid duplicate-key failures.

CREATE DATABASE IF NOT EXISTS `pet_clinic`;
USE `pet_clinic`;

START TRANSACTION;

-- Users: password for all seeded accounts is "password".
INSERT IGNORE INTO `users`
  (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `role`, `status`, `created_at`, `updated_at`)
VALUES
  (9001, 'Ariana', 'Cole', 'seed.owner1@petclinic.test', '0771009001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', 'approved', '2026-05-01 08:00:00', '2026-05-01 08:00:00'),
  (9002, 'Ben', 'Walker', 'seed.owner2@petclinic.test', '0771009002', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', 'approved', '2026-05-01 08:05:00', '2026-05-01 08:05:00'),
  (9003, 'Maya', 'Perera', 'seed.owner3@petclinic.test', '0771009003', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', 'approved', '2026-05-01 08:10:00', '2026-05-01 08:10:00'),
  (9004, 'Noah', 'Silva', 'seed.vet1@petclinic.test', '0771009004', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vet', 'approved', '2026-05-01 08:15:00', '2026-05-01 08:15:00'),
  (9005, 'Leah', 'Fernando', 'seed.nurse1@petclinic.test', '0771009005', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nurse', 'approved', '2026-05-01 08:20:00', '2026-05-01 08:20:00');

-- Pets.
INSERT IGNORE INTO `pets`
  (`id`, `owner_id`, `name`, `type`, `breed`, `age`, `dob`, `owner_name`, `owner_phone`, `photo`, `created_at`, `updated_at`)
VALUES
  (9001, 9001, 'Bella', 'Dog', 'Golden Retriever', 4, '2022-02-14', 'Ariana Cole', '0771009001', NULL, '2026-05-02 09:00:00', '2026-05-02 09:00:00'),
  (9002, 9001, 'Milo', 'Cat', 'British Shorthair', 3, '2023-03-18', 'Ariana Cole', '0771009001', NULL, '2026-05-02 09:05:00', '2026-05-02 09:05:00'),
  (9003, 9002, 'Rocky', 'Dog', 'Beagle', 5, '2021-07-22', 'Ben Walker', '0771009002', NULL, '2026-05-02 09:10:00', '2026-05-02 09:10:00'),
  (9004, 9003, 'Luna', 'Cat', 'Persian', 2, '2024-01-11', 'Maya Perera', '0771009003', NULL, '2026-05-02 09:15:00', '2026-05-02 09:15:00'),
  (9005, 9003, 'Charlie', 'Dog', 'Labrador', 6, '2020-09-05', 'Maya Perera', '0771009003', NULL, '2026-05-02 09:20:00', '2026-05-02 09:20:00');

-- Vaccine templates.
INSERT IGNORE INTO `vaccine_templates`
  (`id`, `pet_type`, `vaccine_name`, `recommended_age_weeks`, `booster_interval_months`, `description`, `is_active`, `created_at`)
VALUES
  (9001, 'dog', 'Canine Rabies Annual', 12, 12, 'Annual rabies protection for dogs.', 1, '2026-05-02 10:00:00'),
  (9002, 'dog', 'Canine DHPP Booster', 8, 12, 'Booster for distemper, hepatitis, parvovirus, and parainfluenza.', 1, '2026-05-02 10:05:00'),
  (9003, 'cat', 'Feline Rabies Annual', 12, 12, 'Annual rabies protection for cats.', 1, '2026-05-02 10:10:00'),
  (9004, 'cat', 'FVRCP Core Booster', 8, 12, 'Core feline respiratory and panleukopenia booster.', 1, '2026-05-02 10:15:00'),
  (9005, 'dog', 'Kennel Cough', 10, 6, 'Bordetella protection for social dogs.', 1, '2026-05-02 10:20:00');

-- Appointments.
INSERT IGNORE INTO `appointments`
  (`id`, `pet_id`, `pet_name`, `owner_id`, `nurse_id`, `appointment_date`, `reason`, `status`, `appointment_type`, `weight`, `temperature`, `vitals_notes`, `diagnosis`, `prescription`, `checked_in_at`, `ready_at`, `consultation_started_at`, `completed_at`, `created_at`)
VALUES
  (9001, 9001, 'Bella', 9001, 9005, '2026-06-03 09:00:00', 'Annual wellness check and vaccine review.', 'confirmed', 'general', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-03 08:00:00'),
  (9002, 9002, 'Milo', 9001, 9005, '2026-06-03 10:00:00', 'FVRCP booster appointment.', 'pending', 'vaccination', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-03 08:10:00'),
  (9003, 9003, 'Rocky', 9002, 9005, '2026-05-15 11:00:00', 'Ear irritation and scratching.', 'completed', 'general', '12.4 kg', '38.5 C', 'Alert and hydrated.', 'Mild otitis externa.', 'Ear drops twice daily for 7 days.', '2026-05-15 10:45:00', '2026-05-15 10:55:00', '2026-05-15 11:05:00', '2026-05-15 11:35:00', '2026-05-03 08:20:00'),
  (9004, 9004, 'Luna', 9003, 9005, '2026-06-04 14:00:00', 'Rabies vaccination.', 'confirmed', 'vaccination', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-03 08:30:00'),
  (9005, 9005, 'Charlie', 9003, 9005, '2026-05-16 15:30:00', 'Dental check and appetite concern.', 'completed', 'general', '28.1 kg', '38.7 C', 'Mild tartar noted.', 'Dental plaque with mild gingivitis.', 'Dental cleaning recommended; soft diet for 3 days.', '2026-05-16 15:10:00', '2026-05-16 15:20:00', '2026-05-16 15:35:00', '2026-05-16 16:05:00', '2026-05-03 08:40:00');

-- Nurse notes.
INSERT IGNORE INTO `nurse_notes`
  (`id`, `appointment_id`, `weight`, `temperature`, `symptoms`, `notes`, `created_by`, `created_at`)
VALUES
  (9001, 9001, '25.6 kg', '38.4 C', 'No visible symptoms.', 'Pre-visit note prepared for wellness check.', 9005, '2026-05-03 09:00:00'),
  (9002, 9002, '4.8 kg', '38.2 C', 'No visible symptoms.', 'Owner reports normal appetite.', 9005, '2026-05-03 09:05:00'),
  (9003, 9003, '12.4 kg', '38.5 C', 'Right ear scratching.', 'Ear redness observed before consultation.', 9005, '2026-05-15 10:50:00'),
  (9004, 9004, '3.9 kg', '38.1 C', 'No visible symptoms.', 'Vaccination screening completed.', 9005, '2026-05-03 09:15:00'),
  (9005, 9005, '28.1 kg', '38.7 C', 'Reduced appetite.', 'Dental tartar visible during intake.', 9005, '2026-05-16 15:15:00');

-- Medical records.
INSERT IGNORE INTO `medical_records`
  (`id`, `pet_id`, `vet_id`, `treatment_date`, `diagnosis`, `treatment`, `medicines`, `notes`, `created_at`)
VALUES
  (9001, 9001, 9004, '2026-02-20', 'Healthy adult dog', 'Routine wellness exam completed.', 'Multivitamin supplement as needed.', 'Normal heart and lung sounds.', '2026-05-03 10:00:00'),
  (9002, 9002, 9004, '2026-03-12', 'Mild hairball irritation', 'Diet review and grooming advice.', 'Hairball paste weekly.', 'Monitor vomiting frequency.', '2026-05-03 10:05:00'),
  (9003, 9003, 9004, '2026-05-15', 'Mild otitis externa', 'Ear cleaning and topical treatment.', 'Antibiotic ear drops.', 'Recheck if scratching continues.', '2026-05-15 11:40:00'),
  (9004, 9004, 9004, '2026-04-08', 'Healthy juvenile cat', 'Routine exam and weight check.', NULL, 'Weight gain is appropriate.', '2026-05-03 10:15:00'),
  (9005, 9005, 9004, '2026-05-16', 'Mild gingivitis', 'Dental exam and cleaning recommendation.', 'Chlorhexidine oral rinse.', 'Schedule cleaning within 30 days.', '2026-05-16 16:10:00');

-- Vaccination schedule.
INSERT IGNORE INTO `vaccination_schedule`
  (`id`, `pet_id`, `vaccine_template_id`, `vaccine_name`, `due_date`, `status`, `created_at`)
VALUES
  (9001, 9001, 9001, 'Canine Rabies Annual', '2026-06-20', 'Upcoming', '2026-05-03 11:00:00'),
  (9002, 9002, 9004, 'FVRCP Core Booster', '2026-06-03', 'Upcoming', '2026-05-03 11:05:00'),
  (9003, 9003, 9002, 'Canine DHPP Booster', '2026-07-15', 'Upcoming', '2026-05-03 11:10:00'),
  (9004, 9004, 9003, 'Feline Rabies Annual', '2026-06-04', 'Upcoming', '2026-05-03 11:15:00'),
  (9005, 9005, 9005, 'Kennel Cough', '2026-05-01', 'Overdue', '2026-05-03 11:20:00');

-- Vaccinations.
INSERT IGNORE INTO `vaccinations`
  (`id`, `appointment_id`, `pet_id`, `vaccine_name`, `date_given`, `next_due_date`, `notes`, `batch_number`, `vet_id`, `created_at`)
VALUES
  (9001, 9003, 9003, 'Canine DHPP Booster', '2025-07-15', '2026-07-15', 'Previous annual booster recorded.', 'DHPP-250715-A', 9004, '2026-05-03 12:00:00'),
  (9002, 9005, 9005, 'Canine Rabies Annual', '2025-05-01', '2026-05-01', 'Rabies vaccine administered at previous visit.', 'RAB-250501-B', 9004, '2026-05-03 12:05:00'),
  (9003, NULL, 9001, 'Canine Rabies Annual', '2025-06-20', '2026-06-20', 'Imported prior clinic vaccine record.', 'RAB-250620-C', 9004, '2026-05-03 12:10:00'),
  (9004, NULL, 9002, 'FVRCP Core Booster', '2025-06-03', '2026-06-03', 'Imported prior clinic vaccine record.', 'FVRCP-250603-D', 9004, '2026-05-03 12:15:00'),
  (9005, NULL, 9004, 'Feline Rabies Annual', '2025-06-04', '2026-06-04', 'Imported prior clinic vaccine record.', 'FRAB-250604-E', 9004, '2026-05-03 12:20:00');

-- Pet vaccination history.
INSERT IGNORE INTO `pet_vaccination_history`
  (`id`, `pet_id`, `vaccine_name`, `date_given`, `next_due_date`, `notes`, `uploaded_document`, `created_at`)
VALUES
  (9001, 9001, 'Canine Rabies Annual', '2025-06-20', '2026-06-20', 'Owner supplied previous rabies certificate.', NULL, '2026-05-03 13:00:00'),
  (9002, 9002, 'FVRCP Core Booster', '2025-06-03', '2026-06-03', 'Owner supplied previous FVRCP certificate.', NULL, '2026-05-03 13:05:00'),
  (9003, 9003, 'Canine DHPP Booster', '2025-07-15', '2026-07-15', 'Previous annual booster from external clinic.', NULL, '2026-05-03 13:10:00'),
  (9004, 9004, 'Feline Rabies Annual', '2025-06-04', '2026-06-04', 'Previous rabies vaccine from external clinic.', NULL, '2026-05-03 13:15:00'),
  (9005, 9005, 'Kennel Cough', '2025-05-01', '2026-05-01', 'Bordetella vaccine previously administered.', NULL, '2026-05-03 13:20:00');

-- Status logs.
INSERT IGNORE INTO `status_logs`
  (`id`, `appointment_id`, `old_status`, `new_status`, `updated_by`, `updated_at`)
VALUES
  (9001, 9001, NULL, 'confirmed', 9005, '2026-05-03 14:00:00'),
  (9002, 9002, NULL, 'pending', 9005, '2026-05-03 14:05:00'),
  (9003, 9003, 'ready', 'completed', 9004, '2026-05-15 11:35:00'),
  (9004, 9004, NULL, 'confirmed', 9005, '2026-05-03 14:15:00'),
  (9005, 9005, 'ready', 'completed', 9004, '2026-05-16 16:05:00');

COMMIT;
