<?php
include '../config/dbcon.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Admin
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="g-sidenav-show  bg-gray-200">

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100"> <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none"> <span class="fs-5 d-none d-sm-inline">Menu</span> </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item"> <a href="addpost.php" class="nav-link align-middle px-0"> <i class="fs-4 bi bi-plus-square"></i> <span class="ms-1 d-none d-sm-inline">
                                    Add post</span> </a> </li>
                        <li class="nav-item"> <a href="postmanage.php" class="nav-link align-middle px-0"> <i class="fs-4 bi bi-postcard"></i> <span class="ms-1 d-none d-sm-inline">
                                    Post management</span> </a> </li>
                        <li class="nav-item"> <a href="usermanage.php" class="nav-link align-middle px-0"> <i class="fs-4 bi bi-person-gear"></i> <span class="ms-1 d-none d-sm-inline">
                                    User management</span> </a> </li>

                        <li hidden> <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle"> <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Post management</span> </a>
                            <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100"> <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1 </a> </li>
                                <li> <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2 </a> </li>
                            </ul>
                        </li>


                    </ul>
                    <hr>
                    <div class="dropdown pb-4"> <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"> <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle"> <span class="d-none d-sm-inline mx-1">loser</span> </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>