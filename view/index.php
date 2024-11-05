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
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/index.css?v=3">
    <link href="../assets/css/bootstrap.min.css?v=1" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" />
    <style>

    </style>
</head>

<body>

    <?php include './navbar.php'; ?>
    <div class="image-container">
        <img src="../assets/images/japan.jpg" alt="Your Image Description" style="width:100%; height:400px; padding: 35px">
        <div class="text-overlay">
            <h1>Discover Our Blog</h1>
            <p>Your Source for the Latest Insights and Stories</p>
        </div>
    </div>
    <div class="container">
        <form id="searchForm" method="GET" onsubmit="myFunction(this);">
            <div class=" row mt-3 mb-3">
                <div class="col d-flex">
                    <h4 for="categorySelect" class="me-2 mb-0">Category</h4>
                    <select id="categorySelect" name="category" class="form-select rounded-5" aria-label="Default select example">
                        <option value="" <?= isset($_GET['category']) && $_GET['category'] == '' ? 'selected' : '' ?>>All</option>
                        <?php
                        $category = $conn->prepare("SELECT DISTINCT category FROM posts");
                        $category->execute();
                        while ($category_item = $category->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <option value="<?= $category_item['category'] ?>" <?= isset($_GET['category']) && $_GET['category'] == $category_item['category'] ? 'selected' : '' ?>>
                                <?= $category_item['category'] ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-4"></div>

                <div class="col">
                    <div class="input-group border rounded-5 ">
                        <input name="search" type="text" class="form-control rounded-5 border-0" placeholder="Search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" aria-label="Search">
                        <button class="input-group-text border-0 rounded-5" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div id="results" class="row mt-n5">
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $category = isset($_GET['category']) ? $_GET['category'] : '';
            $status = 'active';
            $limit = 6;


            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $page = max($page, 1);
            $offset = ($page - 1) * $limit;


            $countQuery = "SELECT COUNT(*) FROM posts WHERE status = :status";
            $countParams = ['status' => $status];

            if (!empty($search)) {
                $countQuery .= " AND (title LIKE :search)";
                $countParams['search'] = '%' . $search . '%';
            }

            if (!empty($category)) {
                $countQuery .= " AND category = :category";
                $countParams['category'] = $category;
            }

            $countStmt = $conn->prepare($countQuery);
            $countStmt->execute($countParams);
            $totalPosts = $countStmt->fetchColumn();
            $totalPages = ceil($totalPosts / $limit);


            $query = "SELECT * FROM posts WHERE status = :status";
            $params = ['status' => $status];

            if (!empty($search)) {
                $query .= " AND (title LIKE :search)";
                $params['search'] = '%' . $search . '%';
            }

            if (!empty($category)) {
                $query .= " AND category = :category";
                $params['category'] = $category;
            }

            $query .= " LIMIT $limit OFFSET $offset";


            $post = $conn->prepare($query);
            $post->execute($params);


            if ($post->rowCount() > 0) {
                while ($fetch_post = $post->fetch(PDO::FETCH_ASSOC)) {
                    $post_id = $fetch_post['id'];
                    $comments_num = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                    $comments_num->execute([$post_id]);
                    $final_comments_num = $comments_num->rowCount();
                    $likes_num = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
                    $likes_num->execute([$post_id]);
                    $final_likes_num = $likes_num->rowCount();
            ?>
                    <div class="col-md-6 col-lg-4 mb-5 wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <div class="blog-grid">
                            <div class="blog-grid-img position-relative"><img alt="img" style="height: 200px" src="../assets/images/posts/<?= $fetch_post['image'] ?>"></div>
                            <div class="blog-grid-text p-3">
                                <h3 class="h5 mb-2"><a href="blogdetail.php?post_id=<?= $post_id; ?>" title="<?= $fetch_post['title'] ?>"><?= $fetch_post['title'] ?></a></h3>
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
                echo '<p class="empty">No posts found!</p>';
            }
            ?>

            <div class="row mt-6 wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
                <div class="col-12">
                    <div class="pagination text-small text-uppercase text-extra-dark-gray p-3">
                        <ul>
                            <?php if ($page > 1): ?>
                                <li><a href="?page=<?= $page - 1; ?>&search=<?= $search; ?>&category=<?= $category; ?>"><i class="fas fa-long-arrow-alt-left me-1 d-none d-sm-inline-block"></i> Prev</a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="<?= ($i == $page) ? 'active' : ''; ?>"><a href="?page=<?= $i; ?>&search=<?= $search; ?>&category=<?= $category; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li><a href="?page=<?= $page + 1; ?>&search=<?= $search; ?>&category=<?= $category; ?>">Next <i class="fas fa-long-arrow-alt-right ms-1 d-none d-sm-inline-block"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/index.js?v=3"></script>

</body>

</html>