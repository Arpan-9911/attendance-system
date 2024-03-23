<!-- Include database and start sessions -->
<?php
  include "database.php";
  session_start();

  // Checking user is logged as admin or not
  if (!isset($_SESSION['stafflogged'])) {
    header('Location: login.php');
  }
  // Checking data passed or not
  $staffName = $_SESSION['staffName'];
  $subject = $_GET['subject'];
  if ($subject == null) {
    header('Location: staffDashboard.php');
  }
?>
<!-- html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="uploads/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="styles/viewAttendance.css">
  <title>PGDAV | Dashboard</title>
</head>
<body>
  <!-- header included -->
  <?php include "header.php" ?>

  <!-- displaying overall attendance teaken by teacher -->
  <?php
    $query = "SELECT COUNT(DISTINCT DATE(date)) AS teacherTaken FROM `attendance` WHERE teacherName = '$staffName' AND subject = '$subject'";
    $result = mysqli_query($connection, $query);
    if ($result) {
      $row = mysqli_fetch_assoc($result);
      $count = $row['teacherTaken'];
  ?>
      <div class="subject"><?php echo $subject ?></div>
      <div class="byTeacher">Total Attendance Taken: <?php echo $count ?> Days</div>
  <?php
    }
    else {
  ?>
      echo "<script>alert('Error occurred while fetching data');</script>";
      echo "<script>window.location.href ='staffDashboard.php';</script>";
  <?php
    }
  ?>
  <!-- displaying total attendance attended by student -->
  <?php
    $present_counts = array();
    $studentQuery = "SELECT studentName, studentRoll, SUM(CASE WHEN attendance = 'P' THEN 1 ELSE 0 END) AS presentDays FROM `attendance` WHERE teacherName = '$staffName' AND subject = '$subject' GROUP BY studentName, studentRoll ORDER BY studentRoll ASC";
    $studentResult = mysqli_query($connection, $studentQuery);
    if ($studentResult) {
      echo "<div class='student'>";
      while($row = mysqli_fetch_assoc($studentResult)){
        $presentCount = $row['presentDays'];
  ?>
        <div class="byStudent"><?php echo $row['studentName'] . ", " . $row['studentRoll'] . " :- " . $presentCount . " Days, " . number_format(($presentCount*100)/$count, 2) . "%"?></div>
  <?php
      }
      echo "</div>";
    }
    else {
      echo "<script>alert('Error occurred while fetching data');</script>";
      echo "<script>window.location.href ='staffDashboard.php';</script>";
    }
  ?>
  <div class="download"><a href="staffDownload.php?subject=<?php echo $subject ?>"><i class="fa-solid fa-download"></i></a></div>
</body>
</html>