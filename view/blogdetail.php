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
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5 class="m-b-0">
                                                                        <?= $fetch_comments['user_name'] ?>
                                                                    </h5>
                                                                </div>
                                                                <div class="col d-flex justify-content-end">
                                                                    <?php if ($user_id == $fetch_comments['user_id']) { ?>
                                                                        <span class="icon-actions">
                                                                            <a href="#" class="text-info p-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal<?= $fetch_comments['id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                                                                            <a href="#" class="text-danger p-1" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $fetch_comments['id'] ?>"><i class="fas fa-trash"></i></a>
                                                                        </span>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <p><?= $fetch_comments['comment'] ?></p>
                                                            <ul class="list-inline">
                                                                <li><a href=""><?= $fetch_comments['date'] ?></a></li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal<?= $fetch_comments['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $fetch_comments['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel<?= $fetch_comments['id'] ?>">Confirm Delete</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this comment?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <a href="../controller/comment.php?delete_id=<?= $fetch_comments['id'] ?>" class="btn btn-danger">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editModal<?= $fetch_comments['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $fetch_comments['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel<?= $fetch_comments['id'] ?>">Edit Comment</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="../controller/comment.php" method="POST">
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="comment-text-<?= $fetch_comments['id'] ?>">Comment</label>
                                                                        <textarea class="form-control" id="comment-text-<?= $fetch_comments['id'] ?>" name="comment_text"><?= $fetch_comments['comment'] ?></textarea>
                                                                        <input type="hidden" name="comment_id" value="<?= $fetch_comments['id'] ?>">
                                                                        <input type="hidden" name="post_id" value="<?= $post_id ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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
                    <form action="" action="GET">
                        <div class="card">
                            <div class="body search">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Search" aria-label="" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                    </form>
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
                                    </div>
                                <?php
                                }
                                ?>

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
                                    <button class="btn btn-primary" type="button">
                                        <i class="fa fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
            var act = "add";

            if (comment_content != "") {
                // Gửi dữ liệu bằng AJAX
                $.ajax({
                    url: '../controller/comment.php', // File PHP xử lý
                    type: 'post',
                    data: {
                        user_id: user_id,
                        comment_content: comment_content,
                        post_id: post_id,
                        username: username,
                        act: act
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