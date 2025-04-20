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
    <title>Blogweb - Discover Amazing Stories</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/index.css?v=4">
    <link href="../assets/css/bootstrap.min.css?v=1" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
    <?php include './navbar.php'; ?>

    <!-- Hero Banner -->
    <div class="image-container animate__animated animate__fadeIn">
        <img src="../assets/images/japan.jpg" alt="Blog Banner" class="img-fluid">
        <div class="text-overlay animate__animated animate__zoomIn animate__delay-1s">
            <h1>Discover Our Blog</h1>
            <p>Your Source for the Latest Insights and Stories</p>
        </div>
    </div>

    <div class="container">
        <!-- Search and Filter Section -->
        <form id="searchForm" method="GET" class="search-filter-row animate__animated animate__fadeInUp">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <h4 class="me-3 mb-0">Category</h4>
                        <select id="categorySelect" name="category" class="form-select filter-select" aria-label="Category filter">
                            <option value="" <?= isset($_GET['category']) && $_GET['category'] == '' ? 'selected' : '' ?>>All Categories</option>
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
                </div>

                <div class="col-md-4"></div>

                <div class="col-md-4">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control search-input" placeholder="Search for articles..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                        <button class="btn search-button" type="submit">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Blog Posts Grid -->
        <div id="results" class="row">
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

            $query .= " ORDER BY date DESC LIMIT $limit OFFSET $offset";

            $post = $conn->prepare($query);
            $post->execute($params);

            if ($post->rowCount() > 0) {
                $delay = 0;
                while ($fetch_post = $post->fetch(PDO::FETCH_ASSOC)) {
                    $post_id = $fetch_post['id'];
                    $comments_num = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
                    $comments_num->execute([$post_id]);
                    $final_comments_num = $comments_num->rowCount();
                    $likes_num = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
                    $likes_num->execute([$post_id]);
                    $final_likes_num = $likes_num->rowCount();
                    $delay += 0.1;
            ?>
                    <div class="col-md-6 col-lg-4 mb-4 animate__animated animate__fadeInUp" style="animation-delay: <?= $delay ?>s">
                        <div class="blog-grid">
                            <div class="blog-grid-img position-relative overflow-hidden">
                                <img alt="<?= $fetch_post['title'] ?>" src="../assets/images/posts/<?= $fetch_post['image'] ?>">
                                <div class="blog-category position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-primary"><?= $fetch_post['category'] ?></span>
                                </div>
                            </div>
                            <div class="blog-grid-text p-4">
                                <h3 class="mb-3"><a href="blogdetail.php?post_id=<?= $post_id; ?>"><?= $fetch_post['title'] ?></a></h3>
                                <p><?= substr(strip_tags($fetch_post['content']), 0, 100) . '...'; ?></p>
                                <div class="meta meta-style2">
                                    <ul>
                                        <li><a href="#"><i class="fas fa-calendar-alt"></i> <?= date('M d, Y', strtotime($fetch_post['date'])) ?></a></li>
                                        <li><a href="#"><i class="fas fa-user"></i> <?= $fetch_post['name']; ?></a></li>
                                        <li><a href="#"><i class="fas fa-comments"></i> <?= $final_comments_num ?></a></li>
                                        <li><a href="#"><i class="fas fa-heart"></i> <?= $final_likes_num ?></a></li>
                                    </ul>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="blogdetail.php?post_id=<?= $post_id; ?>" class="btn btn-outline-primary btn-sm rounded-pill">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="col-12 animate__animated animate__fadeIn">
                    <div class="empty">
                        <i class="bi bi-search fs-1 mb-3 d-block"></i>
                        <h3>No posts found!</h3>
                        <p>Try changing your search criteria or browse all categories.</p>
                        <a href="index.php" class="btn btn-primary mt-3">View All Posts</a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="row mt-5 mb-5 animate__animated animate__fadeInUp">
                <div class="col-12">
                    <div class="pagination text-small text-uppercase">
                        <ul>
                            <?php if ($page > 1): ?>
                                <li><a href="?page=<?= $page - 1; ?>&search=<?= urlencode($search); ?>&category=<?= urlencode($category); ?>"><i class="fas fa-chevron-left me-1"></i> Previous</a></li>
                            <?php endif; ?>

                            <?php
                            // Show limited page numbers with ellipsis
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);

                            if ($startPage > 1) {
                                echo '<li><a href="?page=1&search=' . urlencode($search) . '&category=' . urlencode($category) . '">1</a></li>';
                                if ($startPage > 2) {
                                    echo '<li><span>...</span></li>';
                                }
                            }

                            for ($i = $startPage; $i <= $endPage; $i++):
                            ?>
                                <li class="<?= ($i == $page) ? 'active' : ''; ?>">
                                    <a href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>&category=<?= urlencode($category); ?>"><?= $i; ?></a>
                                </li>
                            <?php
                            endfor;

                            if ($endPage < $totalPages) {
                                if ($endPage < $totalPages - 1) {
                                    echo '<li><span>...</span></li>';
                                }
                                echo '<li><a href="?page=' . $totalPages . '&search=' . urlencode($search) . '&category=' . urlencode($category) . '">' . $totalPages . '</a></li>';
                            }
                            ?>

                            <?php if ($page < $totalPages): ?>
                                <li><a href="?page=<?= $page + 1; ?>&search=<?= urlencode($search); ?>&category=<?= urlencode($category); ?>">Next <i class="fas fa-chevron-right ms-1"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>About Our Blog</h5>
                    <p>Discover amazing stories and insights from our team of writers and contributors.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Home</a></li>
                        <li><a href="#" class="text-white">Popular Posts</a></li>
                        <li><a href="#" class="text-white">Categories</a></li>
                        <li><a href="#" class="text-white">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <div class="social-icons">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-3">
            <div class="text-center">
                <p class="mb-0">&copy; <?= date('Y') ?> BlogWeb. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/index.js?v=4"></script>
    <script>
        // Initialize animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation classes to elements as they scroll into view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__fadeIn');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.blog-grid').forEach(item => {
                observer.observe(item);
            });

            // Category filter change event
            document.getElementById('categorySelect').addEventListener('change', function() {
                document.getElementById('searchForm').submit();
            });
        });
    </script>
</body>

</html>