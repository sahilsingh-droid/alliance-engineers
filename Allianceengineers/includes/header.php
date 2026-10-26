<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$pageTitle = $pageTitle ?? APP_NAME;
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($pageTitle) ?> | <?= APP_NAME ?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="dashboard.php">
    <div class="brand-mark">AE</div>
    <div><strong>ALLIANCE ENGINEERS</strong><span>Structural Inspection & BOQ</span></div>
  </a>
  <nav class="nav">
    <a href="dashboard.php">Dashboard</a>
    <a href="project_new.php">New Inspection</a>
    <span class="user-chip"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></span>
    <a class="logout" href="logout.php">Logout</a>
  </nav>
</header>
<main class="container">
