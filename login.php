<?php
session_start();
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            switch($user['role']) {
                case 'admin':
                    header('Location: admin_home.php');
                    break;
                case 'vet':
                    header('Location: vet_dashboard.php');
                    break;
                case 'owner':
                    header('Location: owner_dashboard.php');
                    break;
            }
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "Username not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PETRECORDS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
        }
        .logo-text {
            color: #ff6b00;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }
        .card {
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #ff6b00;
            color: white;
            text-align: center;
            padding: 20px;
            border: none;
        }
        .form-control:focus {
            border-color: #ff6b00;
            box-shadow: 0 0 0 0.2rem rgba(255,107,0,0.25);
        }
        .btn-primary {
            background-color: #ff6b00;
            border-color: #ff6b00;
        }
        .btn-primary:hover {
            background-color: #cc5500;
            border-color: #cc5500;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="logo-text">PETRECORDS</div>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Login</h4>
            </div>
            <div class="card-body p-4">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                    <div class="text-center">
                        <a href="forgot_password.php" class="text-decoration-none me-3">Forgot Password?</a>
                        <span>|</span>
                        <a href="register.php" class="text-decoration-none ms-3">Register Now</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>