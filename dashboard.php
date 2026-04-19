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
$user_year = $_SESSION['user_year'];
$user_gwa  = $_SESSION['user_gwa'];
$user_role = $_SESSION['user_role'];

// ── 1. Count enrolled courses ──
$enrollCount = 0;
$enrollResult = mysqli_query($conn, "SELECT COUNT(*) AS count FROM enrollments WHERE student_id = $user_id");
if ($enrollResult) {
  $enrollRow   = mysqli_fetch_assoc($enrollResult);
  $enrollCount = $enrollRow['count'];
}

// ── 2. Get upcoming assignments for enrolled courses ──
$today = date('Y-m-d');
$assignSQL = "
  SELECT a.title, a.due_date, c.title AS course_name
  FROM assignments a
  JOIN enrollments e ON a.course_id = e.course_id
  JOIN courses c ON c.id = a.course_id
  WHERE e.student_id = $user_id
  AND a.due_date >= '$today'
  ORDER BY a.due_date ASC
";
$assignResult = mysqli_query($conn, $assignSQL);
$assignCount  = $assignResult ? mysqli_num_rows($assignResult) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LMS - Dashboard</title>
  <link rel="stylesheet" href="style(1).css"/>
</head>
<body>

<aside class="sidebar">
  <button id="navToggle">☰</button>
  <nav id="myNav" class="nav-hidden">
   <div class="logo">
  <img src="kll_circle logo.png" alt="KLL Logo" class="nav-logo-img"/>
  KLL
</div>
    <nav class="nav">
      <a href="dashboard.php" class="nav-item active">
        <span class="icon"></span> Dashboard
      </a>
      <a href="courses.php" class="nav-item">
        <span class="icon"></span> Courses
      </a>
      <a href="grades.php" class="nav-item">
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

<main class="main">
  <section class="page active" id="dashboard">

    <div class="page-header">
      <h1>Welcome, <?php echo htmlspecialchars($user_name); ?></h1>
      <p>Learning Management System</p>
    </div>

    <div class="stats-grid">
      <div class="stat-card c1">
        <div class="stat-label">Enrolled Courses</div>
        <div class="stat-value"><?php echo $enrollCount; ?></div>
        <div class="stat-sub">courses enrolled</div>
      </div>
      <div class="stat-card c2">
        <div class="stat-label">Activities Due</div>
        <div class="stat-value"><?php echo $assignCount; ?></div>
        <div class="stat-sub">upcoming deadlines</div>
      </div>
      <div class="stat-card c3">
        <div class="stat-label">Year Level</div>
        <div class="stat-value"><?php echo htmlspecialchars($user_year); ?></div>
        <div class="stat-sub"></div>
      </div>
      <div class="stat-card c4">
        <div class="stat-label">Current GWA</div>
        <div class="stat-value"><?php echo htmlspecialchars($user_gwa); ?></div>
        <div class="stat-sub">current standing</div>
      </div>
    </div>

    <div class="dashboard-grid">

      <!-- Ongoing Activity -->
      <div class="card">
        <div class="section-title">Ongoing Activity</div>
        <div class="activity-item">
          <div class="activity-dot"></div>
          <div>
            <div class="activity-text">
              Ongoing Activity <strong>Module </strong> - none
            </div>
            <div class="activity-time"></div>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-dot" style="background:var(--accent)"></div>
          <div>
            <div class="activity-text">
              Submitted <strong>Assignment </strong> - none
            </div>
            <div class="activity-time"></div>
          </div>
        </div>
      </div>

      <!-- Upcoming Deadlines -->
      <div class="card">
        <div class="section-title">Upcoming Deadlines</div>
        <?php if ($assignCount > 0): ?>
          <?php while ($assign = mysqli_fetch_assoc($assignResult)): ?>
            <?php
              $dueDate  = new DateTime($assign['due_date']);
              $today_dt = new DateTime();
              $diff     = $today_dt->diff($dueDate)->days;

              if ($diff == 0)      $badge = "Today";
              elseif ($diff == 1)  $badge = "Tomorrow";
              elseif ($diff <= 7)  $badge = $dueDate->format('l');
              else                 $badge = $dueDate->format('M d');
            ?>
            <div class="deadline-item">
              <div>
                <div style="font-weight:500">
                  <?php echo htmlspecialchars($assign['title']); ?>
                </div>
                <div style="font-size:0.74rem;color:var(--muted)">
                  <?php echo htmlspecialchars($assign['course_name']); ?>
                </div>
              </div>
              <span class="badge red"><?php echo $badge; ?></span>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div style="color:var(--muted);font-size:0.85rem;">No upcoming deadlines.</div>
        <?php endif; ?>
      </div>

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