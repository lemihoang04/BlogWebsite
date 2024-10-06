<?php
include '../config/dbcon.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};
// $post_id = $_POST["post_id"];
// $user_id = $_POST["user_id"];



if ($user_id != '') {

    $post_id = $_POST['post_id'];
    $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);

    $select_post_like = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ? AND user_id = ?");
    $select_post_like->execute([$post_id, $user_id]);

    if ($select_post_like->rowCount() > 0) {
        $remove_like = $conn->prepare("DELETE FROM `likes` WHERE post_id = ? AND user_id = ?");
        $remove_like->execute([$post_id, $user_id]);
        echo 'deletelike';
    } else {
        $add_like = $conn->prepare("INSERT INTO `likes`(user_id, post_id, admin_id) VALUES(?,?,?)");
        $add_like->execute([$user_id, $post_id, 1]);
        echo 'newlike';
    }
} else {
    $message[] = 'please login first!';
}
