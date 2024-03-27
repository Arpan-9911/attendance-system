<?php
  session_start();
  if(!isset($_SESSION['studentlogged'])){
    header('Location: login.php');
  }
  include "database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="uploads/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="styles/studentDashboard.css">
  <title>PGDAV | Dashboard</title>
</head>
<body>
  <?php include "header.php" ?>

  <!-- Image -->
  <div class="image"></div>

  <?php
    $studentName = $_SESSION['studentName'];
    $studentRoll = $_SESSION['studentRoll'];
    $studentEmail = $_SESSION['studentEmail'];
    $studentPhone = $_SESSION['studentPhone'];
    $select = "SELECT subject, SUM(CASE WHEN attendance = 'P' THEN 1 ELSE 0 END) AS presentDays FROM `attendance` WHERE studentName = '$studentName' AND studentRoll = '$studentRoll' GROUP BY subject";
    $result = mysqli_query($connection, $select);
    if (mysqli_num_rows($result) <= 0) {
      echo "<script>alert('No Student Data')</script>";
      echo "<script>window.location.href ='staffDashboard.php';</script>";
    }
    else {
  ?>
    <div class="all">
      <div class="details">
        <div>
          <label for="studentName">Name</label>
          <h3><?php echo $studentName ?></h3>
        </div>
        <div>
          <label for="studentRoll">Roll No.</label>
          <h3><?php echo $studentRoll?></h2>
        </div>
        <div>
          <label for="studentEmail">Email</label>
          <h3><?php echo $studentEmail?></h3>
        </div>
        <div>
          <label for="studentPhone">Phone</label>
          <h3><?php echo $studentPhone?></h3>
        </div>
      </div>
      <div class='attendanceCounts'>
        <table>
          <tr>
            <th>Subject</th>
            <th>Total Days</th>
            <th>Present Days</th>
            <th>Percentage</th>
          </tr>
  <?php
      while ($row = mysqli_fetch_assoc($result)) {
        $subject = $row['subject'];
        $presentDays = $row['presentDays'];
        $selectTotal = "SELECT * FROM `attendance` WHERE studentName = '$studentName' AND studentRoll = '$studentRoll' AND subject = '$subject'";
        $resultTotal = mysqli_query($connection, $selectTotal);
        $totatDays = mysqli_num_rows($resultTotal);
        $percent = ($presentDays*100)/$totatDays;
  ?>
        <tr>
          <td><?php echo $subject?></td>
          <td><?php echo $totatDays ?> Days</td>
          <td><?php echo $presentDays?> Days</td>
          <td><?php echo number_format($percent, 2) ?>%</td>
        </tr>
  <?php
      }
        echo "</table>";
      echo "</div>";
    }
  ?>
    </div>
  <div class="download"><a href="studentDownload.php"><i class="fa-solid fa-download"></i></a></div>

  <!-- Footer included -->
  <?php include "footer.php" ?>

</body>
</html>