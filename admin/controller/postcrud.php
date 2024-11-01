<?php
include '../config/dbcon.php';
session_start();

if (isset($_POST['addpost'])) {

    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);


    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../../assets/images/posts/';
    $uploadFile = $image_folder . $image;

    if (isset($image) && $_FILES['image']['error'] == 0) {

        if ($image_size > 2000000) {
            $_SESSION['message'] = 'Image size is too large!';
            header('location:../view/postmanage.php');
        } elseif (file_exists($uploadFile)) {
            $fileInfo = pathinfo($uploadFile);
            $newFileName = $fileInfo['filename'] . '_' . time() . '.' . $fileInfo['extension'];
            $image = $newFileName;
            $uploadFile = $image_folder . $newFileName;
        }


        if (move_uploaded_file($image_tmp_name, $uploadFile)) {
            $insert_post = $conn->prepare("INSERT INTO `posts` (title, content, category, image, status) VALUES (?, ?, ?, ?, ?)");
            $status = 'active';
            $insert_post->execute([$title, $content, $category, $image, $status]);
            $_SESSION['message'] = "Post added successfully!";
            header('location: ../view/postmanage.php');
        } else {
            $_SESSION['message'] = 'Possible file upload attack!';
            header('location: ../view/postmanage.php');
        }
    } else {

        $insert_post = $conn->prepare("INSERT INTO `posts` (title, content, category) VALUES (?, ?, ?)");
        $insert_post->execute([$title, $content, $category]);
        $_SESSION['message'] = "Post added successfully!";
        header('location: ../view/postmanage.php');
    }
} else if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $deleteUser = $conn->prepare('DELETE FROM posts WHERE id = :id');
    $deleteUser->bindParam(':id', $id, PDO::PARAM_INT);
    if ($deleteUser->execute()) {
        header('Location: ../view/postmanage.php');
    } else {
        echo 'Error deleting user.';
    }
}
