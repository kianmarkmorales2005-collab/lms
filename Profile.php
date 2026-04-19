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

$user_id = $_SESSION['user_id'];

// 2. Fetch fresh user data from the database
$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($userQuery);

// 3. Count Enrolled Courses for the stats
$courseCountQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM enrollments WHERE student_id = $user_id");
$courseCount = mysqli_fetch_assoc($courseCountQuery)['total'];

// 4. Split name if stored as one string (optional helper)
$fullName = trim($user['name']); 

// Find the position of the last space in the name
$lastSpacePos = strrpos($fullName, ' ');

if ($lastSpacePos !== false) {
    // Everything before the last space is the First Name (e.g., "Kian Mark")
    $firstName = substr($fullName, 0, $lastSpacePos);
    // Everything after the last space is the Last Name (e.g., "Morales")
    $lastName = substr($fullName, $lastSpacePos + 1);
} else {
    // If there is no space, treat the whole thing as the first name
    $firstName = $fullName;
    $lastName = '';
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Learning Management System</title>
  <link rel="stylesheet" href="style(1).css" />

</head>
</head>
<body>

    <title> LMS </title>


<header>

    <a href="dashboard.html" class="logo" >LMS</a>


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
      <a href="grades.php" class="nav-item">
        <span class="icon"></span> Grades
      </a>
      <a href="profile.php" class="nav-item active">
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
  <section class="page active" id="profile">
    <div class="page-header">
      <h1>My Profile</h1>
      <p>Manage your personal information and academic standing.</p>
    </div>

    <div class="profile-layout">
      <div class="profile-column-left">
        <div class="profile-card-main">
          <div class="profile-avatar">
            <?php echo strtoupper(substr($firstName, 0, 1)); ?>
          </div>
          <div class="profile-name"><?php echo htmlspecialchars($user['name']); ?></div>
          <div class="profile-role">
            <?php echo htmlspecialchars($user['role']); ?> · <?php echo htmlspecialchars($user['year']); ?>
          </div>
          
          <div class="profile-stats">
            <div class="profile-stat">
              <div class="profile-stat-val"><?php echo $courseCount; ?></div>
              <div class="profile-stat-label">Courses</div>
            </div>
            <div class="profile-stat">
              <div class="profile-stat-val"><?php echo number_format($user['gwa'], 2); ?></div>
              <div class="profile-stat-label">GWA</div>
            </div>
          </div>
        </div>
      </div>

      <div class="profile-column-right" style="display:flex; flex-direction:column; gap:20px;">
        <div class="card">
          <div class="section-title">Personal Information</div>
          <form action="update_profile.php" method="POST">
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">First Name</label>
                  <input class="form-input" type="text" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>"/>
                </div>
                <div class="form-group">
                  <label class="form-label">Last Name</label>
                  <input class="form-input" type="text" name="last_name" value="<?php echo htmlspecialchars($lastName); ?>"/>
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Email Address</label>
                <input class="form-input" type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"/>
              </div>

              <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Year Level</label>
                    <input class="form-input" type="text" name="year" value="<?php echo htmlspecialchars($user['year']); ?>" placeholder="e.g. 2nd Year - First Sem"/>
                </div>
                <div class="form-group">
                    <label class="form-label">Current GWA</label>
                    <input class="form-input" type="number" step="0.01" name="gwa" value="<?php echo htmlspecialchars($user['gwa']); ?>"/>
                </div>
              </div>

              <button class="btn btn-primary" type="submit" style="background: #c93737; width: auto; padding: 12px 30px;">
                Update Profile
              </button>
          </form>
        </div>
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