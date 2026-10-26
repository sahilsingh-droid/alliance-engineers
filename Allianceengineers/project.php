<?php
require_once "config/database.php";
require_once "includes/auth.php";
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=?");
$stmt->execute([$id]);
$project = $stmt->fetch();
if (!$project) die("Project not found.");

$stmt = $pdo->prepare("SELECT * FROM photos WHERE project_id=? ORDER BY id DESC");
$stmt->execute([$id]);
$photos = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT d.*,p.original_name FROM defects d JOIN photos p ON p.id=d.photo_id WHERE d.project_id=? ORDER BY d.id DESC");
$stmt->execute([$id]);
$defects = $stmt->fetchAll();

$pageTitle = $project['project_name'];
include "includes/header.php";
?>
<section class="project-heading">
<div>
<p class="eyebrow">INSPECTION #AE-<?= str_pad($id,4,'0',STR_PAD_LEFT) ?></p>
<h1><?= htmlspecialchars($project['project_name']) ?></h1>
<p><?= htmlspecialchars($project['building_name']) ?> • <?= htmlspecialchars($project['location']) ?> • <?= htmlspecialchars($project['inspection_date']) ?></p>
</div>
<div class="actions"><a class="btn" href="dashboard.php">Dashboard</a><a class="btn btn-primary" href="boq.php?project_id=<?= $id ?>">Generate BOQ</a></div>
</section>

<section class="panel">
<div class="panel-head"><div><p class="eyebrow">STEP 2</p><h2>Upload Inspection Photos</h2><p>Select multiple photographs. They will appear inside this website.</p></div></div>
<form action="upload.php" method="post" enctype="multipart/form-data" class="upload-box">
<input type="hidden" name="project_id" value="<?= $id ?>">
<input type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple required>
<button class="btn btn-primary" type="submit">Upload Photos</button>
</form>

<?php if($photos): ?>
<div class="photo-grid">
<?php foreach($photos as $photo): ?>
<figure class="photo-card">
<img src="<?= UPLOAD_URL . htmlspecialchars($photo['file_name']) ?>" alt="Inspection photo">
<figcaption><?= htmlspecialchars($photo['original_name']) ?></figcaption>
</figure>
<?php endforeach; ?>
</div>
<div class="analysis-bar">
<div><strong><?= count($photos) ?> photo(s) uploaded</strong><span>Ready for demo analysis.</span></div>
<form action="analyze.php" method="post"><input type="hidden" name="project_id" value="<?= $id ?>"><button class="btn btn-primary" type="submit">⚙ Analyze Photos</button></form>
</div>
<?php endif; ?>
</section>

<section class="panel">
<div class="panel-head"><div><p class="eyebrow">STEP 3</p><h2>Inspection Findings</h2><p>Documented issues linked to their source photos.</p></div></div>
<?php if(!$defects): ?>
<div class="empty">No findings yet. Upload photographs and click <strong>Analyze Photos</strong>.</div>
<?php else: ?>
<div class="defect-grid">
<?php foreach($defects as $d): ?>
<article class="defect-card">
<div class="defect-head"><span class="badge <?= strtolower($d['severity']) ?>"><?= htmlspecialchars($d['severity']) ?> Alert</span><span class="status-pill"><?= htmlspecialchars($d['engineer_status']) ?></span></div>
<h3><?= htmlspecialchars($d['defect_type']) ?></h3>
<div class="mini-photo">
<?php
$ps = $pdo->prepare("SELECT file_name FROM photos WHERE id=?");
$ps->execute([$d['photo_id']]);
$pp = $ps->fetch();
?>
<?php if($pp): ?><img src="<?= UPLOAD_URL . htmlspecialchars($pp['file_name']) ?>" alt="Finding photo"><?php endif; ?>
</div>
<p><strong>Photo:</strong> <?= htmlspecialchars($d['original_name']) ?></p>
<p><strong>Possible cause:</strong> <?= htmlspecialchars($d['possible_cause']) ?></p>
<p><strong>If untreated:</strong> <?= htmlspecialchars($d['risk_if_untreated']) ?></p>
<p><strong>Recommended solution:</strong> <?= htmlspecialchars($d['recommendation']) ?></p>
<p><strong>Suggested timeline:</strong> <?= htmlspecialchars($d['suggested_timeline']) ?></p>
</article>
<?php endforeach; ?>
</div>
<?php endif; ?>
</section>
<?php include "includes/footer.php"; ?>
