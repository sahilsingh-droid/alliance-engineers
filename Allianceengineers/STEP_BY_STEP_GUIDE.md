# STEP-BY-STEP GUIDE — BUILD AND UNDERSTAND YOUR PROJECT

## PART 1 — Understand the idea

Your project is not simply a company website.

It is a small **Structural Inspection Management System**.

Main flow:

Browser
  ↓
PHP pages
  ↓
MySQL database
  ↓
Uploaded inspection photos
  ↓
Demo analysis engine
  ↓
Defect findings
  ↓
BOQ
  ↓
Report

## PART 2 — Install WAMP

1. Install WAMP on Windows.
2. Open WAMP.
3. Wait until the WAMP icon is green.
4. Open:
   http://localhost/
5. Open phpMyAdmin:
   http://localhost/phpmyadmin/

## PART 3 — Put the project in WAMP

Copy this complete folder:

AllianceEngineers_CollegeProject

to:

C:\wamp64\www\

The final path should be:

C:\wamp64\www\AllianceEngineers_CollegeProject\

Do NOT put the project inside another nested copy of itself.

## PART 4 — Create the database

1. Open phpMyAdmin.
2. Click Import.
3. Select:
   database.sql
4. Click Go.

The SQL file creates:
- users
- projects
- photos
- defects
- boq_items

It also creates a demo admin user and one demo project.

## PART 5 — Check database settings

Open:

config/database.php

Default WAMP values are:

Host: localhost
Database: alliance_engineers
Username: root
Password: blank

If your MySQL password is different, change `$DB_PASS`.

## PART 6 — Start the application

Open:

http://localhost/AllianceEngineers_CollegeProject/

Login:

Username:
admin

Password:
admin123

## PART 7 — Learn the login

`login.php`
- receives username/password
- checks the database
- creates a PHP session
- redirects to dashboard

`includes/auth.php`
- protects pages
- if a user is not logged in, it redirects to login.

## PART 8 — Learn the dashboard

`dashboard.php` runs SQL queries to count:
- projects
- photos
- defects
- high alerts

It also lists recent projects.

## PART 9 — Create an inspection

Click:

New Inspection

Fill:
- project name
- building/society
- location
- engineer
- inspection date

PHP inserts the information into the `projects` table.

## PART 10 — Upload photos

Open the project.

Select several JPG/PNG/WebP files.

`upload.php`:
1. receives the files
2. checks extension
3. generates a unique filename
4. moves the file to `/uploads`
5. stores the filename and project ID in MySQL

This is why the same image can later be shown on the project page.

## PART 11 — Understand the demo analysis

Click:

Analyze Photos

`analyze.php` reads the project's photos.

For this college version, it uses predefined inspection templates:
- Surface / Wall Crack
- Water Seepage / Dampness
- Concrete Spalling / Surface Deterioration
- Paint / Plaster Deterioration

The system stores:
- defect type
- severity
- possible cause
- risk if untreated
- recommendation
- timeline

This is intentionally a DEMO analysis engine.

## PART 12 — Why this is useful

You can explain:

"At this stage our system demonstrates the complete inspection workflow. The analysis engine is modular, so a validated computer-vision API can replace the demo rule engine later."

That is much safer and easier to explain than claiming that a photograph alone can certify a building as safe or unsafe.

## PART 13 — Generate BOQ

Click:

Generate BOQ

The system maps documented defects to example work items.

Example:
Water seepage -> waterproofing treatment
Crack -> crack repair
Concrete spalling -> concrete repair

The BOQ contains:
- item code
- description
- quantity
- unit
- rate
- amount

## PART 14 — Understand the database

### users
Stores login users.

### projects
Stores building inspection projects.

### photos
Stores uploaded photo filenames and links them to a project.

### defects
Stores analysis results and links each finding to a photo/project.

### boq_items
Stores BOQ work items and links them to a project/defect.

Relationship:

users
  |
projects
  |
  +--- photos
  |
  +--- defects --- photos
  |
  +--- boq_items --- defects

## PART 15 — Understand the most important PHP pattern

Example:

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=?");
$stmt->execute([$id]);

This is a prepared SQL statement.

Then:

$project = $stmt->fetch();

gets one database row.

## PART 16 — If something breaks

### Apache not running
Open WAMP and start Apache.

### MySQL not running
Start MySQL.

### Database connection failed
Check:
config/database.php

### 404 error
Check that the folder is directly under:
C:\wamp64\www\

### Images do not upload
Check:
- `uploads` folder exists
- Apache has permission
- selected file is JPG/PNG/WebP
- PHP upload limits

## PART 17 — What to learn before viva

Know these terms:
- Frontend
- Backend
- PHP
- MySQL
- Session
- CRUD
- Prepared statement
- Foreign key
- File upload
- MIME/type validation
- BOQ
- DSR
- Defect severity
- Database normalization

## PART 18 — Suggested development order

Do not try to learn everything in one day.

Day 1:
WAMP + database + login

Day 2:
Dashboard + project creation

Day 3:
Multiple image upload

Day 4:
Analysis module

Day 5:
BOQ

Day 6:
Report + UI improvements

Day 7:
Practice viva and demo

