<?php
  include "currentPage.php";
?>
<!-- Styles and CDN -->
<link rel="stylesheet" href="styles/header.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Complete header -->
<header class="header">
  <!-- Large screen -->
  <div class="container">
    <div class="logo">
      <a href="index.php">
        <div class="logo-div">
          <div>
            <img src="assets/pgdavLogo.png" alt="LOGO">
          </div>
          <div>
            <h1>P.G.D.A.V. College</h1>
            <h3>University Of Delhi</h3>
          </div>
        </div>
      </a>
    </div>
    <nav class="main-nav">
      <ul>
        <li><a href="index.php" <?php if($currentURLLower == '/' || $currentURLLower == '/index.php') echo 'class="active"' ?> >Home</a></li>
        <li><a href="about.php" <?php if($currentURLLower == '/about.php') echo 'class="active"' ?> >About</a></li>
        <li><a href="contact.php" <?php if($currentURLLower == '/contact.php') echo 'class="active"' ?> >Contact</a></li>
        <?php
          if(!isset($_SESSION['adminlogged']) && !isset($_SESSION['stafflogged']) && !isset($_SESSION['studentlogged'])){
        ?>
          <li><a href="login.php" <?php if($currentURLLower == '/login.php') echo 'class="active"' ?> >Login</a></li>
        <?php }
          elseif(isset($_SESSION['adminlogged'])){
        ?>
          <li><a href="adminDashboard.php" <?php if($currentURLLower == '/admindashboard.php') echo 'class="active"' ?> >Dashboard</a></li>
          <li><a href="logout.php" <?php if($currentURLLower == '/attendance/logout.php') echo 'class="active"' ?> >Logout</a></li>
        <?php }
          elseif(isset($_SESSION['stafflogged'])){
        ?>
          <li><a href="staffDashboard.php" <?php if($currentURLLower == '/staffdashboard.php') echo 'class="active"' ?> >Dashboard</a></li>
          <li><a href="logout.php" <?php if($currentURLLower == '/attendance/logout.php') echo 'class="active"' ?> >Logout</a></li>
          <?php }
          elseif(isset($_SESSION['studentlogged'])){
        ?>
          <li><a href="studentDashboard.php" <?php if($currentURLLower == '/studentdashboard.php') echo 'class="active"' ?> >Dashboard</a></li>
          <li><a href="logout.php" <?php if($currentURLLower == '/attendance/logout.php') echo 'class="active"' ?> >Logout</a></li>
        <?php }?>
      </ul>
    </nav>
    <!-- Small Screen -->
    <div class="small-screen-icon"><i class="fa-solid fa-bars"></i></div>
    <nav class="small-nav">
      <div>
        <a href="index.php" <?php if($currentURLLower == '/' || $currentURLLower == '/index.php') echo 'class="active"' ?> >Home</a>
      </div>
      <div>
        <a href="about.php" <?php if($currentURLLower == '/about.php') echo 'class="active"' ?> >About</a>
      </div>
      <div>
        <a href="contact.php" <?php if($currentURLLower == '/contact.php') echo 'class="active"' ?> >Contact</a>
      </div>
      <?php
        if(!isset($_SESSION['adminlogged']) && !isset($_SESSION['stafflogged']) && !isset($_SESSION['studentlogged'])){
      ?>
        <div>
          <a href="login.php" <?php if($currentURLLower == '/login.php') echo 'class="active"' ?> >Login</a>
        </div>
      <?php }
        elseif(isset($_SESSION['adminlogged'])){
      ?>
        <div>
          <a href="adminDashboard.php" <?php if($currentURLLower == '/admindashboard.php') echo 'class="active"' ?> >Dashboard</a>
        </div>
        <div>
          <a href="logout.php" <?php if($currentURLLower == '/attendance/logout.php') echo 'class="active"' ?> >Logout</a>
        </div>
      <?php }
        elseif(isset($_SESSION['stafflogged'])){
      ?>
        <div>
          <a href="staffDashboard.php" <?php if($currentURLLower == '/staffdashboard.php') echo 'class="active"' ?> >Dashboard</a>
        </div>
        <div>
          <a href="logout.php" <?php if($currentURLLower == '/attendance/logout.php') echo 'class="active"' ?> >Logout</a>
        </div>
        <?php }
        elseif(isset($_SESSION['studentlogged'])){
      ?>
        <div>
          <a href="studentDashboard.php" <?php if($currentURLLower == '/studentdashboard.php') echo 'class="active"' ?> >Dashboard</a>
        </div>
        <div>
          <a href="logout.php" <?php if($currentURLLower == '/attendance/logout.php') echo 'class="active"' ?> >Logout</a>
        </div>
      <?php }?>
    </nav>
  </div>
</header>
<!-- JS -->
<script src="javascripts/header.js"></script>