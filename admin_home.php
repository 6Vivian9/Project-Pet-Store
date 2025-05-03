<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard">
    <meta name="keywords" content="admin, dashboard, management">
    <meta name="author" content="Karl">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!-- CSS -->
    <link rel="stylesheet" href="css/admin_css.css">
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar">
        <div class="logo">PETRECORDS</div>
        <div class="nav flex-column">
            <a href="admin_home.php" class="nav-link active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="pet_records.php" class="nav-link">
                <i class="fas fa-paw"></i> Pet Records
            </a>
            <a href="owners.php" class="nav-link">
                <i class="fas fa-users"></i> Owners
            </a>
            <a href="appointments.php" class="nav-link">
                <i class="fas fa-calendar-check"></i> Appointments
            </a>
            <a href="reports.php" class="nav-link">
                <i class="fas fa-chart-bar"></i> Reports
            </a>
            <a href="settings.php" class="nav-link">
                <i class="fas fa-cog"></i> Settings
            </a>
            <a href="logout.php" class="nav-link">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div id="content">
        <header class="mb-4">
            <h1 class="display-4">Dashboard</h1>
        </header>

        <main>
            <div class="card">
                <div class="card-body">
                    <?php
                        echo "Welcome to PETRECORDS Admin Panel";
                    ?>
                </div>
            </div>
        </main>

        <footer class="mt-4 text-center">
            <p class="text-muted">&copy; <?php echo date('Y'); ?> PETRECORDS. All rights reserved.</p>
        </footer>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="js/admin_js.js"></script>
</body>
</html>