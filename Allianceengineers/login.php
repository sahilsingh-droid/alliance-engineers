<?php
require_once "config/database.php";
session_start();

if (!empty($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit;
    }
    $error = "Invalid username or password.";
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login | Alliance Engineers</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
<div class="login-card">
  <div class="brand center">
    <div class="brand-mark">AE</div>
    <div><strong>ALLIANCE ENGINEERS</strong><span>Structural Inspection Platform</span></div>
  </div>
  <h1>Welcome back</h1>
  <p class="muted">Sign in to your inspection dashboard.</p>
  <?php if($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="post">
    <label>Username<input name="username" value="admin" required></label>
    <label>Password<input type="password" name="password" value="admin123" required></label>
    <button class="btn btn-primary full" type="submit">Login</button>
  </form>
  <div class="demo-login"><strong>Demo credentials</strong><br>admin / admin123</div>
</div>
</body>
</html>
