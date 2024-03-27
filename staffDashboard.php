<!-- Include database and start sessions -->
<?php
  include "database.php";
  session_start();

  // Checking user is logged as admin or not
  if (!isset($_SESSION['stafflogged'])) {
    header('Location: login.php');
  }
?>
<!-- Html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="uploads/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="styles/staffDashboard.css">
  <title>PGDAV | Dashboard</title>
</head>
<body>
  <!-- header included -->
  <?php include "header.php" ?>
  <!-- link for staff setting -->
  <a href="setting.php" class="setting"><i class="fa-solid fa-user"></i></a>

  <!-- Image -->
  <div class="image"></div>

  <!-- getting data using sessions -->
  <?php
    $staffName = $_SESSION['staffName'];
    $staffEmail = $_SESSION['staffEmail'];
    $staffPhone = $_SESSION['staffPhone'];
  ?>
  <div class="page">
    <!-- displaying data -->
    <div class="container-all">
      <?php
        $sql = "SELECT * FROM `teachertimetable` WHERE teacherName = '$staffName'";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_array($result)){
      ?>
        <div class="attendance-container">
          <h2><?php echo $row['teacherSubject'] ?></h2>
          <a href="markAttendance.php?subject=<?php echo $row['teacherSubject'] ?>"><i class="fa-solid fa-circle-check"></i> Mark Attendance</a>
          <a href="viewAttendance.php?subject=<?php echo $row['teacherSubject'] ?>"><i class="fa-solid fa-circle-check"></i> View Overall Attendance</a>
          <a href="editAttendance.php?subject=<?php echo $row['teacherSubject'] ?>"><i class="fa-solid fa-circle-check"></i> Edit Attendance</a>
        </div>
      <?php } ?>
    </div>
  </div>

  <!-- Footer included -->
  <?php include "footer.php" ?>

</body>
</html>