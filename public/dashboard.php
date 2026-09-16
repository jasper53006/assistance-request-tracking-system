<?php
require_once __DIR__ . '/../inc/auth.php';
require_once __DIR__ . '/../config/database.php';
$page_title = 'Dashboard'; $active_page = 'dashboard';
$total = $pdo->query("SELECT COUNT(*) FROM requests")->fetchColumn();
$pending = $pdo->query("SELECT COUNT(*) FROM requests WHERE status = 'Pending'")->fetchColumn();
$approved = $pdo->query("SELECT COUNT(*) FROM requests WHERE status = 'Approved'")->fetchColumn();
$completed = $pdo->query("SELECT COUNT(*) FROM requests WHERE status = 'Completed'")->fetchColumn();
$today = $pdo->query("SELECT COUNT(*) FROM requests WHERE date_of_visit = CURDATE()")->fetchColumn();
$recent = $pdo->query('SELECT * FROM requests ORDER BY created_at DESC LIMIT 6')->fetchAll();
include __DIR__ . '/../inc/header.php';
?>
<div class="welcome-row"><div><p class="muted">Here is today&apos;s overview.</p><h2 class="section-title">Good day, <?= e(explode(' ', trim($_SESSION['full_name']))[0]); ?>.</h2></div><a href="add_request.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Request</a></div>
<div class="stats-grid"><div class="stat-card"><div class="stat-icon pink"><i class="bi bi-inbox"></i></div><span>Total Requests</span><strong><?= e($total); ?></strong><small>All recorded requests</small></div><div class="stat-card"><div class="stat-icon amber"><i class="bi bi-hourglass-split"></i></div><span>Pending</span><strong><?= e($pending); ?></strong><small>Need review</small></div><div class="stat-card"><div class="stat-icon blue"><i class="bi bi-check2-circle"></i></div><span>Approved</span><strong><?= e($approved); ?></strong><small>Ready for processing</small></div><div class="stat-card"><div class="stat-icon green"><i class="bi bi-hand-thumbs-up"></i></div><span>Completed</span><strong><?= e($completed); ?></strong><small>Successfully assisted</small></div><div class="stat-card"><div class="stat-icon violet"><i class="bi bi-calendar-event"></i></div><span>Today&apos;s Requests</span><strong><?= e($today); ?></strong><small>Visits scheduled today</small></div></div>
<section class="panel"><div class="panel-heading"><div><h2>Recent requests</h2><p class="muted">The latest records added to the system.</p></div><a class="text-link" href="requests.php">View all <i class="bi bi-arrow-up-right"></i></a></div><div class="table-wrap"><table><thead><tr><th>Requester</th><th>Assistance</th><th>Date</th><th>Status</th><th></th></tr></thead><tbody><?php foreach ($recent as $request): ?><tr><td><strong><?= e($request['full_name']); ?></strong><small class="table-subtext"><?= e($request['request_id']); ?></small></td><td><?= e($request['assistance_type']); ?></td><td><?= e(date('M d, Y', strtotime($request['date_of_visit']))); ?></td><td><span class="status <?= e(status_class($request['status'])); ?>"><?= e($request['status']); ?></span></td><td><a class="icon-link" href="view_request.php?id=<?= e($request['id']); ?>" title="View request"><i class="bi bi-arrow-up-right"></i></a></td></tr><?php endforeach; ?><?php if (!$recent): ?><tr><td colspan="5" class="empty-state">No requests recorded yet.</td></tr><?php endif; ?></tbody></table></div></section>
<?php include __DIR__ . '/../inc/footer.php'; ?>
