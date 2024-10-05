<?php
include '../config/dbcon.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/blogdetail.css">
</head>

<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <div id="main-content" class="blog-page">
        <div class="container">
            <div class="row clearfix">
            <?php
         $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE status = ? AND id = ?");
         $select_posts->execute(['active', $get_id]);
         if($select_posts->rowCount() > 0){
            while($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)){
               
                $post_id = $fetch_post['id'];
                $comments_num = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                $comments_num->execute([$post_id]);
                $final_comments_num = $comments_num->rowCount();
                $likes_num = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
                $likes_num->execute([$post_id]);
                $final_likes_num = $comments_num->rowCount();
      ?>
                <div class="col-lg-8 col-md-12 left-box">
                    <div class="card single_post">
                        <div class="body">
                        <h2><?=$fetch_post['title']?></h2>
                            <div class="img-post">
                                <img class="d-block img-fluid" src="../assets/images/<?=$fetch_post['image']?>" alt="First slide">
                            </div>
                            <p><?= $fetch_post['content']; ?></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>Comments <?= $final_comments_num; ?></h2>
                        </div>
                        
                        <div class="body">
                        <?php
                    $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                    $select_comments->execute([$get_id]);
                    if($select_comments->rowCount() > 0){
                        while($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)){
                        ?>
                            <ul class="comment-reply list-unstyled">
                                <li class="row clearfix">
                                    <div class="icon-box col-md-2 col-4"><img class="img-fluid img-thumbnail" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Awesome Image"></div>
                                    <div class="text-box col-md-10 col-8 p-l-0 p-r0">
                                        <h5 class="m-b-0">Gigi Hadid </h5>
                                        <p>Why are there so many tutorials on how to decouple WordPress? how fast and easy it is to get it running (and keep it running!) and its massive ecosystem. </p>
                                        <ul class="list-inline">
                                            <li><a href="javascript:void(0);">Mar 09 2018</a></li>
                                            <li><a href="javascript:void(0);">Reply</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>Leave a reply <small>Your email address will not be published. Required fields are marked*</small></h2>
                        </div>
                        <div class="body">
                            <div class="comment-form">
                                <form class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Email Address">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-block btn-primary">SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }else{
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
                                <li><a href="javascript:void(0);">eCommerce</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>Popular Posts</h2>
                        </div>
                        <div class="body widget popular-post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="single_post">
                                        <p class="m-b-0">Apple Introduces Search Ads Basic</p>
                                        <span>jun 22, 2018</span>
                                        <div class="img-post">
                                            <img src="https://www.bootdey.com/image/280x280/87CEFA/000000" alt="Awesome Image">
                                        </div>
                                    </div>
                                    <div class="single_post">
                                        <p class="m-b-0">new rules, more cars, more races</p>
                                        <span>jun 8, 2018</span>
                                        <div class="img-post">
                                            <img src="https://www.bootdey.com/image/280x280/87CEFA/000000" alt="Awesome Image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>Instagram Post</h2>
                        </div>
                        <div class="body widget">
                            <ul class="list-unstyled instagram-plugin m-b-0">
                                <li><a href="javascript:void(0);"><img src="https://www.bootdey.com/image/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://www.bootdey.com/image/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://www.bootdey.com/image/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://www.bootdey.com/image/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://www.bootdey.com/image/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://www.bootdey.com/image/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://www.bootdey.com/image/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://www.bootdey.com/image/100x100/87CEFA/000000" alt="image description"></a></li>
                                <li><a href="javascript:void(0);"><img src="https://www.bootdey.com/image/100x100/87CEFA/000000" alt="image description"></a></li>
                            </ul>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>