<?php
require_once __DIR__ . '/../inc/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../inc/validation.php';

$page_title = 'Add Request';
$active_page = 'add';
$errors = array();
$form = array(
    'full_name' => '',
    'address' => '',
    'barangay' => '',
    'contact_number' => '',
    'date_of_visit' => date('Y-m-d'),
    'purpose' => '',
    'assistance_type' => '',
    'amount_requested' => '0',
    'remarks' => ''
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $form = array_merge($form, $_POST);
    $errors = validate_request($form);

    if (!$errors) {
        $next_id = (int) $pdo->query('SELECT COALESCE(MAX(id), 0) + 1 FROM requests')->fetchColumn();
        $request_id = 'REQ-' . date('Y') . '-' . str_pad($next_id, 4, '0', STR_PAD_LEFT);
        $statement = $pdo->prepare('INSERT INTO requests (request_id, full_name, address, barangay, contact_number, date_of_visit, purpose, assistance_type, amount_requested, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $statement->execute(array(
            $request_id,
            trim($form['full_name']),
            trim($form['address']),
            trim($form['barangay']),
            trim($form['contact_number']),
            $form['date_of_visit'],
            trim($form['purpose']),
            $form['assistance_type'],
            (float) $form['amount_requested'],
            trim($form['remarks'])
        ));
        $_SESSION['success'] = 'Request successfully saved.';
        redirect('requests.php');
    }
}

include __DIR__ . '/../inc/header.php';
?>
<div class="form-intro"><div><p class="muted">Create a new assistance record</p><h2 class="section-title">Requester information</h2></div><span class="required-note">* Required fields</span></div>
<?php if ($errors): ?><div class="alert alert-error"><i class="bi bi-exclamation-circle"></i><div><?= e(implode(' ', $errors)); ?></div></div><?php endif; ?>
<form method="post" class="panel form-panel">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
    <div class="form-grid">
        <div class="field"><label for="full_name">Full Name *</label><input id="full_name" name="full_name" value="<?= e($form['full_name']); ?>" required></div>
        <div class="field"><label for="contact_number">Contact Number *</label><input id="contact_number" name="contact_number" value="<?= e($form['contact_number']); ?>" required></div>
        <div class="field field-wide"><label for="address">Address *</label><input id="address" name="address" value="<?= e($form['address']); ?>" required></div>
        <div class="field"><label for="barangay">Barangay *</label><input id="barangay" name="barangay" value="<?= e($form['barangay']); ?>" required></div>
        <div class="field"><label for="date_of_visit">Date of Visit *</label><input id="date_of_visit" type="date" name="date_of_visit" value="<?= e($form['date_of_visit']); ?>" required></div>
        <div class="field"><label for="assistance_type">Assistance Type *</label><select id="assistance_type" name="assistance_type" required><option value="">Select type</option><?php foreach (array('Financial Assistance','Medical Assistance','Educational Assistance','Solicitation','Other') as $type): ?><option <?= $form['assistance_type'] === $type ? 'selected' : ''; ?>><?= e($type); ?></option><?php endforeach; ?></select></div>
        <div class="field"><label for="amount_requested">Amount Requested</label><div class="money-input"><span>PHP</span><input id="amount_requested" type="number" min="0" step="0.01" name="amount_requested" value="<?= e($form['amount_requested']); ?>"></div></div>
        <div class="field field-wide"><label for="purpose">Purpose / Reason *</label><textarea id="purpose" name="purpose" rows="4" required><?= e($form['purpose']); ?></textarea></div>
        <div class="field field-wide"><label for="remarks">Remarks</label><textarea id="remarks" name="remarks" rows="3"><?= e($form['remarks']); ?></textarea></div>
    </div>
    <div class="form-actions"><a href="dashboard.php" class="btn btn-light">Cancel</a><button type="reset" class="btn btn-light">Clear Form</button><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Request</button></div>
</form>
<?php include __DIR__ . '/../inc/footer.php'; ?>
