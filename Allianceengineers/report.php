<?php
require_once "config/database.php";
require_once "includes/auth.php";

$projectId=(int)($_GET['project_id'] ?? 0);
$stmt=$pdo->prepare("SELECT * FROM projects WHERE id=?");
$stmt->execute([$projectId]);
$project=$stmt->fetch();
if(!$project) die("Project not found.");

$stmt=$pdo->prepare("SELECT d.*,p.file_name,p.original_name FROM defects d JOIN photos p ON p.id=d.photo_id WHERE d.project_id=? ORDER BY d.id");
$stmt->execute([$projectId]);
$defects=$stmt->fetchAll();

$stmt=$pdo->prepare("SELECT * FROM boq_items WHERE project_id=? ORDER BY id");
$stmt->execute([$projectId]);
$items=$stmt->fetchAll();
$total=0; foreach($items as $it) $total+=(float)$it['amount'];

$pageTitle="Inspection Report";
include "includes/header.php";
?>
<div class="report-toolbar no-print">
<a class="btn" href="project.php?id=<?= $projectId ?>">← Back</a>
<button class="btn btn-primary" onclick="window.print()">Print / Save as PDF</button>
</div>

<section class="report-paper">
<div class="report-header">
<div><p class="eyebrow">ALLIANCE ENGINEERS</p><h1>Structural Inspection Report</h1><p><?= htmlspecialchars($project['project_name']) ?></p></div>
<div class="report-id">AE-<?= str_pad($projectId,4,'0',STR_PAD_LEFT) ?><br><?= htmlspecialchars($project['inspection_date']) ?></div>
</div>

<div class="report-meta">
<div><strong>Building</strong><span><?= htmlspecialchars($project['building_name']) ?></span></div>
<div><strong>Location</strong><span><?= htmlspecialchars($project['location']) ?></span></div>
<div><strong>Engineer</strong><span><?= htmlspecialchars($project['engineer_name']) ?></span></div>
</div>

<h2>Inspection Findings</h2>
<?php foreach($defects as $d): ?>
<div class="report-defect">
<div class="report-img"><img src="<?= UPLOAD_URL . htmlspecialchars($d['file_name']) ?>" alt=""></div>
<div>
<span class="badge <?= strtolower($d['severity']) ?>"><?= htmlspecialchars($d['severity']) ?> Alert</span>
<h3><?= htmlspecialchars($d['defect_type']) ?></h3>
<p><strong>Possible cause:</strong> <?= htmlspecialchars($d['possible_cause']) ?></p>
<p><strong>Risk if untreated:</strong> <?= htmlspecialchars($d['risk_if_untreated']) ?></p>
<p><strong>Recommended solution:</strong> <?= htmlspecialchars($d['recommendation']) ?></p>
<p><strong>Suggested timeline:</strong> <?= htmlspecialchars($d['suggested_timeline']) ?></p>
</div>
</div>
<?php endforeach; ?>

<h2>Bill of Quantities</h2>
<?php if($items): ?>
<table class="boq"><thead><tr><th>Code</th><th>Description</th><th>Qty</th><th>Unit</th><th>Rate</th><th>Amount</th></tr></thead>
<tbody>
<?php foreach($items as $it): ?><tr><td><?= htmlspecialchars($it['item_code']) ?></td><td><?= htmlspecialchars($it['description']) ?></td><td><?= number_format($it['quantity'],2) ?></td><td><?= htmlspecialchars($it['unit']) ?></td><td>₹ <?= number_format($it['rate'],2) ?></td><td>₹ <?= number_format($it['amount'],2) ?></td></tr><?php endforeach; ?>
</tbody><tfoot><tr><th colspan="5">Estimated Total</th><th>₹ <?= number_format($total,2) ?></th></tr></tfoot></table>
<?php else: ?><p class="muted">No BOQ items generated.</p><?php endif; ?>

<div class="report-disclaimer">
<strong>Academic prototype:</strong> Findings, quantities and rates shown by this demo must be verified by a qualified civil/structural engineer and replaced with approved site measurements and applicable rate data before professional use.
</div>
</section>
<?php include "includes/footer.php"; ?>
