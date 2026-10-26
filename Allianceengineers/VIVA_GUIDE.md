# VIVA GUIDE

## 1. What is your project?
"Alliance Engineers Structural Inspection & BOQ Management System is a web-based PHP and MySQL application that helps organize building inspection projects, upload inspection photographs, document defects, and prepare a basic bill of quantities."

## 2. Why did you make it?
"Manual inspection records can become difficult to organize when there are many photographs and findings. Our system centralizes project information, photos, findings and BOQ in one application."

## 3. What technologies did you use?
"HTML, CSS and JavaScript for the interface, PHP for server-side logic, and MySQL for data storage. WAMP is used as the local development environment."

## 4. What is the main workflow?
"Create inspection -> upload multiple photos -> analyze/document defects -> review severity and recommendations -> generate BOQ -> print report."

## 5. Is the AI real?
For this semester version:
"The analysis module is a demo rule-based engine. It demonstrates how an AI analysis module would connect to the application. A future production version can integrate a validated computer-vision service."

Do NOT claim that this demo certifies structural safety.

## 6. What is a database?
"A structured collection of data. Our MySQL database stores users, projects, photos, defects and BOQ items."

## 7. What is a primary key?
"A column that uniquely identifies a record, such as `id`."

## 8. What is a foreign key?
"A field that connects a record to another table. For example, `project_id` in photos connects a photo to a project."

## 9. What is CRUD?
Create, Read, Update and Delete.

## 10. What is a session?
"A PHP session lets the server remember that a user has logged in while they navigate between protected pages."

## 11. What is BOQ?
"Bill of Quantities. It lists work items, quantities, units and rates used for estimating project work."

## 12. What would you improve?
- Real computer-vision API
- Actual DSR/rate database
- PDF and Excel exports
- Engineer approval
- Image annotations
- Role-based access
- Cloud deployment
- Audit history
