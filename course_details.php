<?php
session_start();
include 'db.php';

// 1. Get the Course ID from the URL
if (!isset($_GET['id'])) {
    header("Location: courses.php");
    exit();
}

$course_id = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Fetch Course Info
$courseQuery = mysqli_query($conn, "SELECT * FROM courses WHERE id = $course_id");
$course = mysqli_fetch_assoc($courseQuery);

// 3. Fetch Activities for this specific Course
$activitiesQuery = mysqli_query($conn, "SELECT * FROM activities WHERE course_id = $course_id ORDER BY due_date ASC");

// 4. Fetch Materials (Query only - do not use $mat here yet!)
$materialsQuery = mysqli_query($conn, "SELECT * FROM materials WHERE course_id = $course_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($course['title']); ?> - Details</title>
    <link rel="stylesheet" href="style(1).css">
</head>
<body>
    <header>
        <a href="courses.php" style="color:white; text-decoration:none; padding: 20px; display: inline-block;">← Back to Courses</a>
        <h1 style="padding: 0 20px;"><?php echo htmlspecialchars($course['title']); ?></h1>
    </header>

    <main class="main" style="padding: 20px;">
        
        <section>
            <h2>Subject Activities</h2>
            <div class="activities-list">
                <?php if (mysqli_num_rows($activitiesQuery) > 0): ?>
                    <?php while ($act = mysqli_fetch_assoc($activitiesQuery)): ?>
                        <div class="activity-card" style="background:#fff; padding:15px; margin-bottom:10px; border-left: 5px solid #c93737; border-radius:4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            <h3><?php echo htmlspecialchars($act['title']); ?></h3>
                            <p><?php echo htmlspecialchars($act['description']); ?></p>
                            <small>Due: <?php echo date('F j, Y, g:i a', strtotime($act['due_date'])); ?></small>
                            <br><br>
                            <button class="btn" style="background:#eee;">Upload Submission</button>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No activities posted for this subject yet.</p>
                <?php endif; ?>
            </div>
        </section>

        <section style="margin-top: 40px;">
            <h2>Learning Materials</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                
                <?php if (mysqli_num_rows($materialsQuery) > 0): ?>
                    <?php while ($mat = mysqli_fetch_assoc($materialsQuery)): ?>
                        <div style="background:#f9f9f9; padding:15px; border:1px solid #ddd; border-radius:8px;">
                            <strong><?php echo htmlspecialchars($mat['title']); ?></strong><br><br>

                            <?php 
                            // Check if it is a YouTube Video
                            if ($mat['type'] == 'video' && strpos($mat['content_link'], 'youtube.com') !== false): 
                                parse_str(parse_url($mat['content_link'], PHP_URL_QUERY), $yt_vars);
                                $vid = $yt_vars['v'] ?? '';
                            ?>
                                <iframe width="100%" height="150" src="https://www.youtube.com/embed/<?php echo $vid; ?>" frameborder="0" allowfullscreen></iframe>
                            
                            <?php else: ?>
                                <a href="<?php echo htmlspecialchars($mat['content_link']); ?>" target="_blank" style="color:#c93737; font-weight:bold; text-decoration:none;">
                                    📄 View Document
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="color:gray;">No materials uploaded yet for this subject.</p>
                <?php endif; ?>
            </div>
        </section>

    </main>
</body>
</html>