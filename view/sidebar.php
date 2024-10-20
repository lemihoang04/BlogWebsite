<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Material Dashboard 2 by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<?php include("navbar.php"); ?>

<body class="g-sidenav-show  bg-gray-200">

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100"> <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none"> <span class="fs-5 d-none d-sm-inline">Menu</span> </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item"> <a href="#" class="nav-link align-middle px-0"> <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span> </a> </li>
                        <li> <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle"> <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                            <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100"> <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1 </a> </li>
                                <li> <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2 </a> </li>
                            </ul>
                        </li>
                        <li> <a href="#" class="nav-link px-0 align-middle"> <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a> </li>
                        <li> <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle "> <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Bootstrap</span></a>
                            <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                                <li class="w-100"> <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1</a> </li>
                                <li> <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2</a> </li>
                            </ul>
                        </li>
                        <li> <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle"> <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Products</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                                <li class="w-100"> <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 1</a> </li>
                                <li> <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 2</a> </li>
                                <li> <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 3</a> </li>
                                <li> <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 4</a> </li>
                            </ul>
                        </li>
                        <li> <a href="#" class="nav-link px-0 align-middle"> <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Customers</span> </a> </li>
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