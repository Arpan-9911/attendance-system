<?php
  session_start();
  if (!isset($_SESSION['adminlogged']) || !isset($_SESSION['stafflogged']) || !isset($_SESSION['studentlogged'])) {
    header("location: index.php");
  }
  unset($_SESSION['adminlogged']);
  unset($_SESSION['stafflogged']);
  unset($_SESSION['studentlogged']);
  session_destroy();
  header("location: index.php");
?>