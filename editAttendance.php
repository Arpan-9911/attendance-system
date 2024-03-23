<!-- Include database and start sessions -->
<?php
  include "database.php";
  session_start();

  // Checking user is logged as admin or not
  if (!isset($_SESSION['stafflogged'])) {
    header('Location: login.php');
  }
  // Checking details are available or not
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
  <link rel="stylesheet" href="styles/editAttendance.css">
  <title>PGDAV | Dashboard</title>
</head>
<body>
  <!-- Included header -->
  <?php include "header.php" ?>

  <!-- php for showing all the dates on which attendance was marked -->
  <?php
    $select = "SELECT DISTINCT(date) as attendanceDate FROM `attendance` WHERE teacherName = '$staffName' AND subject = '$subject' ORDER BY date DESC";
    $result = mysqli_query($connection, $select);
    if ($result) {
      echo "<div class='attendance-container'>";
      echo "<div><h2>$subject</h2></div>";
      while ($row = mysqli_fetch_array($result)){
  ?>
        <a href="dateAttendance.php?subject=<?php echo $subject ?>&date=<?php echo $row['attendanceDate'] ?>"><?php echo date_format(date_create($row['attendanceDate']), 'd-m-Y') ?></a>
  <?php
      }
      echo "</div>";
    }
  ?>
</body>
</html>