<!-- Include database and start sessions -->
<?php
  include "database.php";
  session_start();

  // Checking user is logged as admin or not
  if (!isset($_SESSION['stafflogged'])) {
    header('Location: login.php');
  }
?>
<!-- html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="uploads/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="styles/markAttendance.css">
  <title>PGDAV | Dashboard</title>
</head>
<body>
  <!-- header included -->
  <?php include "header.php" ?>
  <!-- checking for staff is logged or not -->
  <?php
    $staffName = $_SESSION['staffName'];
    $subject = $_GET['subject'];
    if ($subject == null) {
      header('Location: staffDashboard.php');
    }
  ?>
  <!-- php for submitting attendance -->
  <?php
    if(isset($_POST['submit'])){
      $studentNames = $_POST['studentName'];
      $studentRolls = $_POST['studentRoll'];
      $studentSems = $_POST['studentSem'];
      $date = $_POST['date'];
      // Checking for already submitted or not
      $sel = "SELECT * FROM `attendance` WHERE teacherName = '$staffName' AND date = '$date' AND subject = '$subject'";
      $res = mysqli_query($connection, $sel);
      if(mysqli_num_rows($res) == 0){
        foreach($studentRolls as $studentRoll){
          $studentName = $studentNames[$studentRoll];
          $studentSem = $studentSems[$studentRoll];
          $attendance = isset($_POST['attendance'][$studentRoll]) ? "P" : "A" ;
          // Preventing duplicate entries
          $select = "SELECT * FROM `attendance` WHERE teacherName = '$staffName' AND date = '$date' AND subject = '$subject' AND studentName = '$studentName' AND studentRoll = '$studentRoll'";
          $resultSelect = mysqli_query($connection, $select);
          if(mysqli_num_rows($resultSelect) == 0){
            // Inserting attendance
            $insert = "INSERT INTO `attendance` (teacherName, subject, studentName, studentRoll, studentSem, date, attendance) VALUES ('$staffName', '$subject', '$studentName', '$studentRoll', '$studentSem', '$date', '$attendance')";
            $result = mysqli_query($connection, $insert);
          }
        }
        echo "<script>alert('Attendance Added Successfully')</script>";
        echo "<script>window.location.href ='staffDashboard.php';</script>";
      }
      else{
        echo "<script>alert('Attendance For Today Already Added')</script>";
        echo "<script>window.location.href ='staffDashboard.php';</script>";
      }
    }
  ?>
  <!-- php for selecting students opted for the subject -->
  <?php
    $sql = "SELECT * FROM `studentsubjects` WHERE (subject1 = '$subject' OR subject2 = '$subject' OR subject3 = '$subject' OR subject4 = '$subject' OR subject5 = '$subject' OR subject6 = '$subject' OR subject7 = '$subject') ORDER BY studentRoll ASC";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo "<script>alert('No Student Data')</script>";
      echo "<script>window.location.href = 'staffDashboard.php';</script>";
    }
    else {
  ?>
    <form method="post">
      <div class="fixed-col">
        <input type="text" name="subject" value="<?php echo $subject ?>" readonly>
        <input type="date" name="date" value="<?php echo date("Y-m-d") ?>">
      </div>
      <table>
        <tr>
          <th>Student</th>
          <th>Roll No.</th>
          <th>Semester</th>
          <th>P/A</th>
        </tr>
  <?php
    while ($row = mysqli_fetch_array($result)){
  ?>
        <tr>
          <td><input type="text" name="studentName[<?php echo $row['studentRoll'] ?>]" value="<?php echo $row['studentName'] ?>" readonly></td>
          <td><input type="text" name="studentRoll[]" value="<?php echo $row['studentRoll'] ?>" readonly></td>
          <td><input type="text" name="studentSem[<?php echo $row['studentRoll'] ?>]" value="<?php echo $row['studentSem'] ?>" readonly></td>
          <td><input type='checkbox' name="attendance[<?php echo $row['studentRoll'] ?>]" value='Present'></td>
        </tr>
  <?php
      }
  ?>
      </table>
      <input type='submit' name='submit' value='Submit Attendance' class="submit">
    </form>
  <?php
    }
  ?>
</body>
</html>