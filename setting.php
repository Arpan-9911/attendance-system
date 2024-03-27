<!-- page for changing password and mobile number by staff -->
<?php
  // Checking logged or not
  session_start();
  if(!isset($_SESSION['stafflogged'])){
    header('location: login.php');
  }
  include "database.php";
?>
<!-- html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="uploads/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="styles/setting.css">
  <title>PGDAV | Setting</title>
</head>
<body>
  <!-- header included -->
  <?php include "header.php" ?>

  <!-- Image -->
  <div class="image"></div>

  <!-- fetching data -->
  <?php
    $staffEmail = $_SESSION['staffEmail'];
    $query = "SELECT * FROM `staff` WHERE `staffEmail` = '$staffEmail'";
    $result = mysqli_query($connection, $query);
    if ($result) {
      $row = mysqli_fetch_assoc($result);
      $staffName = $row['staffName'];
      $staffPhone = $row['staffPhone'];
      $staffPassword = $row['staffPassword'];
    }
  ?>
  <!-- updating data -->
  <?php
    if(isset($_POST['update'])){
      $changedStaffPhone = $_POST['staffPhone'];
      $changedStaffPassword = $_POST['staffPassword'];
      $changedSql = "UPDATE `staff` SET staffPhone = '$changedStaffPhone', staffPassword = '$changedStaffPassword' WHERE staffEmail = '$staffEmail'";
      $changedResult = mysqli_query($connection, $changedSql);
      if ($changedResult) {
        echo "<script>alert('Data Updated Successfully')</script>";
        echo "<script>window.location.href ='staffDashboard.php';</script>";
      }
    }
  ?>
  <!-- displaying data -->
  <div class="container-all">
    <form method="post">
      <div>
        <label for="staffName">Name</label>
        <input type="text" name="staffName" class="disabled" disabled id="staffName" value="<?php echo $staffName ?>">
      </div>
      <div>
        <label for="staffEmail">Email</label>
        <input type="text" name="staffEmail" class="disabled" disabled id="staffEmail" value="<?php echo $staffEmail?>">
      </div>
      <div>
        <label for="staffPhone">Phone</label>
        <input type="text" name="staffPhone" id="staffPhone" autocomplete="off" value="<?php echo $staffPhone?>">
      </div>
      <div>
        <label for="staffPassword">Password</label>
        <input type="text" name="staffPassword" id="staffPassword" autocomplete="off" value="<?php echo $staffPassword?>">
      </div>
      <div class="update-btn">
        <input type="submit" name="update" value="Update" class="update">
      </div>
    </form>
  </div>

  <!-- Footer included -->
  <?php include "footer.php" ?>

</body>
</html>