<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs to prevent SQL injection
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $year     = mysqli_real_escape_string($conn, $_POST['year']); // This now captures "1st Year - First Sem"
    $role     = mysqli_real_escape_string($conn, $_POST['role']);

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        header("Location: Register.html?error=An+account+with+this+email+already+exists.");
        exit();
    }

    // Insert new user - Ensure your 'users' table column is also named 'year' to match this query
    $sql = "INSERT INTO users (name, email, password, year, role) 
            VALUES ('$name', '$email', '$password', '$year', '$role')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.html?success=Account+created+successfully!+Please+login.");
    } else {
        // Log the error for your own debugging
        error_log("Registration Error: " . mysqli_error($conn));
        header("Location: Register.html?error=Registration+failed.+Please+check+database+column+length.");
    }
    exit();
}
?>