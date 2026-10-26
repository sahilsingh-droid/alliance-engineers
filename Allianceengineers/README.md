# Alliance Engineers – Structural Inspection & BOQ Management System
### College Project / Semester MVP

This project is a self-built PHP + MySQL college project based on the requirements:
1. Create building inspection projects
2. Upload multiple inspection photos
3. Keep photos visible inside the website
4. Generate demo defect-analysis results
5. Show possible cause, severity, risk, recommendation and timeline
6. Generate a basic BOQ
7. Print an inspection/BOQ report
8. Dashboard statistics
9. Login/logout

## TECHNOLOGY
- HTML5
- CSS3
- JavaScript
- PHP 8+
- MySQL / MariaDB
- WAMP or XAMPP

## IMPORTANT ACADEMIC NOTE
The photo-analysis module is a DEMO rule-based analysis engine. It intentionally does not claim that a photograph alone can determine structural safety. For a production system, connect a validated computer-vision/AI service and require qualified engineer review.

## QUICK START
1. Install WAMP.
2. Start Apache and MySQL.
3. Copy the `AllianceEngineers_CollegeProject` folder into `C:\wamp64\www\`
4. Open phpMyAdmin.
5. Import `database.sql`.
6. Check `config/database.php`.
7. Open `http://localhost/AllianceEngineers_CollegeProject/`
8. Login:
   Username: admin
   Password: admin123

## FULL LEARNING GUIDE
Read `STEP_BY_STEP_GUIDE.md`.
For the database/project walkthrough read `DATABASE_SYSTEM_GUIDE.pdf`. For viva preparation read `VIVA_GUIDE.md`.

## DEMO FLOW
Login
 -> Dashboard
 -> New Inspection
 -> Enter project details
 -> Upload 4-8 photos
 -> Analyze Photos
 -> Review defect cards
 -> Generate BOQ
 -> Print Report

## PROJECT MODULES
- Authentication
- Dashboard
- Project management
- Bulk photo upload
- Inspection analysis
- Defect management
- BOQ
- Print report

## PRODUCTION UPGRADES
- Real AI vision API
- Engineer approval workflow
- Actual CPWD DSR database
- PDF/Excel export
- Image annotation
- User roles
- Audit logs
- Cloud storage
