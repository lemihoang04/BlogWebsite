<?php include("sidebar.php"); ?>
<div class="col py-3 ms-3">
    <div id="manage-posts">
        <h2>Manage Posts</h2>
        <?php
        if (isset($_SESSION['message'])) {
        ?>
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong></strong> <?= $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
            unset($_SESSION['message']);
        }
        ?>
        <div class="row mt-3 mb-3">
            <div class="col">
                <button id="toggle-post-form" class="btn btn-primary mr-2">Add Post</button>
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
        <div id="add-posts" class="d-none">
            <form id="post-form" class="mb-4" action="../controller/postcrud.php" method="POST" enctype="multipart/form-data">
                <div class="mb-1">
                    <label for="post-title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="post-title" placeholder="Title" required>
                </div>
                <div class="mb-1">
                    <label for="post-content" class="form-label">Content</label>
                    <textarea name="content" class="form-control" id="post-content" placeholder="Content" required></textarea>
                </div>
                <div class="mb-1">
                    <label for="post-category" class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" id="post-category" placeholder="Category" required>
                </div>
                <div class="mb-1">
                    <label for="post-image" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" id="post-image">
                </div>
                <button type="submit" name="addpost" class="btn btn-success">Add Post</button>
            </form>
        </div>

        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getpost = $conn->prepare('SELECT * FROM posts');
                $getpost->execute();
                if ($getpost->rowCount() > 0) {
                    while ($post = $getpost->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <tr>
                            <td><?= $post['id'] ?></td>
                            <td><?= $post['title'] ?></td>
                            <td><?= $post['category'] ?></td>
                            <td><?= $post['date'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                    data-id="<?= $post['id'] ?>"
                                    data-title="<?= $post['title'] ?>"
                                    data-category="<?= $post['category'] ?>"
                                    data-content="<?= $post['content'] ?>"
                                    data-image="<?= $post['image'] ?>"
                                    onclick="editPost(this)">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="showDeleteModal(<?= $post['id'] ?>)">Delete</button>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="5">No posts data</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editPostForm" action="../controller/postcrud.php" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="postTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="postTitle" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="postCategory" class="form-label">Category</label>
                        <input type="text" class="form-control" id="postCategory" name="category">
                    </div>
                    <div class="mb-3">
                        <label for="postContent" class="form-label">Content</label>
                        <textarea class="form-control" id="postContent" name="content"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="postImage" class="form-label">Image</label>
                        <!-- Hiển thị ảnh hiện tại -->
                        <div class="mb-2">
                            <img id="postImagePreview" src="" alt="Image" style="width: 100px; height: 100px;">
                        </div>
                        <!-- Cho phép chọn file ảnh mới -->
                        <input type="file" name="image" class="form-control" id="postImageFile" name="image" accept="image/*">
                    </div>
                    <input type="hidden" id="postId" name="id">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this post?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function editPost(button) {
        // Lấy dữ liệu từ các thuộc tính data-* của nút
        var postId = button.getAttribute('data-id');
        var postTitle = button.getAttribute('data-title');
        var postCategory = button.getAttribute('data-category');
        var postContent = button.getAttribute('data-content');
        var postImage = button.getAttribute('data-image');

        // Gán dữ liệu vào các trường input của modal
        document.getElementById('postId').value = postId;
        document.getElementById('postTitle').value = postTitle;
        document.getElementById('postCategory').value = postCategory;
        document.getElementById('postContent').value = postContent;
        document.getElementById('postImagePreview').src = '../../assets/images/posts/' + postImage;

        // Hiển thị modal chỉnh sửa
        var editPostModal = new bootstrap.Modal(document.getElementById('editPostModal'));
        editPostModal.show();
    }
    document.getElementById('postImageFile').addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Cập nhật src của ảnh xem trước
                document.getElementById('postImagePreview').src = e.target.result;
            };
            reader.readAsDataURL(file); // Đọc file dưới dạng URL dữ liệu
        }
    });
</script>
<script>
    let deletePostId = null;

    function showDeleteModal(id) {
        deletePostId = id;
        $('#deleteModal').modal('show');
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deletePostId) {
            window.location.href = '../controller/postcrud.php?deleteid=' + deletePostId; // Chuyển đến trang xóa nếu xác nhận
        }
    });
</script>
<script>
    // Toggle form visibility
    document.getElementById('toggle-post-form').addEventListener('click', function() {
        const managePostsDiv = document.getElementById('add-posts');
        if (managePostsDiv.classList.contains('d-none')) {
            managePostsDiv.classList.remove('d-none');
        } else {
            managePostsDiv.classList.add('d-none');
        }
    });
</script>

</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>