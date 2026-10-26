<?php
require_once "config/database.php";
require_once "includes/auth.php";
$pageTitle = "Dashboard";

$projectCount = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$photoCount = $pdo->query("SELECT COUNT(*) FROM photos")->fetchColumn();
$defectCount = $pdo->query("SELECT COUNT(*) FROM defects")->fetchColumn();
$highCount = $pdo->query("SELECT COUNT(*) FROM defects WHERE severity='High'")->fetchColumn();

$projects = $pdo->query("
SELECT p.*,
(SELECT COUNT(*) FROM photos ph WHERE ph.project_id=p.id) AS photo_count,
(SELECT COUNT(*) FROM defects d WHERE d.project_id=p.id) AS defect_count
FROM projects p ORDER BY p.id DESC
")->fetchAll();

include "includes/header.php";
?>
<section class="hero">
  <div>
    <p class="eyebrow">COLLEGE PROJECT • MVP</p>
    <h1>Structural Inspection Dashboard</h1>
    <p>Manage building inspections, inspection photographs, documented defects and basic BOQ estimates in one place.</p>
  </div>
  <a class="btn btn-light" href="project_new.php">+ New Inspection</a>
</section>

<div class="stats">
  <div class="stat"><span>Projects</span><b><?= $projectCount ?></b></div>
  <div class="stat"><span>Photos</span><b><?= $photoCount ?></b></div>
  <div class="stat"><span>Defects</span><b><?= $defectCount ?></b></div>
  <div class="stat danger"><span>High Alerts</span><b><?= $highCount ?></b></div>
</div>

<section class="panel">
  <div class="panel-head"><div><h2>Recent Inspections</h2><p>Open a project to upload photographs and inspect findings.</p></div><a class="btn" href="project_new.php">Create Project</a></div>
  <div class="table-wrap">
  <table>
    <thead><tr><th>Project</th><th>Building</th><th>Location</th><th>Status</th><th>Photos</th><th>Defects</th><th></th></tr></thead>
    <tbody>
    <?php foreach($projects as $p): ?>
      <tr>
        <td><strong><?= htmlspecialchars($p['project_name']) ?></strong><small><?= htmlspecialchars($p['inspection_date']) ?></small></td>
        <td><?= htmlspecialchars($p['building_name']) ?></td>
        <td><?= htmlspecialchars($p['location']) ?></td>
        <td><span class="status-pill"><?= htmlspecialchars($p['status']) ?></span></td>
        <td><?= $p['photo_count'] ?></td>
        <td><?= $p['defect_count'] ?></td>
        <td><a class="btn btn-small" href="project.php?id=<?= $p['id'] ?>">Open</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</section>

<div class="academic-note">
<strong>For your viva:</strong> This is an inspection-management prototype. The current analysis engine demonstrates the application workflow with predefined templates. A future version can connect a validated vision-AI service and engineer approval.
</div>
<?php include "includes/footer.php"; ?>
