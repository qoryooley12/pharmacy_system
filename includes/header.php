<?php
session_start(); // ✅ VERY IMPORTANT
include_once '../config/conn.php';
var_dump($_SESSION['user']);
$user = $_SESSION['user'] ?? null;
$name = $user['name'] ?? 'Guest User';
$role = $user['role'] ?? 'User';
$image = $user['profile'] ?? ''; // profile image

function getInitials($fullName) {
    $words = explode(" ", trim($fullName));
    $first = strtoupper(substr($words[0] ?? '', 0, 1));
    $last = strtoupper(substr(end($words) ?? '', 0, 1));
    return $first . $last;
}
$initials = getInitials($name);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="description" content="POS - Bootstrap Admin Template">
<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
<meta name="author" content="Dreamguys - Bootstrap Admin Template">
<meta name="robots" content="noindex, nofollow">
<title>shaafiye</title>

<link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.jpg">

<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="shortcut icon" href="<i class='fab fa-airbnb'></i>" type="image/x-icon">

<link rel="stylesheet" href="../assets/css/animate.css">

<link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

<style>
  .btn.rounded-circle {
  width: 32px;
  height: 32px;
  padding: 0;
  text-align: center;
  vertical-align: middle;
  line-height: 32px;
}
.patient-card {
  text-align: center;
  padding: 15px;
  border-radius: 10px;
  background: #f8f9fa;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  transition: transform .2s;
  margin-bottom: 20px;
}

.patient-card:hover {
  transform: scale(1.05);
}

.patient-circle {
  width: 80px;
  height: 80px;
  margin: 0 auto 10px;
  border-radius: 50%;
  background: linear-gradient(135deg, #4e73df, #224abe);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  font-weight: bold;
}

 body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background-color: #f0f4fa;
    }

    h1 {
      color: #062169;
      text-align: center;
    }

    
</style>
<style>
  #google_translate_element {
      position: absolute;
      top: 10px;
      right: 20px;
      z-index: 9999;
    }

    /* Hide default image/icon */
    .goog-te-gadget img {
      display: none !important;
    }

    /* Remove unwanted branding badge */
    .VIpgJd-ZVi9od-ORHb-OEVmcd {
      display: none !important;
    }

    /* Beautify the dropdown */
    .goog-te-gadget-simple {
      background-color: #ffffff !important;
      color: #062169 !important;
      border: 1px solid #062169 !important;
      border-radius: 6px;
      padding: 6px 12px !important;
      font-weight: bold !important;
      cursor: pointer;
      font-size: 16px;
    }

    .goog-te-gadget-simple span {
      color: #062169 !important;
      font-weight: bold !important;
    }
</style>
<style>
.avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #16a085;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
    font-size: 16px;
}
.user-img {
    position: relative;
    display: inline-block;
}
.user-img img, .avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}
</style>


<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div id="global-loader">
<div class="whirly-loader"> </div>
</div>

<div class="main-wrapper">

<div class="header">

<div class="header-left active">
<a href="http://localhost/pharmacy_system/Admin" class="logo">
<div class="d-flex justify-content-between align-items-center">
<i class="fab fa-airbnb fs-1"></i>
  <h4 class="title">Shaafiye</h4>
</div>

<!-- <img src="../assets/img/logo.png" alt=""> -->
</a>
<a href="index.html" class="logo-small">
<img src="../assets/img/logo-small.png" alt="">
</a>
<a id="toggle_btn" href="javascript:void(0);">
</a>
</div>

<a id="mobile_btn" class="mobile_btn" href="#sidebar">
<span class="bar-icon">
<span></span>
<span></span>
<span></span>
</span>
</a>

<ul class="nav user-menu">

