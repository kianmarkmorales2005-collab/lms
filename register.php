<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name     = $_POST['name'];
  $email    = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $year     = $_POST['year'];
  $role     = $_POST['role'];

 
 // Check if email already exists
$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
if (mysqli_num_rows($check) > 0) {
  header("Location: register.html?error=An+account+with+this+email+already+exists.+Please+login+instead.");
  exit();
}
  // Insert new user
  $sql = "INSERT INTO users (name, email, password, year, role) VALUES ('$name', '$email', '$password', '$year', '$role')";

  if (mysqli_query($conn, $sql)) {
    header("Location: login.html?success=Account+created+successfully!+Please+login.");
  } else {
    header("Location: registration.html?error=Registration+failed.+Please+try+again.");
  }
  exit();
}
?>