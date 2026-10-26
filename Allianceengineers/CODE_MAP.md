# COMPLETE CODE MAP

## Main PHP pages
- index.php — entry point; sends user to login/dashboard.
- login.php — login form and session creation.
- logout.php — destroys session.
- dashboard.php — project/photo/defect statistics and project list.
- project_new.php — creates a new inspection project.
- project.php — project details, photo gallery, findings.
- upload.php — validates and stores multiple images.
- analyze.php — demo rule-based defect analysis.
- boq.php — BOQ generation and display.
- report.php — printable inspection + BOQ report.

## Configuration
- config/database.php — PDO/MySQL connection and application constants.

## Security/session
- includes/auth.php — blocks protected pages for logged-out users.
- uploads/.htaccess — blocks execution of PHP-like files from upload directory.

## Shared UI
- includes/header.php — navigation/header.
- includes/footer.php — footer and JavaScript include.

## Frontend
- assets/css/style.css — all UI styling/responsive/print CSS.
- assets/js/app.js — small upload interaction.

## Database
- database.sql — database + tables + demo data.

## Documentation
- README.md — quick project overview.
- STEP_BY_STEP_GUIDE.md — learning/setup guide.
- VIVA_GUIDE.md — viva questions and answers.
- DATABASE_SYSTEM_GUIDE.pdf — visual database/project walkthrough.

## Runtime folders
- uploads/ — uploaded inspection images.
- reports/ — reserved for future generated report files.
- assets/images/ — project/reference images.
