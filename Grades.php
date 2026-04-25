<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';




if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit();
}


$user_id   = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['user_role'];

// 1. Fetch Student's specific GWA and Year from the users table
$userQuery = mysqli_query($conn, "SELECT gwa, year FROM users WHERE id = $user_id");
$userData = mysqli_fetch_assoc($userQuery);
$current_gwa = $userData['gwa'] ?? '0.00';

// 2. Fetch Grades by joining 'grades' and 'courses' tables
$gradesQuery = "SELECT c.title, g.grade 
                FROM grades g 
                JOIN courses c ON g.course_id = c.id 
                WHERE g.student_id = $user_id";
$gradesResult = mysqli_query($conn, $gradesQuery);



$enrollmentQuery = "SELECT COUNT(*) AS total FROM enrollments WHERE student_id = $user_id";
$enrollmentResult = mysqli_query($conn, $enrollmentQuery);

$totalEnrolled = mysqli_num_rows($enrollmentResult); 
$courseRows = [];
$completedCount = 0;

if ($gradesResult) {
    while ($row = mysqli_fetch_assoc($gradesResult)) {
        $courseRows[] = $row;
        if ($row['grade'] > 0) $completedCount++;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Learning Management Systems</title>
  <link rel="stylesheet" href="style(1).css" />

</head>
<body>

   


<header>

    <a href="dashboard.php" class="logo" ></a>


</header>
<aside class="sidebar">
  <button id="navToggle">☰</button>
  <nav id="myNav" class="nav-hidden">
   <div class="logo">
  <img src="kll_circle logo.png" alt="KLL Logo" class="nav-logo-img"/>
  KLL
</div>
    <nav class="nav">
      <a href="dashboard.php" class="nav-item">
        <span class="icon"></span> Dashboard
      </a>
      <a href="courses.php" class="nav-item">
        <span class="icon"></span> Courses
      </a>
      <a href="grades.php" class="nav-item active">
        <span class="icon"></span> Grades
      </a>
      <a href="profile.php" class="nav-item">
        <span class="icon"></span> Profile
      </a>
    </nav>
    <div class="nav-bottom">
      <div class="user-card">
        <div class="avatar"></div>
        <div class="user-info">
          <div class="name"><?php echo htmlspecialchars($user_name); ?></div>
          <div class="role"><?php echo htmlspecialchars($user_role); ?></div>
        </div>
      </div>
     <div class="sidebar-logo-bottom">
  <img src="kll_circle logo.png" alt="Logo" class="bottom-logo"/>
</div>
    </div>
  </nav>
</aside>
  <main class ="main">
  <section class="page active" id="grades">
    <div class="page-header">
      <h1>My Grades</h1>
      <p>Track your academic performance across all courses.</p>
    </div>

    <div class="grades-summary">
      <div class="gpa-card">
        <div style="font-size:0.76rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">Cumulative GWA</div>
        <div class=gpa-value><?php echo number_format($current_gwa, 2); ?></div>
        <div style="font-size:0.8rem;color:var(--muted);margin-top:4px">Current Standing</div>
      </div>
      
     <div class="card" style="text-align:center">
        <div style="font-size:0.76rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">Courses Completed</div>
        <div style="font-family:'Syne',sans-serif;font-size:3rem;font-weight:800;color:var(--accent3)">
            <?php echo $completedCount ?? 0; ?>
        </div>
        <div style="font-size:0.8rem;color:var(--muted);margin-top:4px">out of <?php echo $totalEnrolled ?? 0; ?> enrolled</div>
    </div>
     <div class="card" style="text-align:center">
        <div style="font-size:0.76rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">Current Year</div>
        <div style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:800;color:var(--accent2); margin-top:15px;">
            <?php echo htmlspecialchars($userData['year']); ?>
        </div>
    </div>
</div>

    <div class="card">
      <div class="section-title">Grade Breakdown by Course</div>
      <table class="grades-table">
        <thead>
          <tr>
            <th>Course</th>
            <th>Assignments</th>
            <th>Midterm</th>
            <th>Final</th>
            <th>Progress</th>
            <th>Grade</th>
          </tr>
        </thead>
        <tbody>
    <?php if (!empty($courseRows)): ?>
        <?php foreach ($courseRows as $row): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                <td>--</td> <td>--</td> <td>--</td> <td>
                    <span class="mini-progress">
                        <span class="mini-fill" style="width:<?php echo ($row['grade'] > 0) ? '100%' : '5%'; ?>; background:var(--accent); display:block;"></span>
                    </span>
                </td>
                <td>
                    <span class="grade-pill" style="background:rgba(0,0,0,0.05); color:<?php echo ($row['grade'] <= 3.0 && $row['grade'] > 0) ? '#2ecc71' : '#e74c3c'; ?>;">
                        <?php echo ($row['grade'] > 0) ? number_format($row['grade'], 2) : 'TBA'; ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6" style="text-align:center;">No grade records found.</td></tr>
    <?php endif; ?>
</tbody>
      </table>
    </div>
  </section>


</main>

<script>
const navToggle = document.getElementById("navToggle");
if (navToggle) {
  navToggle.addEventListener("click", () => {
    document.body.classList.toggle("sidebar-closed");
  });
}

// Active nav item
const navItems = document.querySelectorAll('.nav-item');
navItems.forEach(item => {
  item.addEventListener('click', function () {
    navItems.forEach(i => i.classList.remove('active'));
    this.classList.add('active');
  });
});
</script>

</body>
</html>