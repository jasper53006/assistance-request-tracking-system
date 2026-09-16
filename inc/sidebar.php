<aside class="sidebar" id="sidebar">
    <div class="brand"><span class="brand-mark"><i class="bi bi-heart-fill"></i></span><span>ARTS<small>Assistance Tracking</small></span></div>
    <nav class="nav-links">
        <a class="<?= $active_page === 'dashboard' ? 'active' : ''; ?>" href="dashboard.php"><i class="bi bi-grid-1x2-fill"></i>Dashboard</a>
        <a class="<?= $active_page === 'add' ? 'active' : ''; ?>" href="add_request.php"><i class="bi bi-plus-circle-fill"></i>Add Request</a>
        <a class="<?= $active_page === 'requests' ? 'active' : ''; ?>" href="requests.php"><i class="bi bi-inbox-fill"></i>Requests</a>
        <a class="<?= $active_page === 'history' ? 'active' : ''; ?>" href="transaction_history.php"><i class="bi bi-clock-history"></i>Transaction History</a>
        <a class="<?= $active_page === 'settings' ? 'active' : ''; ?>" href="settings.php"><i class="bi bi-palette-fill"></i>Settings</a>
    </nav>
    <div class="sidebar-footer"><div class="help-note"><i class="bi bi-info-circle"></i><span>Keep every request up to date for a faster community response.</span></div><a class="logout-link" href="logout.php"><i class="bi bi-box-arrow-right"></i>Logout</a></div>
</aside>
