<?php
    session_start();
    require_once 'includes/config.php';

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: login.php');
        exit();
    }

    $stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ? AND role = 'admin'");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    $pet_count = $conn->query("SELECT COUNT(*) FROM pets")->fetch_row()[0];
    $owner_count = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'owner'")->fetch_row()[0];
    $pending_appointments = $conn->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'")->fetch_row()[0];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard">
    <meta name="keywords" content="admin, dashboard, management">
    <meta name="author" content="Karl">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="img/Icon.jpg" href="favicon.ico">
    <link rel="stylesheet" href="css/admin_css.css">
</head>
<body>
    <div id="sidebar">
        <div class="logo d-flex align-items-center">
            <img src="img/Logo.png" alt="Logo" class="me-2" style="width: 40px; height: 40px;">
            <span>PETRECORDS</span>
        </div>
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
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-4">Welcome, <?php echo htmlspecialchars($admin['username']); ?></h1>
                <div class="d-flex align-items-center">
                    <!-- Notifications -->
                    <div class="dropdown me-3">
                        <a href="#" class="text-dark position-relative" data-bs-toggle="dropdown">
                            <i class="fas fa-bell fs-4"></i>
                            <?php if ($pending_appointments > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo $pending_appointments; ?>
                            </span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            <li><a class="dropdown-item" href="appointments.php">Pending Appointments (<?php echo $pending_appointments; ?>)</a></li>
                        </ul>
                    </div>

                    <!-- Profile -->
                    <div class="dropdown">
                        <a href="#" class="text-dark d-flex align-items-center" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fs-4 me-2"></i>
                            <span><?php echo htmlspecialchars($admin['username']); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <!-- Dashboard Stats -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-users me-2"></i>Total Pet Owners</h5>
                            <h2><?php echo $owner_count; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-paw me-2"></i>Registered Pets</h5>
                            <h2><?php echo $pet_count; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-calendar-check me-2"></i>Pending Appointments</h5>
                            <h2><?php echo $pending_appointments; ?></h2>
                        </div>
                    </div>
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