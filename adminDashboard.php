<!-- Include database and start sessions -->
<?php
  include "database.php";
  session_start();

  // Checking user is logged as admin or not
  if (!isset($_SESSION['adminlogged'])) {
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
  <link rel="stylesheet" href="styles/adminDashboard.css">
  <title>PGDAV | Admin</title>
</head>
<body>
  <!-- Including Header -->
  <?php include "header.php" ?>

  <!-- Image -->
  <div class="image"></div>

  <!-- Greetings -->
  <div class="greeting">
    <h1>Admin Dashboard</h1>
    <h2>Welcome "<?php echo $_SESSION['adminName'];?>"</h2>
  </div>

  <!-- Add data -->
  <h2 class="addData">Add New Data</h2>

  <!-- php for adding data -->
  <?php
  // include phpspreadsheet
  require 'vendor/autoload.php';
  use PhpOffice\PhpSpreadsheet\IOFactory;

  // php for adding teacher data
  if (isset($_POST['addTeacher-btn'])) {
    $fileName = $_FILES['addTeacher']['name'];
    $fileTmpName = $_FILES['addTeacher']['tmp_name'];

    // file extension
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = array('xlsx', 'xls');

    // checking file extension
    if (in_array($fileExtension, $allowed)) {
      $filePath = 'uploads/'.$fileName;
      move_uploaded_file($fileTmpName, $filePath);

      $spreadsheet = IOFactory::load($filePath);
      $workSheet = $spreadsheet->getActiveSheet();
      $highestRow = $workSheet->getHighestRow();

      // For each row of the sheet but not the first row
      for($row = 2; $row <= $highestRow; $row++ ){
        $staffName = $workSheet->getCell("A" . $row)->getValue();
        $staffEmail = $workSheet->getCell("B" . $row)->getValue();
        $staffPhone = $workSheet->getCell("C" . $row)->getValue();
        $staffPassword = $workSheet->getCell("D" . $row)->getValue();

        // checking the row is already exist or not
        $check = "SELECT * FROM `staff` WHERE `staffName` = '$staffName' && staffEmail='$staffEmail'";
        $checkResult = mysqli_query($connection, $check);

        // If not already exist then add the detail
        if (mysqli_num_rows($checkResult) == 0) {
          $sql = "INSERT INTO `staff` (staffName, staffEmail, staffPhone, staffPassword) VALUES ('$staffName', '$staffEmail', '$staffPhone', '$staffPassword')";
          $result = mysqli_query($connection, $sql);
        }
      }
      echo "<script>alert('Data Added Successfully')</script>";
      unlink($filePath);
    }
    else {
      echo "<script>alert('Invalid file extension');</script>";
    }
    mysqli_close($connection);
  }

  // php for adding student data
  elseif (isset($_POST['addStudent-btn'])) {
    $fileName = $_FILES['addStudent']['name'];
    $fileTmpName = $_FILES['addStudent']['tmp_name'];

    // file extension
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = array('xlsx', 'xls');

    // checking file extension
    if (in_array($fileExtension, $allowed)) {
      $filePath = 'uploads/'.$fileName;
      move_uploaded_file($fileTmpName, $filePath);

      $spreadsheet = IOFactory::load($filePath);
      $workSheet = $spreadsheet->getActiveSheet();
      $highestRow = $workSheet->getHighestRow();

      // For each row of the sheet but not the first row
      for($row = 2; $row <= $highestRow; $row++ ){
        $studentName = $workSheet->getCell("A" . $row)->getValue();
        $studentEmail = strtolower($workSheet->getCell("B" . $row)->getValue());
        $studentPhone = $workSheet->getCell("C" . $row)->getValue();
        $studentPassword = $workSheet->getCell("D" . $row)->getValue();

        // checking the row is already exist or not
        $check = "SELECT * FROM `student` WHERE `studentName` = '$studentName' && studentEmail='$studentEmail'";
        $checkResult = mysqli_query($connection, $check);

        // If already not exist then add the detail
        if (mysqli_num_rows($checkResult) == 0) {
          $sql = "INSERT INTO `student` (studentName, studentEmail, studentPhone, studentPassword) VALUES ('$studentName', '$studentEmail', '$studentPhone', '$studentPassword')";
          $result = mysqli_query($connection, $sql);
        }
      }
      echo "<script>alert('Data Added Successfully')</script>";
      unlink($filePath);
    }
    else {
      echo "<script>alert('Invalid file extension');</script>";
    }
    mysqli_close($connection);
  }
  

  // php for adding teacher timetable
  elseif (isset($_POST['teacherSubjects-btn'])) {
    $fileName = $_FILES['teacherSubjects']['name'];
    $fileTmpName = $_FILES['teacherSubjects']['tmp_name'];

    // file extension
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = array('xlsx', 'xls');

    // checking file extension
    if (in_array($fileExtension, $allowed)) {
      $filePath = 'uploads/'.$fileName;
      move_uploaded_file($fileTmpName, $filePath);

      $spreadsheet = IOFactory::load($filePath);
      $workSheet = $spreadsheet->getActiveSheet();
      $highestRow = $workSheet->getHighestRow();

      // For each row of the sheet but not the first row
      for($row = 2; $row <= $highestRow; $row++ ){
        $teacherName = $workSheet->getCell("A" . $row)->getValue();
        $teacherSubject = $workSheet->getCell("B" . $row)->getValue();
        $teacherSubSem = $workSheet->getCell("C" . $row)->getValue();

        // checking the row is already exist or not
        $check = "SELECT * FROM `teachertimetable` WHERE `teacherName` = '$teacherName' && teacherSubject='$teacherSubject' && teacherSubSem='$teacherSubSem'";
        $checkResult = mysqli_query($connection, $check);

        // If already not exist then add the detail
        if (mysqli_num_rows($checkResult) == 0) {
          $sql = "INSERT INTO `teachertimetable` (teacherName, teacherSubject, teacherSubsem) VALUES ('$teacherName', '$teacherSubject', '$teacherSubSem')";
          $result = mysqli_query($connection, $sql);
        }
      }
      echo "<script>alert('Data Added Successfully')</script>";
      unlink($filePath);
    }
    else {
      echo "<script>alert('Invalid file extension');</script>";
    }
    mysqli_close($connection);
  }

  // php for adding student subject lists
  elseif (isset($_POST['studentSubjects-btn'])) {
    $fileName = $_FILES['studentSubjects']['name'];
    $fileTmpName = $_FILES['studentSubjects']['tmp_name'];

    // file extension
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = array('xlsx', 'xls');

    // checking file extension
    if (in_array($fileExtension, $allowed)) {
      $filePath = 'uploads/'.$fileName;
      move_uploaded_file($fileTmpName, $filePath);

      $spreadsheet = IOFactory::load($filePath);
      $workSheet = $spreadsheet->getActiveSheet();
      $highestRow = $workSheet->getHighestRow();

      // For each row of the sheet but not the first row
      for($row = 2; $row <= $highestRow; $row++ ){
        $studentName = $workSheet->getCell("A" . $row)->getValue();
        $studentRoll = $workSheet->getCell("B" . $row)->getValue();
        $studentSem = $workSheet->getCell("C" . $row)->getValue();
        $studentSubject1 = $workSheet->getCell("D". $row)->getValue();
        $studentSubject2 = $workSheet->getCell("E". $row)->getValue();
        $studentSubject3 = $workSheet->getCell("F". $row)->getValue();
        $studentSubject4 = $workSheet->getCell("G". $row)->getValue();
        $studentSubject5 = $workSheet->getCell("H". $row)->getValue();
        $studentSubject6 = $workSheet->getCell("I". $row)->getValue();
        $studentSubject7 = $workSheet->getCell("J". $row)->getValue();

        // checking the row is already exist or not
        $check = "SELECT * FROM `studentsubjects` WHERE studentName = '$studentName' && studentRoll = '$studentRoll' && studentSem='$studentSem'";
        $checkResult = mysqli_query($connection, $check);

        // If already not exist then add the detail
        if (mysqli_num_rows($checkResult) == 0) {
          $sql = "INSERT INTO `studentsubjects` (studentName, studentRoll, studentSem, subject1, subject2, subject3, subject4, subject5, subject6, subject7) VALUES ('$studentName', '$studentRoll', '$studentSem', '$studentSubject1', '$studentSubject2', '$studentSubject3', '$studentSubject4', '$studentSubject5', '$studentSubject6', '$studentSubject7')";
          $result = mysqli_query($connection, $sql);
        }
      }
      echo "<script>alert('Data Added Successfully')</script>";
      unlink($filePath);
    }
    else {
      echo "<script>alert('Invalid file extension');</script>";
    }
    mysqli_close($connection);
  }
  ?>

  <!-- Forms/Actions -->
  <div class="all-forms">

    <!-- Each action -->
    <div class="each-form">
      <form method="post" enctype="multipart/form-data">
        <div>
          <label for="addTeacher">Add Teachers</label>
          <input type="file" name="addTeacher" id="addTeacher" required>
        </div>
        <input type="submit" name="addTeacher-btn" class="submit-btn" id="addTeacher-btn" value="Submit">
      </form>
    </div>

    <!-- Each action -->
    <div class="each-form">
      <form method="post" enctype="multipart/form-data">
        <div>
          <label for="addStudent">Add Students</label>
          <input type="file" name="addStudent" id="addStudent" required>
        </div>
        <input type="submit" name="addStudent-btn" class="submit-btn" id="addStudent-btn" value="Submit">
      </form>
    </div>

    <!-- Each action -->
    <div class="each-form">
      <form method="post" enctype="multipart/form-data">
        <div>
          <label for="teacherSubjects">Teacher's Subject List</label>
          <input type="file" name="teacherSubjects" id="teacherSubjects" required>
        </div>
        <input type="submit" name="teacherSubjects-btn" class="submit-btn" id="teacherSubjects-btn" value="Submit">
      </form>
    </div>

    <!-- Each action -->
    <div class="each-form">
      <form method="post" enctype="multipart/form-data">
        <div>
          <label for="studentSubjects">Student's Subject List</label>
          <input type="file" name="studentSubjects" id="studentSubjects" required>
        </div>
        <input type="submit" name="studentSubjects-btn" class="submit-btn" id="studentSubjects-btn" value="Submit">
      </form>
    </div>
  </div>
  <div class="newSem">
    <button onclick="newSem()">Start New Semester</button>
  </div>
  <script>
    function newSem() {
      if(confirm("Are you sure !!")){
        window.location.href = "newSem.php";
      }
    }
  </script>
</body>
</html>