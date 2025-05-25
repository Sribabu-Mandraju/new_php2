<?php
require_once 'config.php';

// If user is already logged in, redirect to dashboard
if (isLoggedIn()) {
    redirect('dashboard.php');
}

// Initialize errors array
$errors = array();

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $errors[] = "Please fill in all fields";
    } else {
        // Database connection
        try {
            $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$db) {
                throw new Exception("Database connection failed: " . mysqli_connect_error());
            }
            
            // Check if user exists
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['email'] = $email;
                    $_SESSION['user_type'] = $user['user_type'];
                    $_SESSION['success'] = "Login successful!";
                    redirect('dashboard.php');
                } else {
                    $errors[] = "Invalid email or password";
                }
            } else {
                $errors[] = "Invalid email or password";
            }
            
            mysqli_close($db);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $errors[] = "An error occurred. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Masked Intel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .alert {
            transition: opacity 0.5s ease-in-out;
        }
        .hide {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="geometric-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h1>LOGIN</h1>
            </div>

            <div id="alertContainer">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?php
                        echo htmlspecialchars($_SESSION['success']);
                        unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0): ?>
                    <div class="alert alert-error">
                        <?php
                        foreach ($_SESSION['errors'] as $error) {
                            echo htmlspecialchars($error) . '<br>';
                        }
                        unset($_SESSION['errors']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($errors) && count($errors) > 0): ?>
                    <div class="alert error-message">
                        <?php
                        foreach ($errors as $error) {
                            echo htmlspecialchars($error) . '<br>';
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <form class="login-form" method="post" action="login.php">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="login-buttons">
                    <button type="submit" class="login-submit-btn">
                        Login
                    </button>
                </div>
            </form>

            <div class="form-footer">
                Don't have an account? <a href="register.php">Register here</a>
            </div>

            <div class="login-footer">
                <a href="index.php" class="back-to-home">Back to Home</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Style input groups
            const inputs = document.querySelectorAll(".input-group");
            inputs.forEach((input, index) => {
                input.style.setProperty("--input-index", index);
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('hide');
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });

            // Hide alerts when clicking login buttons
            const loginForm = document.getElementById('loginForm');
            const alertContainer = document.getElementById('alertContainer');

            loginForm.addEventListener('submit', function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.classList.add('hide');
                    setTimeout(() => alert.remove(), 500);
                });
            });

            // Hide alerts when starting to type
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => {
                        alert.classList.add('hide');
                        setTimeout(() => alert.remove(), 500);
                    });
                });
            });
        });
    </script>
</body>

</html>