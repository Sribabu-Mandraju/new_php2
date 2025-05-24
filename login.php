<?php
require_once 'config.php';

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Masked Intel</title>
    <link rel="stylesheet" href="styles.css">
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

            <form class="login-form" action="connect.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="login-buttons">
                    <button type="submit" class="login-submit-btn admin-login" name="admin_login" value="admin">
                        <span>Admin Login</span>
                    </button>
                    <button type="submit" class="login-submit-btn user-login" name="user_login" value="user">
                        <span>User Login</span>
                    </button>
                </div>
            </form>

            <div class="login-footer">
                <a href="index.html" class="back-to-home">Back to Home</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputs = document.querySelectorAll(".input-group");
            inputs.forEach((input, index) => {
                input.style.setProperty("--input-index", index);
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>