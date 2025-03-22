<?php
include "../includes/config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['first_name'];
            header("Location:/ems/admin/dashboard.php"); // ✅ Fixed Redirect
            exit();
        } else {
            echo "<script>alert('Invalid credentials!');</script>";
        }
    } else {
        echo "<script>alert('No account found!');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/admin.css" rel="stylesheet">
    <style>
        @import url("admin.css");

.login-box {
    background: white;
    padding: 30px;
    border-radius: 12px;
    text-align: center;
    width: 400px;
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
}

.toggle-password {
    position: absolute;
    right: 15px;
    top: 38px;
    cursor: pointer;
    font-size: 18px;
    color: #6c757d;
    transition: color 0.3s;
}

.toggle-password:hover {
    color: #007bff;
}

    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="form-box shadow-lg">
            <h3 class="text-center">Admin Login</h3>
            <form method="POST">
                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
