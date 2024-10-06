<?php
include '../config/dbcon.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};



$comment_content = $_POST['comment_content'];
$post_id = $_POST['post_id'];
$username = $_POST['username'];

if (!empty($user_id) && !empty($comment_content) && !empty($post_id)) {
    $insert_comment = $conn->prepare("INSERT INTO `comments`(post_id, admin_id, user_id, user_name, comment) VALUES(?,?,?,?,?)");
    $insert_comment->execute([$post_id, 1, $user_id, $username, $comment_content]);

    if ($insert_comment) {
        echo '<ul class="comment-reply list-unstyled">
            <li class="row clearfix">
                <div class="icon-box col-md-2 col-4">
                    <img class="img-fluid img-thumbnail" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Awesome Image">
                </div>
                <div class="text-box col-md-10 col-8 p-l-0 p-r0">
                    <h5 class="m-b-0">' . htmlspecialchars($username) . '</h5>
                    <p>' . htmlspecialchars($comment_content) . '</p>
                    <ul class="list-inline">
                        <li><a href="javascript:void(0);">' . date('Y-m-d') . '</a></li>
                    </ul>
                </div>
            </li>
          </ul>';
    } else {
        echo 'error';
    }
}