<li class="nav-item">
<div class="top-nav-search">
<a href="javascript:void(0);" class="responsive-search">
<i class="fa fa-search"></i>
</a>
<form action="#">
<div class="searchinputs">
<input type="text" placeholder="Search Here ...">
<div class="search-addon">
<span><img src="../assets/img/icons/closes.svg" alt="img"></span>
</div>
</div>
<a class="btn" id="searchdiv"><img src="../assets/img/icons/search.svg" alt="img"></a>
</form>
</div>
</li>


<li class="nav-item dropdown has-arrow flag-nav">
<!-- Google Translate dropdown -->
  <div id="google_translate_element"></div>
<div class="dropdown-menu dropdown-menu-right">

</div>
</li>


<li class="nav-item dropdown">
<a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
<img src="../assets/img/icons/notification-bing.svg" alt="img"> <span class="badge rounded-pill">4</span>
</a>
<div class="dropdown-menu notifications">
<div class="topnav-dropdown-header">
<span class="notification-title">Notifications</span>
<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
</div>
<div class="noti-content">
<ul class="notification-list">
<li class="notification-message">
<a href="activities.html">
<div class="media d-flex">
<span class="avatar flex-shrink-0">
<img alt="" src="../assets/img/profiles/avatar-02.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.html">
<div class="media d-flex">
<span class="avatar flex-shrink-0">
<img alt="" src="../assets/img/profiles/avatar-03.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.html">
<div class="media d-flex">
<span class="avatar flex-shrink-0">
<img alt="" src="../assets/img/profiles/avatar-06.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.html">
<div class="media d-flex">
<span class="avatar flex-shrink-0">
<img alt="" src="../assets/img/profiles/avatar-17.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
</div>
</div>
</a>
</li>
<li class="notification-message">
<a href="activities.html">
<div class="media d-flex">
<span class="avatar flex-shrink-0">
<img alt="" src="../assets/img/profiles/avatar-13.jpg">
</span>
<div class="media-body flex-grow-1">
<p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
<p class="noti-time"><span class="notification-time">2 days ago</span></p>
</div>
</div>
</a>
</li>
</ul>
</div>
<div class="topnav-dropdown-footer">
<a href="activities.html">View all Notifications</a>
</div>
</div>
</li>

<li class="nav-item dropdown has-arrow main-drop">
    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
        <span class="user-img">
            <?php if (!empty($image)) : ?>
                <img src="../assets/img/profiles/<?php echo htmlspecialchars($image); ?>" alt="">
            <?php else: ?>
                <div class="avatar-placeholder"><?php echo $initials; ?></div>
            <?php endif; ?>
            <span class="status online"></span>
        </span>
    </a>
    <div class="dropdown-menu menu-drop-user">
        <div class="profilename">
            <div class="profileset">
                <span class="user-img">
                    <?php if (!empty($image)) : ?>
                        <img src="../assets/img/profiles/<?php echo htmlspecialchars($image); ?>" alt="">
                    <?php else: ?>
                        <div class="avatar-placeholder"><?php echo $initials; ?></div>
                    <?php endif; ?>
                    <span class="status online"></span>
                </span>
                <div class="profilesets">
                    <h6><?php echo htmlspecialchars($name); ?></h6>
                    <h5><?php echo htmlspecialchars($role); ?></h5>
                </div>
            </div>
            <hr class="m-0">
            <a class="dropdown-item" href="profile.html"><i class="me-2" data-feather="user"></i> My Profile</a>
            <a class="dropdown-item" href="generalsettings.html"><i class="me-2" data-feather="settings"></i>Settings</a>
            <hr class="m-0">
            <a class="dropdown-item logout pb-0" href="logout.php"><img src="../assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
        </div>
    </div>
</li>

</ul>


<div class="dropdown mobile-user-menu">
<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
<div class="dropdown-menu dropdown-menu-right">
<a class="dropdown-item" href="profile.html">My Profile</a>
<a class="dropdown-item" href="generalsettings.html">Settings</a>
<a class="dropdown-item" href="signin.html">Logout</a>
</div>
</div>

</div>