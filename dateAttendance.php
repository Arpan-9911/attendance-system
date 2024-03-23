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
  <link rel="stylesheet" href="styles/dateAttendance.css">
  <title>PGDAV | Dashboard</title>
</head>
<body>
  <!-- Including header -->
  <?php include "header.php" ?>

  <!-- Checking details passed or not -->
  <?php
    $staffName = $_SESSION['staffName'];
    $subject = $_GET['subject'];
    $date = $_GET['date'];
    if ($subject == null || $date == null) {
      header('Location: staffDashboard.php');
    }
  ?>
  <!-- Php for updating previous attendance -->
  <?php
    if(isset($_POST['update'])){
      $studentNames = $_POST['studentName'];
      $studentRolls = $_POST['studentRoll'];
      $studentSems = $_POST['studentSem'];
      foreach($studentRolls as $studentRoll){
        $studentName = $studentNames[$studentRoll];
        $studentSem = $studentSems[$studentRoll];
        $attendance = isset($_POST['attendance'][$studentRoll]) ? "P" : "A" ;
        $update = "UPDATE `attendance` SET attendance = '$attendance' WHERE teacherName = '$staffName' AND subject = '$subject' AND studentName = '$studentName' AND studentRoll = '$studentRoll' AND studentSem = '$studentSem' AND date = '$date'";
        $result = mysqli_query($connection, $update);
      }
      echo "<script>alert('Attendance Updated Successfully')</script>";
      echo "<script>window.location.href ='staffDashboard.php';</script>";
    }
  ?>
  <!-- php for getting the selected date attendance if already done -->
  <?php
    // if searched
    if(isset($_POST['search'])){
      $roll = $_POST['roll'];
      $sql = "SELECT * FROM `attendance` WHERE subject = '$subject' AND date = '$date' AND studentRoll = '$roll'";
      $result = mysqli_query($connection, $sql);
      if (mysqli_num_rows($result) <= 0) {
  ?>
        <form method="post">
          <div class="fixed-col">
            <input type="text" name="subject" value="<?php echo $subject ?>" readonly>
            <input type="date" name="date" value="<?php echo $date ?>" readonly>
          </div>
          <div class="search-div">
            <input type="text" name="roll" id="roll" autocomplete="off" value="<?php echo $roll ?>">
            <input type="submit" name="search" id="seacrch " value="Search">
          </div>
          <table>
            <tr>
              <th>Student</th>
              <th>Roll No.</th>
              <th>Semester</th>
              <th>P/A</th>
            </tr>
            <tr>
              <td>NA</td>
              <td>NA</td>
              <td>NA</td>
              <td>NA</td>
            </tr>
          </table>
        </form>
  <?php
      }
      else{
        $row = mysqli_fetch_array($result);
  ?>
        <form method="post">
          <div class="fixed-col">
            <input type="text" name="subject" value="<?php echo $subject ?>" readonly>
            <input type="date" name="date" value="<?php echo $date ?>" readonly>
          </div>
          <div class="search-div">
            <input type="text" name="roll" id="roll" autocomplete="off" value="<?php echo $roll ?>">
            <input type="submit" name="search" id="seacrch " value="Search">
          </div>
          <table>
            <tr>
              <th>Student</th>
              <th>Roll No.</th>
              <th>Semester</th>
              <th>P/A</th>
            </tr>
            <tr>
              <td><input type="text" name="studentName[<?php echo $row['studentRoll'] ?>]" value="<?php echo $row['studentName'] ?>" readonly></td>
              <td><input type="text" name="studentRoll[]" value="<?php echo $row['studentRoll'] ?>" readonly></td>
              <td><input type="text" name="studentSem[<?php echo $row['studentRoll'] ?>]" value="<?php echo $row['studentSem'] ?>" readonly></td>
              <td><input type='checkbox' name="attendance[<?php echo $row['studentRoll'] ?>]" <?php if($row['attendance'] == 'P') echo "checked" ?>></td>
            </tr>
          </table>
          <input type='submit' name='update' value='Update Attendance' class="submit">
        </form>
  <?php
      }
    }
    // if not searched
    else{
      $sql = "SELECT * FROM `attendance` WHERE subject = '$subject' AND date = '$date' ORDER BY studentRoll ASC";
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
          <input type="date" name="date" value="<?php echo $date ?>" readonly>
        </div>
        <div class="search-div">
          <input type="text" name="roll" autocomplete="off" id="roll" placeholder="Search by Roll No.">
          <input type="submit" name="search" id="seacrch " value="Search">
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
            <td><input type='checkbox' name="attendance[<?php echo $row['studentRoll'] ?>]" <?php if($row['attendance'] == 'P') echo "checked" ?>></td>
          </tr>
    <?php
        }
    ?>
        </table>
        <input type='submit' name='update' value='Update Attendance' class="submit">
      </form>
    <?php
      }
    }
  ?>
</body>
</html>