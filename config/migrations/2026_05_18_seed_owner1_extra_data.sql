-- Extra demo data for seed.owner1@petclinic.test.
-- Safe to re-run: fixed high IDs plus INSERT IGNORE avoid duplicate-key failures.

CREATE DATABASE IF NOT EXISTS `pet_clinic`;
USE `pet_clinic`;

START TRANSACTION;

-- Ensure the owner and staff accounts needed by this seed exist.
-- Password for seeded accounts is "password".
INSERT IGNORE INTO `users`
  (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `role`, `status`, `created_at`, `updated_at`)
VALUES
  (9001, 'Ariana', 'Cole', 'seed.owner1@petclinic.test', '0771009001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', 'approved', '2026-05-01 08:00:00', '2026-05-01 08:00:00'),
  (9004, 'Noah', 'Silva', 'seed.vet1@petclinic.test', '0771009004', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vet', 'approved', '2026-05-01 08:15:00', '2026-05-01 08:15:00'),
  (9005, 'Leah', 'Fernando', 'seed.nurse1@petclinic.test', '0771009005', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nurse', 'approved', '2026-05-01 08:20:00', '2026-05-01 08:20:00');

-- Ensure vaccine templates referenced below exist.
INSERT IGNORE INTO `vaccine_templates`
  (`id`, `pet_type`, `vaccine_name`, `recommended_age_weeks`, `booster_interval_months`, `description`, `is_active`, `created_at`)
VALUES
  (9101, 'dog', 'Canine Leptospirosis', 10, 12, 'Annual protection against leptospirosis.', 1, '2026-05-18 09:00:00'),
  (9102, 'dog', 'Canine Influenza', 8, 12, 'Respiratory vaccine for dogs with social exposure.', 1, '2026-05-18 09:05:00'),
  (9103, 'cat', 'Feline Chlamydia', 9, 12, 'Optional feline respiratory vaccine.', 1, '2026-05-18 09:10:00'),
  (9104, 'cat', 'Feline Bordetella', 8, 12, 'Respiratory support vaccine for high-exposure cats.', 1, '2026-05-18 09:15:00'),
  (9105, 'dog', 'Canine Lyme', 12, 12, 'Annual Lyme disease protection for dogs.', 1, '2026-05-18 09:20:00');

-- Additional pets owned by seed.owner1@petclinic.test.
INSERT IGNORE INTO `pets`
  (`id`, `owner_id`, `name`, `type`, `breed`, `age`, `dob`, `owner_name`, `owner_phone`, `photo`, `created_at`, `updated_at`)
VALUES
  (9101, 9001, 'Daisy', 'Dog', 'Cocker Spaniel', 2, '2024-04-12', 'Ariana Cole', '0771009001', NULL, '2026-05-18 09:30:00', '2026-05-18 09:30:00'),
  (9102, 9001, 'Oscar', 'Cat', 'Maine Coon', 5, '2021-10-03', 'Ariana Cole', '0771009001', NULL, '2026-05-18 09:35:00', '2026-05-18 09:35:00'),
  (9103, 9001, 'Ruby', 'Dog', 'Poodle', 1, '2025-02-24', 'Ariana Cole', '0771009001', NULL, '2026-05-18 09:40:00', '2026-05-18 09:40:00'),
  (9104, 9001, 'Nala', 'Cat', 'Siamese', 4, '2022-08-09', 'Ariana Cole', '0771009001', NULL, '2026-05-18 09:45:00', '2026-05-18 09:45:00'),
  (9105, 9001, 'Teddy', 'Dog', 'Shih Tzu', 7, '2019-12-19', 'Ariana Cole', '0771009001', NULL, '2026-05-18 09:50:00', '2026-05-18 09:50:00');

-- More appointments for owner1, mixing upcoming, pending, confirmed, and completed states.
INSERT IGNORE INTO `appointments`
  (`id`, `pet_id`, `pet_name`, `owner_id`, `nurse_id`, `appointment_date`, `reason`, `status`, `appointment_type`, `weight`, `temperature`, `vitals_notes`, `diagnosis`, `prescription`, `checked_in_at`, `ready_at`, `consultation_started_at`, `completed_at`, `created_at`)
VALUES
  (9101, 9101, 'Daisy', 9001, 9005, '2026-06-05 09:30:00', 'Puppy wellness review and leptospirosis vaccine.', 'confirmed', 'vaccination', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-18 10:00:00'),
  (9102, 9102, 'Oscar', 9001, 9005, '2026-06-06 11:00:00', 'Senior cat wellness exam and grooming concern.', 'pending', 'general', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-18 10:05:00'),
  (9103, 9103, 'Ruby', 9001, 9005, '2026-06-07 14:30:00', 'Canine influenza vaccine visit.', 'confirmed', 'vaccination', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-18 10:10:00'),
  (9104, 9104, 'Nala', 9001, 9005, '2026-05-10 10:15:00', 'Watery eyes and mild sneezing.', 'completed', 'general', '4.2 kg', '38.3 C', 'Mild clear ocular discharge.', 'Mild upper respiratory irritation.', 'Eye drops twice daily for 5 days.', '2026-05-10 09:55:00', '2026-05-10 10:05:00', '2026-05-10 10:20:00', '2026-05-10 10:50:00', '2026-05-18 10:15:00'),
  (9105, 9105, 'Teddy', 9001, 9005, '2026-05-11 16:00:00', 'Limping after park visit.', 'completed', 'general', '7.8 kg', '38.6 C', 'Mild tenderness in left rear leg.', 'Soft tissue strain.', 'Rest for 7 days; anti-inflammatory as prescribed.', '2026-05-11 15:40:00', '2026-05-11 15:50:00', '2026-05-11 16:05:00', '2026-05-11 16:35:00', '2026-05-18 10:20:00'),
  (9106, 9001, 'Bella', 9001, 9005, '2026-06-08 08:30:00', 'Dental follow-up and diet review.', 'confirmed', 'general', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-18 10:25:00'),
  (9107, 9002, 'Milo', 9001, 9005, '2026-06-09 15:00:00', 'Feline chlamydia vaccination consultation.', 'pending', 'vaccination', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-18 10:30:00');

-- Nurse intake notes for owner1 appointments.
INSERT IGNORE INTO `nurse_notes`
  (`id`, `appointment_id`, `weight`, `temperature`, `symptoms`, `notes`, `created_by`, `created_at`)
VALUES
  (9101, 9101, '10.1 kg', '38.5 C', 'No visible symptoms.', 'Vaccine screening checklist prepared.', 9005, '2026-05-18 10:40:00'),
  (9102, 9102, '6.4 kg', '38.2 C', 'Owner reports shedding and matting.', 'Grooming discussion requested.', 9005, '2026-05-18 10:45:00'),
  (9103, 9103, '5.7 kg', '38.4 C', 'No visible symptoms.', 'Social exposure at daycare noted.', 9005, '2026-05-18 10:50:00'),
  (9104, 9104, '4.2 kg', '38.3 C', 'Watery eyes and sneezing.', 'No appetite change reported.', 9005, '2026-05-10 10:00:00'),
  (9105, 9105, '7.8 kg', '38.6 C', 'Mild limp after exercise.', 'Pain response mild during handling.', 9005, '2026-05-11 15:45:00'),
  (9106, 9106, '25.9 kg', '38.4 C', 'No visible symptoms.', 'Owner asks about dental diet.', 9005, '2026-05-18 10:55:00'),
  (9107, 9107, '4.9 kg', '38.1 C', 'No visible symptoms.', 'Indoor cat with occasional boarding exposure.', 9005, '2026-05-18 11:00:00');

-- More medical history for owner1 pets.
INSERT IGNORE INTO `medical_records`
  (`id`, `pet_id`, `vet_id`, `treatment_date`, `diagnosis`, `treatment`, `medicines`, `notes`, `created_at`)
VALUES
  (9101, 9101, 9004, '2026-03-18', 'Healthy young dog', 'Routine exam and growth review.', NULL, 'Growth and appetite are normal.', '2026-05-18 11:10:00'),
  (9102, 9102, 9004, '2026-04-02', 'Mild skin dryness', 'Skin and coat assessment completed.', 'Omega-3 supplement.', 'Brush weekly and monitor scratching.', '2026-05-18 11:15:00'),
  (9103, 9103, 9004, '2026-04-22', 'Healthy puppy', 'Puppy checkup and nutrition advice.', NULL, 'Discussed training and vaccine timing.', '2026-05-18 11:20:00'),
  (9104, 9104, 9004, '2026-05-10', 'Mild upper respiratory irritation', 'Eye exam and supportive care.', 'Lubricating eye drops.', 'Recheck if discharge becomes colored.', '2026-05-10 10:55:00'),
  (9105, 9105, 9004, '2026-05-11', 'Soft tissue strain', 'Orthopedic exam and rest plan.', 'Anti-inflammatory medication.', 'Avoid jumping and stairs for one week.', '2026-05-11 16:40:00'),
  (9106, 9001, 9004, '2026-01-28', 'Dental tartar', 'Dental grading and home-care plan.', 'Dental chews recommended.', 'Schedule follow-up cleaning review.', '2026-05-18 11:25:00'),
  (9107, 9002, 9004, '2026-02-14', 'Healthy adult cat', 'Routine annual physical.', NULL, 'No abnormal findings.', '2026-05-18 11:30:00');

-- More reminders for owner1 pets.
INSERT IGNORE INTO `vaccination_schedule`
  (`id`, `pet_id`, `vaccine_template_id`, `vaccine_name`, `due_date`, `status`, `created_at`)
VALUES
  (9101, 9101, 9101, 'Canine Leptospirosis', '2026-06-05', 'Upcoming', '2026-05-18 11:40:00'),
  (9102, 9102, 9104, 'Feline Bordetella', '2026-07-02', 'Upcoming', '2026-05-18 11:45:00'),
  (9103, 9103, 9102, 'Canine Influenza', '2026-06-07', 'Upcoming', '2026-05-18 11:50:00'),
  (9104, 9104, 9103, 'Feline Chlamydia', '2026-05-25', 'Upcoming', '2026-05-18 11:55:00'),
  (9105, 9105, 9105, 'Canine Lyme', '2026-05-12', 'Overdue', '2026-05-18 12:00:00'),
  (9106, 9001, 9101, 'Canine Leptospirosis', '2026-06-08', 'Upcoming', '2026-05-18 12:05:00'),
  (9107, 9002, 9103, 'Feline Chlamydia', '2026-06-09', 'Upcoming', '2026-05-18 12:10:00');

-- More administered vaccination records for owner1 pets.
INSERT IGNORE INTO `vaccinations`
  (`id`, `appointment_id`, `pet_id`, `vaccine_name`, `date_given`, `next_due_date`, `notes`, `batch_number`, `vet_id`, `created_at`)
VALUES
  (9101, NULL, 9101, 'Canine Leptospirosis', '2025-06-05', '2026-06-05', 'Prior leptospirosis vaccine recorded.', 'LEP-250605-A', 9004, '2026-05-18 12:20:00'),
  (9102, NULL, 9102, 'Feline Bordetella', '2025-07-02', '2026-07-02', 'Prior respiratory vaccine recorded.', 'FBOR-250702-B', 9004, '2026-05-18 12:25:00'),
  (9103, NULL, 9103, 'Canine Influenza', '2025-06-07', '2026-06-07', 'Prior influenza vaccine recorded.', 'CINF-250607-C', 9004, '2026-05-18 12:30:00'),
  (9104, NULL, 9104, 'Feline Chlamydia', '2025-05-25', '2026-05-25', 'Prior feline chlamydia vaccine recorded.', 'FCHL-250525-D', 9004, '2026-05-18 12:35:00'),
  (9105, NULL, 9105, 'Canine Lyme', '2025-05-12', '2026-05-12', 'Prior Lyme vaccine recorded.', 'LYME-250512-E', 9004, '2026-05-18 12:40:00'),
  (9106, 9104, 9104, 'Feline Rabies Annual', '2026-05-10', '2027-05-10', 'Rabies vaccine administered during completed visit.', 'FRAB-260510-F', 9004, '2026-05-10 10:58:00'),
  (9107, 9105, 9105, 'Canine Rabies Annual', '2026-05-11', '2027-05-11', 'Rabies booster updated during completed visit.', 'RAB-260511-G', 9004, '2026-05-11 16:42:00');

-- More imported vaccination history for owner1 pets.
INSERT IGNORE INTO `pet_vaccination_history`
  (`id`, `pet_id`, `vaccine_name`, `date_given`, `next_due_date`, `notes`, `uploaded_document`, `created_at`)
VALUES
  (9101, 9101, 'Canine Leptospirosis', '2025-06-05', '2026-06-05', 'Imported from previous clinic record.', NULL, '2026-05-18 12:50:00'),
  (9102, 9102, 'Feline Bordetella', '2025-07-02', '2026-07-02', 'Imported from previous clinic record.', NULL, '2026-05-18 12:55:00'),
  (9103, 9103, 'Canine Influenza', '2025-06-07', '2026-06-07', 'Imported from previous clinic record.', NULL, '2026-05-18 13:00:00'),
  (9104, 9104, 'Feline Chlamydia', '2025-05-25', '2026-05-25', 'Imported from previous clinic record.', NULL, '2026-05-18 13:05:00'),
  (9105, 9105, 'Canine Lyme', '2025-05-12', '2026-05-12', 'Imported from previous clinic record.', NULL, '2026-05-18 13:10:00'),
  (9106, 9104, 'Feline Rabies Annual', '2026-05-10', '2027-05-10', 'Administered at PetSync.', NULL, '2026-05-10 11:00:00'),
  (9107, 9105, 'Canine Rabies Annual', '2026-05-11', '2027-05-11', 'Administered at PetSync.', NULL, '2026-05-11 16:45:00');

-- Status history for the added owner1 appointments.
INSERT IGNORE INTO `status_logs`
  (`id`, `appointment_id`, `old_status`, `new_status`, `updated_by`, `updated_at`)
VALUES
  (9101, 9101, NULL, 'confirmed', 9005, '2026-05-18 13:20:00'),
  (9102, 9102, NULL, 'pending', 9005, '2026-05-18 13:25:00'),
  (9103, 9103, NULL, 'confirmed', 9005, '2026-05-18 13:30:00'),
  (9104, 9104, 'ready', 'completed', 9004, '2026-05-10 10:50:00'),
  (9105, 9105, 'ready', 'completed', 9004, '2026-05-11 16:35:00'),
  (9106, 9106, NULL, 'confirmed', 9005, '2026-05-18 13:35:00'),
  (9107, 9107, NULL, 'pending', 9005, '2026-05-18 13:40:00');

COMMIT;
