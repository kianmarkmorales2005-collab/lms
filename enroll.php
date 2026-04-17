<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id   = $_SESSION['user_id'];
$course_id = $_POST['course_id'];

// Check if already enrolled
$check = mysqli_query($conn,
    "SELECT * FROM enrollments 
     WHERE student_id=$user_id AND course_id=$course_id"
);

if (mysqli_num_rows($check) == 0) {
    mysqli_query($conn,
        "INSERT INTO enrollments (student_id, course_id) 
         VALUES ($user_id, $course_id)"
    );
}

header("Location: courses.php");
exit();
?>