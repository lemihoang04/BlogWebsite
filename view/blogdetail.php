<?php
include '../config/dbcon.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $user->execute([$user_id]);
    $userfetch = $user->fetch(PDO::FETCH_ASSOC);
    $username = $userfetch['name'];
} else {
    $user_id = '';
};

$get_id = $_GET['post_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Blog Detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="../assets/css/bootstrap.min.css?v=7" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" />


</head>


<body>
    <link rel="stylesheet" type="text/css" href="../assets/css/blogdetail.css?v=4">
    <?php include './navbar.php'; ?>

    <div id="main-content" class="blog-page">
        <div class="container">
            <div class="row clearfix">
                <?php
                $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE status = ? AND id = ?");
                $select_posts->execute(['active', $get_id]);
                if ($select_posts->rowCount() > 0) {
                    while ($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)) {

                        $post_id = $fetch_post['id'];
                        $comments_num = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                        $comments_num->execute([$post_id]);
                        $final_comments_num = $comments_num->rowCount();
                        $likes_num = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
                        $likes_num->execute([$post_id]);
                        $final_likes_num = $likes_num->rowCount();
                        $liked_check = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ? AND user_id = ?");
                        $liked_check->execute([$post_id, $user_id]);
                        if ($liked_check->rowCount() > 0) {
                            $liked = true;
                        } else {
                            $liked = false;
                        }
                ?>
                        <div class="col-lg-8 col-md-12 left-box">
                            <div class="card single_post">
                                <div class="body">
                                    <h2><?= $fetch_post['title'] ?></h2>
                                    <div class="img-post">
                                        <img class="d-block img-fluid" src="../assets/images/posts/<?= $fetch_post['image'] ?>" alt="First slide">
                                    </div>
                                    <p><?= $fetch_post['content']; ?></p>

                                </div>
                                <button class="like <?php if ($liked == true) echo "selected" ?>" data-post-id=<?php echo $post_id; ?>>
                                    <i class="fa fa-thumbs-up fa-lg"></i>
                                    <span class="likes_count" data-count=<?php echo $final_likes_num ?>><?php echo $final_likes_num ?></span>
                                    Like
                                </button>
                            </div>
                            <div class="card">
                                <div class="header p-n2">
                                    <h2>Leave a comment</h2>
                                </div>
                                <div class="body">
                                    <div class="comment-form">
                                        <div id="commentForm" class="row clearfix">

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <textarea id="comment_content" rows="4" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                                                </div>
                                                <button id="comment_submit" class="btn btn-block btn-primary mt-2">SUBMIT</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="header">
                                    <h2>Comments <?= $final_comments_num; ?></h2>
                                </div>
                                <div class="body">
                                    <div id="comments-section">
                                        <?php
                                        $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                                        $select_comments->execute([$get_id]);
                                        if ($select_comments->rowCount() > 0) {
                                            while ($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <ul class="comment-reply list-unstyled">
                                                    <li class="row clearfix">
                                                        <div class="icon-box col-md-2 col-4">
                                                            <img class="img-fluid img-thumbnail" src="../assets/images/avatars/<?= $userfetch['avatar'] ?>" alt="Awesome Image">
                                                        </div>
                                                        <div class="text-box col-md-10 col-8 p-l-0 p-r0">
                                                            <h5 class="m-b-0"><?= $fetch_comments['user_name'] ?></h5>
                                                            <p><?= $fetch_comments['comment'] ?></p>
                                                            <ul class="list-inline">
                                                                <li><a href="javascript:void(0);"><?= $fetch_comments['date'] ?></a></li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                        <?php
                                            }
                                        } else {
                                            echo '<p class="empty">no Comment yet!</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                <?php
                    }
                } else {
                    echo '<p class="empty">no posts added yet!</p>';
                }
                ?>


                <div class="col-lg-4 col-md-12 right-box">
                    <div class="card">
                        <div class="body search">
                            <div class="input-group m-b-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>Categories</h2>
                        </div>
                        <div class="body widget">
                            <ul class="list-unstyled categories-clouds m-b-0">
                                <?php
                                $category = $conn->prepare("SELECT DISTINCT category FROM posts");
                                $category->execute();
                                while ($category_item = $category->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <li><a href="./index.php?category=<?= $category_item['category'] ?>"><?= $category_item['category'] ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>Popular Posts</h2>
                        </div>
                        <div class="body widget popular-post">
                            <div class="row">
                                <?php
                                $popularpost = $conn->prepare("SELECT *, (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.id) AS like_count FROM posts p ORDER BY like_count DESC LIMIT 2");
                                $popularpost->execute();
                                while ($ppost = $popularpost->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <div class="col-lg-12">
                                        <div class="single_post">
                                            <p class="m-b-0"><?= $ppost['title'] ?></p>
                                            <span><?= $ppost['date'] ?></span>
                                            <div class="img-post">
                                                <img src="../assets/images/posts/<?= $ppost['image'] ?>" alt="Awesome Image">
                                            </div>
                                        </div>
                                    <?php
                                }
                                    ?>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="header">
                            <h2>Email Newsletter <small>Get our products/news earlier than others, let’s get in touch.</small></h2>
                        </div>
                        <div class="body widget newsletter">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter Email">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="icon-paper-plane"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        $('.like').click(function() {
            var data = {
                post_id: <?= $post_id; ?>,
            };
            $.ajax({
                url: '../controller/like.php',
                type: 'post',
                data: data,
                success: function(response) {
                    var likes = $('.likes_count');
                    var likesCount = parseInt(likes.text());
                    var likesButton = $(".like");
                    if (response == 'newlike') {
                        likes.html(likesCount + 1);
                        likesButton.addClass('selected');
                    } else if (response == 'deletelike') {
                        likes.html(likesCount - 1);
                        likesButton.removeClass('selected');
                    }
                }
            })
        })
    </script>
    <script type="text/javascript">
        $('#comment_submit').click(function() {
            var comment_content = $('#comment_content').val();
            var username = "<?= $username; ?>";
            var post_id = "<?= $post_id; ?>";
            var user_id = "<?= $user_id; ?>";

            if (comment_content != "") {
                // Gửi dữ liệu bằng AJAX
                $.ajax({
                    url: '../controller/comment.php', // File PHP xử lý
                    type: 'post',
                    data: {
                        user_id: user_id,
                        comment_content: comment_content,
                        post_id: post_id,
                        username: username
                    },
                    success: function(response) {
                        // Thêm bình luận mới vào phần bình luận
                        $("#comments-section").prepend(response);
                        // Xóa form sau khi gửi
                    },
                    error: function() {
                        alert("Có lỗi xảy ra, vui lòng thử lại!");
                    }
                });
            } else {
                alert('Please enter a comment.');
            }
        });
    </script>
</body>

</html>