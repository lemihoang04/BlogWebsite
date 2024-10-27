<?php
include '../config/dbcon.php';
session_start();
if (isset($_POST['adduser'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../../assets/images/avatars/';
    $uploadFile = $image_folder . $image;

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    if ($select_user->rowCount() > 0) {
        $_SESSION['message'] = 'Email already exists!';
        header('location:../view/register.php');
    } else {
        if (isset($image) && $_FILES['image']['error'] == 0) {
            if ($image_size > 2000000) {
                $_SESSION['message'] = 'images size is too large!';
                header('location:../view/usermanage.php');
            } elseif (file_exists($uploadFile)) {
                $fileInfo = pathinfo($uploadFile);
                $newFileName = $fileInfo['filename'] . '_' . time() . '.' . $fileInfo['extension'];
                $image = $newFileName;
                $uploadFile = $image_folder . $newFileName;
            }
            if (move_uploaded_file($image_tmp_name, $uploadFile)) {
                $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password,avatar) VALUES(?,?,?,?)");
                $insert_user->execute([$name, $email, $pass, $image]);
                $_SESSION['message'] = "Added user successfully";
                header('location: ../view/usermanage.php');
            } else {
                $_SESSION['message'] = 'Possible file upload attack!\n';
                header('location: ../view/usermanage.php');
            }
        } else {
            $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
            $insert_user->execute([$name, $email, $pass]);
            $_SESSION['message'] = "Added user successfully";
            header('location: ../view/usermanage.php');
        }
    }
} else if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $deleteUser = $conn->prepare('DELETE FROM users WHERE id = :id');
    $deleteUser->bindParam(':id', $id, PDO::PARAM_INT);
    if ($deleteUser->execute()) {
        header('Location: ../view/usermanage.php');
    } else {
        echo 'Error deleting user.';
    }
} else {
    echo 'Invalid request.';
}
