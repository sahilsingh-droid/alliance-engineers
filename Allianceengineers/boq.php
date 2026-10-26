<?php
require_once "config/database.php";
require_once "includes/auth.php";

$projectId = (int)($_GET['project_id'] ?? $_POST['project_id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=?");
$stmt->execute([$projectId]);
$project = $stmt->fetch();
if (!$project) die("Project not found.");

if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['add_item'])) {
    $stmt=$pdo->prepare("INSERT INTO boq_items(project_id,item_code,description,quantity,unit,rate) VALUES(?,?,?,?,?,?)");
    $stmt->execute([
        $projectId,trim($_POST['item_code']),trim($_POST['description']),
        (float)$_POST['quantity'],trim($_POST['unit']),(float)$_POST['rate']
    ]);
    header("Location: boq.php?project_id=".$projectId); exit;
}

if (isset($_GET['auto'])) {
    $count=$pdo->prepare("SELECT COUNT(*) FROM boq_items WHERE project_id=?");
    $count->execute([$projectId]);

    if (!$count->fetchColumn()) {
        $def=$pdo->prepare("SELECT * FROM defects WHERE project_id=?");
        $def->execute([$projectId]);

        $map=[
          'Water Seepage / Dampness'=>['AE-WP','Waterproofing / seepage treatment work',20,'Sq.m',650],
          'Concrete Spalling / Surface Deterioration'=>['AE-CR','Concrete repair and patch treatment',10,'Sq.m',950],
          'Surface / Wall Crack'=>['AE-CK','Crack repair and sealing',15,'R.m',180],
          'Paint / Plaster Deterioration'=>['AE-PP','Plaster/paint surface restoration',25,'Sq.m',220]
        ];

        foreach($def->fetchAll() as $d){
            $m=$map[$d['defect_type']] ?? ['AE-GEN','General repair work',1,'Job',5000];
            $ins=$pdo->prepare("INSERT INTO boq_items(project_id,defect_id,item_code,description,quantity,unit,rate) VALUES(?,?,?,?,?,?,?)");
            $ins->execute([$projectId,$d['id'],$m[0],$m[1],$m[2],$m[3],$m[4]]);
        }
    }
    header("Location: boq.php?project_id=".$projectId); exit;
}

$items=$pdo->prepare("SELECT * FROM boq_items WHERE project_id=? ORDER BY id");
$items->execute([$projectId]);
$items=$items->fetchAll();

$total=0;
foreach($items as $it) $total += (float)$it['amount'];

$pageTitle="BOQ";
include "includes/header.php";
?>
<section class="project-heading">
<div><p class="eyebrow">STEP 4</p><h1>Bill of Quantities</h1><p><?= htmlspecialchars($project['project_name']) ?> • <?= htmlspecialchars($project['building_name']) ?></p></div>
<div class="actions"><a class="btn" href="project.php?id=<?= $projectId ?>">← Back</a><a class="btn btn-primary" href="report.php?project_id=<?= $projectId ?>">View Report</a></div>
</section>

<section class="panel">
<div class="panel-head"><div><h2>BOQ Items</h2><p>Demo quantities/rates — verify against site measurements and applicable DSR before real use.</p></div>
<?php if(!$items): ?><a class="btn btn-primary" href="boq.php?project_id=<?= $projectId ?>&auto=1">Auto Generate BOQ</a><?php endif; ?></div>

<?php if(!$items): ?>
<div class="empty">No BOQ items yet. Analyze project photos first, then auto-generate the BOQ.</div>
<?php else: ?>
<div class="table-wrap">
<table class="boq">
<thead><tr><th>Sr</th><th>Code</th><th>Description</th><th>Qty</th><th>Unit</th><th>Rate (₹)</th><th>Amount (₹)</th></tr></thead>
<tbody>
<?php foreach($items as $i=>$it): ?>
<tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($it['item_code']) ?></td><td><?= htmlspecialchars($it['description']) ?></td><td><?= number_format($it['quantity'],2) ?></td><td><?= htmlspecialchars($it['unit']) ?></td><td><?= number_format($it['rate'],2) ?></td><td><?= number_format($it['amount'],2) ?></td></tr>
<?php endforeach; ?>
</tbody>
<tfoot><tr><th colspan="6">Estimated Total</th><th>₹ <?= number_format($total,2) ?></th></tr></tfoot>
</table>
</div>
<div class="report-actions"><a class="btn btn-primary" href="report.php?project_id=<?= $projectId ?>">Open Full Report →</a></div>
<?php endif; ?>
</section>
<?php include "includes/footer.php"; ?>
