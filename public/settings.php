<?php
require_once __DIR__ . '/../inc/auth.php';
require_once __DIR__ . '/../config/database.php';

$page_title = 'Settings';
$active_page = 'settings';
$message = $_SESSION['settings_message'] ?? '';
unset($_SESSION['settings_message']);
$current_theme = current_theme();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $selected_theme = normalize_theme($_POST['theme'] ?? 'green');

    $statement = $pdo->prepare('UPDATE users SET theme = ? WHERE id = ?');
    $statement->execute(array($selected_theme, $_SESSION['user_id']));

    $_SESSION['theme'] = $selected_theme;
    $_SESSION['settings_message'] = 'Theme saved successfully.';
    redirect('settings.php');
}

include __DIR__ . '/../inc/header.php';
?>
<div class="welcome-row">
    <div>
        <p class="muted">Adjust the workspace look and feel</p>
        <h2 class="section-title">Appearance settings</h2>
    </div>
</div>

<?php if ($message): ?>
<div class="alert alert-success"><i class="bi bi-check-circle"></i><?= e($message); ?></div>
<?php endif; ?>

<section class="panel form-panel">
    <form method="post" class="theme-form">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">

        <div class="theme-options">
            <?php
            $theme_palette = array(
                'green' => array('bg' => '#F0FDF4', 'primary' => '#16A34A', 'dark' => '#166534', 'soft' => '#DCFCE7'),
                'blue' => array('bg' => '#EFF6FF', 'primary' => '#2563EB', 'dark' => '#1D4ED8', 'soft' => '#DBEAFE'),
                'purple' => array('bg' => '#FAF5FF', 'primary' => '#7C3AED', 'dark' => '#5B21B6', 'soft' => '#EDE9FE'),
                'orange' => array('bg' => '#FFF7ED', 'primary' => '#EA580C', 'dark' => '#9A3412', 'soft' => '#FFEDD5'),
                'red' => array('bg' => '#FFF7F7', 'primary' => '#DC2626', 'dark' => '#991B1B', 'soft' => '#FEE2E2'),
                'teal' => array('bg' => '#F0FDFA', 'primary' => '#0D9488', 'dark' => '#115E59', 'soft' => '#CCFBF1'),
                'dark' => array('bg' => '#111827', 'primary' => '#22C55E', 'dark' => '#15803D', 'soft' => '#1F3A2A')
            );
            ?>
            <?php foreach (theme_options() as $value => $label): ?>
                <?php $colors = $theme_palette[$value] ?? $theme_palette['green']; ?>
                <label class="theme-option">
                    <input type="radio" name="theme" value="<?= e($value); ?>" <?= $current_theme === $value ? 'checked' : ''; ?>>
                    <div class="theme-option-preview" style="--theme-preview-bg: <?= e($colors['bg']); ?>; --theme-preview-primary: <?= e($colors['primary']); ?>; --theme-preview-dark: <?= e($colors['dark']); ?>; --theme-preview-soft: <?= e($colors['soft']); ?>;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="theme-option-copy">
                        <strong><?= e($label); ?></strong>
                        <small><?= e($value === 'dark' ? 'Night mode' : 'Balanced palette'); ?></small>
                    </div>
                    <span class="theme-option-check"><i class="bi bi-check-circle-fill"></i></span>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="settings-actions">
            <button class="btn btn-primary" type="submit"><i class="bi bi-floppy"></i> Save theme</button>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../inc/footer.php'; ?>
