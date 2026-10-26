<?php
require_once "config/database.php";
require_once "includes/auth.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: dashboard.php"); exit;
}

$projectId = (int)($_POST['project_id'] ?? 0);
if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0775, true);

$allowed = ['jpg','jpeg','png','webp'];

foreach ($_FILES['photos']['tmp_name'] as $i => $tmp) {
    if ($_FILES['photos']['error'][$i] !== UPLOAD_ERR_OK) continue;

    $original = basename($_FILES['photos']['name'][$i]);
    $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed, true)) continue;
    if (@getimagesize($tmp) === false) continue;

    $safe = bin2hex(random_bytes(10)) . "." . $ext;

    if (move_uploaded_file($tmp, UPLOAD_DIR . $safe)) {
        $stmt = $pdo->prepare("INSERT INTO photos(project_id,file_name,original_name) VALUES(?,?,?)");
        $stmt->execute([$projectId,$safe,$original]);
    }
}

$pdo->prepare("UPDATE projects SET status='Photos Uploaded' WHERE id=?")->execute([$projectId]);

header("Location: project.php?id=".$projectId);
exit;
?>
