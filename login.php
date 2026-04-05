<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user   = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Save user data in session
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_year'] = $user['year'];
        $_SESSION['user_gwa']  = $user['gwa'];
        $_SESSION['user_role'] = $user['role'];

        header("Location: dashboard.php");
        exit();
    } else {
        echo "Wrong email or password!";
    }
}
?>
