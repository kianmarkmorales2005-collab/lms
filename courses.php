<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
include 'db.php';

if (!isset($_SESSION['user_id'])){
    header("location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];  
$user_year = $_SESSION['user_year'];  
$user_role = $_SESSION['user_role'];  

// Using LIKE allows for matching "1st Year" with "1st Year - First Sem"
$coursesResult = mysqli_query($conn, "SELECT * FROM courses WHERE year_level LIKE '$user_year%' ORDER BY title ASC");

$enrolledIDs = [];
$enrolledResult = mysqli_query($conn, "SELECT course_id FROM enrollments WHERE student_id = $user_id");

if ($enrolledResult) {
    while ($row = mysqli_fetch_assoc($enrolledResult)){
        $enrolledIDs[] = $row['course_id'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Courses - TechTitan LMS</title>
  <link rel="stylesheet" href="style(1).css" />
</head>
<body>

<header>
    <a href="dashboard.php" class="logo">LMS</a>
</header>

<aside class="sidebar">
  <button id="navToggle">☰</button>

  <div class="logo">
    <img src="kll_circle logo.png" alt="KLL Logo" class="nav-logo-img"/>
    KLL
  </div>

  <nav class="nav">
    <a href="dashboard.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF'])=='dashboard.php'?'active':''; ?>">
      <span class="icon"></span> Dashboard
    </a>
    <a href="courses.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF'])=='courses.php'?'active':''; ?>">
      <span class="icon"></span> Courses
    </a>
    <a href="grades.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF'])=='grades.php'?'active':''; ?>">
      <span class="icon"></span> Grades
    </a>
    <a href="profile.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF'])=='profile.php'?'active':''; ?>">
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
  </div>
</aside>


<main class="main">
  <section class="page active" id="courses">
    <div class="page-header">
      <h1>My Courses</h1>
      <p>Showing Courses for <strong><?php echo htmlspecialchars($user_year);?></strong></p>
    </div>

    <div class="courses-filter">
      <button class="filter-btn active" onclick="filterCourses('all', this)">All Courses</button>
      <button class="filter-btn" onclick="filterCourses('enrolled', this)">In Progress</button>
      <button class="filter-btn" onclick="filterCourses('available', this)">Available</button>
    </div>

    <div class="courses-grid">
      <?php
      $colors = [
        'linear-gradient(135deg,#691414,#c93737)',
        'linear-gradient(135deg,#630f0f,#c93737)',
        'linear-gradient(135deg,#2b0d0d,#c93737)',
        'linear-gradient(135deg,#1a1200,#c93737)'
      ];
      $i = 0;

      if (mysqli_num_rows($coursesResult) > 0):
        while ($course = mysqli_fetch_assoc($coursesResult)):
          $isEnrolled = in_array($course['id'], $enrolledIDs);
          $status     = $isEnrolled ? 'enrolled' : 'available';
          $color      = $colors[$i % count($colors)];
          $i++;
      ?>
        <div class="course-card" data-status="<?php echo $status; ?>">
          <div class="course-thumb" style="background:<?php echo $color; ?>"></div>
          <div class="course-body">
            <div class="course-tag" style="color:#c93737; font-weight:bold; font-size: 0.8rem;">
              <?php echo htmlspecialchars($course['year_level']); ?>
            </div>
            <div class="course-title">
              <?php echo htmlspecialchars($course['title']); ?>
            </div>
            <div class="course-instructor">
              <?php echo htmlspecialchars($course['schedule']); ?>
            </div>
            
            <div class="progress-bar-wrap">
              <div class="progress-bar-fill" style="width:<?php echo $isEnrolled ? '25' : '0'; ?>%; background:#c93737"></div>
            </div>

            <div class="course-meta">
              <span><?php echo $isEnrolled ? 'Enrolled ✓' : 'Not enrolled'; ?></span>
            </div>

            <?php if ($isEnrolled): ?>
              <a href="course_details.php?id=<?php echo $course['id']; ?>" 
                 class="btn btn-primary" 
                 style="background:#37c94f; color:#000; text-decoration:none; display:block; text-align:center; padding:10px; border-radius:5px; font-weight:bold;">
                 Continue
              </a>
            <?php else: ?>
              <form method="POST" action="enroll.php">
                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>"/>
                <button type="submit" class="btn btn-primary" style="background:#c93737; color:#fff; width:100%;">
                  Enroll
                </button>
              </form>
            <?php endif; ?>

          </div>
        </div>
      <?php
        endwhile;
      else:
      ?>
        <div style="grid-column: 1/-1; text-align:center; padding:50px; color:gray;">
          No courses found for your current year/semester.
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>

<script>
// Sidebar Toggle
const navToggle = document.getElementById("navToggle");
if (navToggle) {
  navToggle.addEventListener("click", () => {
    document.body.classList.toggle("sidebar-closed");
  });
}

// Filtering Logic
function filterCourses(status, btn) {
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  document.querySelectorAll('.course-card').forEach(card => {
    if (status === 'all' || card.dataset.status === status) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}
</script>

</body>
</html>