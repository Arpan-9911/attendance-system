<?php
  session_start();
  if(!isset($_SESSION['adminlogged'])){
    header('Location: login.php');
  }
  include "database.php";
  $truncate1 = "TRUNCATE `teachertimetable`";
  $truncate2 = "TRUNCATE `studentsubjects`";
  $truncate3 = "TRUNCATE `attendance`";
  $result1 = mysqli_query($connection, $truncate1 . ';' . $truncate2 . ';' . $truncate3);
  echo "<script>alert('New Semester Started...');</script>";
  echo "<script>window.location.href = 'adminDashboard.php';</script>";
?>