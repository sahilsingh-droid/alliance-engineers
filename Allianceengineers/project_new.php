<?php
require_once "config/database.php";
require_once "includes/auth.php";
$pageTitle = "New Inspection";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO projects (project_name,building_name,location,engineer_name,inspection_date,status) VALUES (?,?,?,?,?,?)");
    $stmt->execute([
        trim($_POST['project_name']),
        trim($_POST['building_name']),
        trim($_POST['location']),
        trim($_POST['engineer_name']),
        $_POST['inspection_date'] ?: date('Y-m-d'),
        'Draft'
    ]);
    header("Location: project.php?id=".$pdo->lastInsertId());
    exit;
}
include "includes/header.php";
?>
<section class="panel narrow-panel">
<div class="panel-head"><div><p class="eyebrow">STEP 1</p><h2>Create Inspection</h2><p>Start a new building inspection project.</p></div></div>
<form method="post" class="form-grid">
<label>Project Name<input name="project_name" required placeholder="e.g. Sunrise Society Inspection"></label>
<label>Building / Society<input name="building_name" placeholder="e.g. Tower A"></label>
<label>Location<input name="location" placeholder="e.g. Mumbai"></label>
<label>Engineer Name<input name="engineer_name" placeholder="e.g. Eng. Rahul"></label>
<label>Inspection Date<input type="date" name="inspection_date" value="<?= date('Y-m-d') ?>"></label>
<div class="form-actions"><a class="btn" href="dashboard.php">Cancel</a><button class="btn btn-primary" type="submit">Create & Continue →</button></div>
</form>
</section>
<?php include "includes/footer.php"; ?>
