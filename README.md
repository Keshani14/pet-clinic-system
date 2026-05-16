# 🐾 Pet Clinic Management System

A high-end, full-stack veterinary management platform designed to streamline clinic operations while providing a premium experience for pet owners. Built with a custom **PHP MVC Architecture** and a focus on visual excellence.

---

## 🌟 Key Features

### 🏢 Clinic Management (Admin & Staff)
- **Role-Based Dashboards:** Unique interfaces for Administrators, Veterinarians, Nurses, and Staff.
- **Smart Appointment System:** Real-time booking with automated validation for clinic working hours and past-date prevention.
- **Queue Management:** Track patient status from "Checked-in" to "Completed" in real-time.
- **Medical Records:** Comprehensive history of diagnoses, treatments, and prescriptions for every pet.

### 💉 Vaccination & Health Tracking
- **Automated Scheduling:** Smart tracking of upcoming and overdue vaccinations based on pet type (Dogs/Cats).
- **Template System:** Standardized vaccination protocols for consistent pet care.
- **Alert System:** Dashboard notifications for staff and owners regarding urgent medical needs.

### 🐶 Pet Owner Portal
- **24/7 Online Booking:** Easy appointment scheduling with preferred doctors.
- **Digital Health Passport:** Instant access to pet medical history and vaccination records.
- **Profile Management:** Manage multiple pets with detailed profiles and photos.

---

## 🎨 Visual Excellence
The system features a **state-of-the-art UI** designed for maximum user engagement:
- **Glassmorphism Design:** Modern, translucent interfaces with soft blurs and depth.
- **Responsive Layouts:** Seamless experience across Desktop, Tablet, and Mobile.
- **Micro-Animations:** Hover effects, smooth transitions, and playful paw-print decorations that bring the platform to life.
- **Optimized Performance:** Fast-loading pages built with clean, semantic HTML5 and Vanilla CSS.

---

## 🔄 System Workflow
The platform follows a streamlined patient journey with automated health tracking:

1. **Smart Registration:** When a pet is registered, the system automatically generates a **full vaccination schedule** tailored to the pet type (Dog/Cat) and age.
2. **Booking:** Owners schedule appointments online, selecting pet type, preferred doctor, and reason for visit (General or Vaccination).
3. **Confirmation:** Clinic staff review and confirm the appointment. The owner's dashboard updates in real-time.
4. **Check-in:** Upon arrival, the Nurse checks the pet in, recording vitals (Weight, Temp) and initial symptoms.
5. **Clinical Action:** The Vet performs the exam. If it's a vaccination appointment, the system records the batch number, next due date, and automatically updates the immunization passport.
6. **Completion:** The record is finalized, the schedule status is updated, and the pet's digital medical history is immediately available to the owner.

---

## 🛠️ Technology Stack
- **Backend:** PHP 8.x (Custom MVC Framework)
- **Database:** MySQL / MariaDB
- **Frontend:** Vanilla JavaScript (ES6+), Modern Vanilla CSS
- **Tools:** Flatpickr (Calendar), FontAwesome, Google Fonts

---

## 🚀 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Keshani14/pet-clinic-system.git
   ```

2. **Database Configuration:**
   - Import the `config/database.sql` file into your MySQL server (via phpMyAdmin or CLI).
   - Ensure your database connection settings in `core/Database.php` match your local environment.

3. **Web Server:**
   - Place the project folder in your local server directory (e.g., `xampp/htdocs`).
   - Access the system via `http://localhost/pet-clinic-system/public`.

---

## 🔐 Demo Credentials
Standardized for easy testing across all roles:
- **Admin:** `admin@test.com` | Password: `password`
- **Veterinarian:** `vet@test.com` | Password: `password`
- **Nurse:** `nurse@pet.com` | Password: `password`
- **Pet Owner:** `owner@pet.com` | Password: `password`

---

## 📄 License
This project is for demonstration purposes. Feel free to use and adapt it for your own portfolios!
