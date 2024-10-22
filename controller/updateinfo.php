<?php
include '../config/dbcon.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);



    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../assets/images/' . $image;

    $select_image = $conn->prepare("SELECT * FROM `users` WHERE avatar = ? AND id = ?");
    $select_image->execute([$image, $user_id]);

    if (isset($image)) {
        if ($select_image->rowCount() > 0 and $image != '') {
            $_SESSION['message'] = 'image name repeated!';
            header('location:../view/dashboard.php');
        } elseif ($image_size > 2000000) {
            $_SESSION['message'] = 'images size is too large!';
            header('location:../view/dashboard.php');
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $update = $conn->prepare("UPDATE users SET name = ?, avatar = ? WHERE id = ?");
            $update->execute([$name, $image, $user_id]);
            $_SESSION['message'] = "Updated successfully";
            header('location:../view/dashboard.php');
        }
    } else {
        $update = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
        $update->execute([$name, $user_id]);
        $_SESSION['message'] = "Updated successfully";
        header('location:../view/dashboard.php');
    }
}
