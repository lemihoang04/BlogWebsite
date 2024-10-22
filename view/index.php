<?php
include '../config/dbcon.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/index.css?v=6">
    <link href="../assets/css/bootstrap.min.css?v=1" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" />
    <style>

    </style>
</head>

<body>

    <?php include './navbar.php'; ?>
    <div class="image-container">
        <img src="../assets/images/japan.jpg" alt="Your Image Description" style="width:100%; height:400px; padding: 20px">
        <div class="text-overlay">
            <h1>Discover Our Blog</h1>
            <p>Your Source for the Latest Insights and Stories</p>
        </div>
    </div>
    <div class="container">
        <h1>Latest post</h1>
        <div class="row mt-n5">
            <?php
            $post = $conn->prepare("SELECT * FROM posts WHERE status= ? limit 9 ");
            $post->execute(['active']);
            if ($post->rowCount() > 0) {
                while ($fetch_post =  $post->fetch(PDO::FETCH_ASSOC)) {
                    $post_id = $fetch_post['id'];
                    $comments_num = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                    $comments_num->execute([$post_id]);
                    $final_comments_num = $comments_num->rowCount();
                    $likes_num = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
                    $likes_num->execute([$post_id]);
                    $final_likes_num = $comments_num->rowCount();
            ?>

                    <div class="col-md-6 col-lg-4 mb-5 wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <div class="blog-grid">
                            <div class="blog-grid-img position-relative"><img alt="img" style="height: 200px" src="../assets/images/<?= $fetch_post['image'] ?>"></div>
                            <div class="blog-grid-text p-4">
                                <h3 class="h5 mb-2"><a href="blogdetail.php?post_id=<?= $post_id; ?>"><?= $fetch_post['title'] ?></a></h3>
                                <p class="display-30"><?= $fetch_post['content']; ?></p>
                                <div class="meta meta-style2">
                                    <ul>
                                        <li><a href="#!"><i class="fas fa-calendar-alt"></i> <?= $fetch_post['date'] ?></a></li>
                                        <li><a href="#!"><i class="fas fa-user"></i><?= $fetch_post['name']; ?></a></li>
                                        <li><a href="#!"><i class="fas fa-comments"></i><?= $final_comments_num ?></a></li>
                                        <li><a href="#!"><i class="fas fa-thumbs-up"></i><?= $final_likes_num ?></a></li>
                                    </ul>
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
            <div class="row mt-6 wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
                <div class="col-12">
                    <div class="pagination text-small text-uppercase text-extra-dark-gray">
                        <ul>
                            <li><a href="#!"><i class="fas fa-long-arrow-alt-left me-1 d-none d-sm-inline-block"></i> Prev</a></li>
                            <li class="active"><a href="#!">1</a></li>
                            <li><a href="#!">2</a></li>
                            <li><a href="#!">3</a></li>
                            <li><a href="#!">Next <i class="fas fa-long-arrow-alt-right ms-1 d-none d-sm-inline-block"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>

</body>

</html>