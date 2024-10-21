<?php
include '../config/dbcon.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_POST['name'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $title = $_POST[''];
    $title = filter_var($title, FILTER_SANITIZE_STRING);


    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../assets/images/' . $image;

    $select_image = $conn->prepare("SELECT * FROM `users` WHERE image = ? AND id = ?");
    $select_image->execute([$image, $user_id]);

    if (isset($image)) {
        if ($select_image->rowCount() > 0 and $image != '') {
            $message[] = 'image name repeated!';
        } elseif ($image_size > 2000000) {
            $message[] = 'images size is too large!';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $insert_post = $conn->prepare("UPDATE users SET name = ?, avatar = ? WHERE id = ?");
            $insert_post->execute([$name, $image, $user_id]);
            $message[] = 'post published!';
        }
    } else {
        $image = '';
        $insert_post = $conn->prepare("UPDATE users SET name = ?, avatar = ? WHERE id = ?");
        $insert_post->execute([$name, $image, $user_id]);
    }
}
