<?php
include '../config/dbcon.php';
session_start();

if (isset($_POST['login_btn'])) {
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
    $select_admin->execute([$username, $pass]);
    $row = $select_admin->fetch(PDO::FETCH_ASSOC);

    if ($select_admin->rowCount() > 0) {
        $_SESSION['admin_id'] = $row['id'];
        header('location:../view/postmanage.php');
    } else {
        $_SESSION['message'] = 'Incorrect username or password!';
        $_SESSION['alerttype'] = 'danger';
        header('location: ../view/login.php');
    }
}
