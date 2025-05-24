<?php
require_once 'config.php';

// Initialize errors array
$errors = array();

// Database connection with error handling
try {
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$db) {
        throw new Exception("Database connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    array_push($errors, "Database connection error. Please try again later.");
    $_SESSION['errors'] = $errors;
    header('location: login.php');
    exit();
}

// CSRF Protection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        array_push($errors, "Invalid request");
        $_SESSION['errors'] = $errors;
        header('location: login.php');
        exit();
    }
}

// Registration logic
if (isset($_POST['reg_user'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if (strlen($password_1) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }
    if ($password_1 !== $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    if (count($errors) == 0) {
        $stmt = mysqli_prepare($db, "SELECT * FROM users WHERE email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            array_push($errors, "Email already exists");
        } else {
            $password = password_hash($password_1, PASSWORD_DEFAULT);
            $user_type = 'user';
            $stmt = mysqli_prepare($db, "INSERT INTO users (email, password, user_type) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $email, $password, $user_type);
            
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['email'] = $email;
                $_SESSION['user_type'] = $user_type;
                $_SESSION['success'] = "You are now registered and logged in";
                session_regenerate_id(true);
                header('location: index.html');
                exit();
            } else {
                array_push($errors, "Registration failed. Please try again.");
            }
        }
    }
}

// Admin login
if (isset($_POST['admin_login'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $stmt = mysqli_prepare($db, "SELECT * FROM users WHERE email = ? AND user_type = 'admin' LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['user_type'] = 'admin';
                $_SESSION['success'] = "Admin login successful";
                session_regenerate_id(true);
                header('location: admin.html');
                exit();
            } else {
                array_push($errors, "Wrong email/password combination");
            }
        } else {
            array_push($errors, "Admin account not found or access denied");
        }
    }
}

// User login
if (isset($_POST['user_login'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $stmt = mysqli_prepare($db, "SELECT * FROM users WHERE email = ? AND user_type = 'user' LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['user_type'] = 'user';
                $_SESSION['success'] = "User login successful";
                session_regenerate_id(true);
                header('location: index.html');
                exit();
            } else {
                array_push($errors, "Wrong email/password combination");
            }
        } else {
            array_push($errors, "User account not found");
        }
    }
}

// Display errors
if (count($errors) > 0) {
    $_SESSION['errors'] = $errors;
    header('location: login.php');
    exit();
}

mysqli_close($db);
?>