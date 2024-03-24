<!-- Include database and start sessions -->
<?php
  include "database.php";
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="uploads/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="styles/login.css">
  <title>PGDAV | Login</title>
</head>
<body>

  <!-- Header Page Included -->
  <?php include "header.php" ?>

  <!-- Image -->
  <div class="image"></div>

  <!-- php to ckeck user already logged or try to log in -->
  <?php
    // If user is already logged in
    if (isset($_SESSION['adminlogged']) || isset($_SESSION['stafflogged']) || isset($_SESSION['studentlogged'])) {
      header("location: index.php");
    }

    // If not logged in and pressed login btn
    if (isset($_POST['login'])) {
      $emailPassed = $_POST['email'];
      $email = strtolower($emailPassed);
      $password = $_POST['password'];

      // Check user is admin or not
      $selectAdmin = "SELECT * FROM `admin` WHERE adminEmail = '$email' && adminPassword = '$password'";
      $resultAdmin = mysqli_query($connection, $selectAdmin);

      // If user is admin
      if(mysqli_num_rows($resultAdmin) > 0){
        $adminRow = mysqli_fetch_array($resultAdmin);
        $_SESSION['adminlogged'] = true;
        $_SESSION['adminName'] = $adminRow['adminName'];
        $_SESSION['adminEmail'] = $email;
        $_SESSION['adminPhone'] = $adminRow['adminPhone'];
        header("location: adminDashboard.php");
      }

      // If user is not admin
      else{

        // Check user is staff or not
        $selectStaff = "SELECT * FROM `staff` WHERE staffEmail = '$email' && staffPassword = '$password'";
        $resultStaff = mysqli_query($connection, $selectStaff);

        // If user is staff
        if(mysqli_num_rows($resultStaff) > 0){
          $staffRow = mysqli_fetch_array($resultStaff);
          $_SESSION['stafflogged'] = true;
          $_SESSION['staffName'] = $staffRow['staffName'];
          $_SESSION['staffEmail'] = $email;
          $_SESSION['staffPhone'] = $staffRow['staffPhone'];
          header("location: staffDashboard.php");
        }

        // If user is neither admin nor staff
        else{
          // Check user is student or not
          $selectStudent = "SELECT * FROM `student` WHERE studentEmail = '$email' && studentPassword = '$password'";
          $resultStudent = mysqli_query($connection, $selectStudent);

          // If user is student
          if(mysqli_num_rows($resultStudent) > 0){
            $studentRow = mysqli_fetch_array($resultStudent);
            $_SESSION['studentlogged'] = true;
            $_SESSION['studentName'] = $studentRow['studentName'];
            $_SESSION['studentRoll'] = $studentRow['studentRoll'];
            $_SESSION['studentEmail'] = $email;
            $_SESSION['studentPhone'] = $studentRow['studentPhone'];
            header("location: studentDashboard.php");
          }

          // If is neither admin nor staff nor student
          else{
            echo "<script>alert('Invalid Details')</script>";
          }
        }
      }
      mysqli_close($connection);
    }
  ?>

  <!-- Login Form -->
  <div class="form-wrapper">
    <header><i class="fa-solid fa-circle-user"></i></header>
    <form method="post">
      <div class="field">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" autocomplete="off" required placeholder="Enter">
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required placeholder="Enter">
      </div>
      <div class="field-submit">
        <input type="submit" name="login" class="submit-btn" id="login" value="Login">
      </div>
    </form>
  </div>
</body>
</html>