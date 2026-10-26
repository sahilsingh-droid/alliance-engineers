<?php
require_once "config/database.php";
require_once "includes/auth.php";

$projectId = (int)($_POST['project_id'] ?? 0);

$photosStmt = $pdo->prepare("SELECT * FROM photos WHERE project_id=? ORDER BY id");
$photosStmt->execute([$projectId]);
$photos = $photosStmt->fetchAll();

$templates = [
[
'defect_type'=>'Surface / Wall Crack',
'severity'=>'Medium',
'cause'=>'Possible shrinkage, thermal movement, settlement or aging. Site verification is required.',
'risk'=>'If ignored, cracking may widen and can permit moisture ingress or deterioration of finishes.',
'recommendation'=>'Measure and document the crack, determine the cause, and carry out an engineer-approved crack repair system.',
'timeline'=>'Within 7–30 days'
],
[
'defect_type'=>'Water Seepage / Dampness',
'severity'=>'High',
'cause'=>'Possible waterproofing failure, plumbing leakage or water ingress.',
'risk'=>'Persistent moisture can damage finishes and may contribute to corrosion or material deterioration where reinforcement is affected.',
'recommendation'=>'Identify the water source, stop the ingress, repair waterproofing/leakage and restore damaged areas.',
'timeline'=>'Priority inspection'
],
[
'defect_type'=>'Concrete Spalling / Surface Deterioration',
'severity'=>'High',
'cause'=>'Possible reinforcement corrosion, moisture ingress, poor cover or aging.',
'risk'=>'Loose concrete can worsen and exposed reinforcement may deteriorate if the underlying cause remains.',
'recommendation'=>'Inspect the affected area, remove unsound concrete where appropriate, assess reinforcement and perform an engineer-approved repair.',
'timeline'=>'As soon as practical'
],
[
'defect_type'=>'Paint / Plaster Deterioration',
'severity'=>'Low',
'cause'=>'Possible age, moisture, poor adhesion or surface preparation.',
'risk'=>'May spread locally and allow further moisture-related deterioration if the source is not addressed.',
'recommendation'=>'Resolve the underlying source, remove loose material and repair/repaint the surface.',
'timeline'=>'Within 30–60 days'
]
];

foreach ($photos as $index=>$photo) {
    $check = $pdo->prepare("SELECT id FROM defects WHERE photo_id=? LIMIT 1");
    $check->execute([$photo['id']]);
    if ($check->fetch()) continue;

    $t = $templates[$index % count($templates)];

    $stmt = $pdo->prepare("INSERT INTO defects
    (photo_id,project_id,defect_type,severity,possible_cause,risk_if_untreated,recommendation,suggested_timeline)
    VALUES(?,?,?,?,?,?,?,?)");

    $stmt->execute([
        $photo['id'],$projectId,$t['defect_type'],$t['severity'],
        $t['cause'],$t['risk'],$t['recommendation'],$t['timeline']
    ]);
}

$pdo->prepare("UPDATE projects SET status='Analyzed' WHERE id=?")->execute([$projectId]);
header("Location: project.php?id=".$projectId);
exit;
?>
