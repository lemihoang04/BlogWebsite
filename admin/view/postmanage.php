<?php include("sidebar.php"); ?>
<div class="col py-3 ms-3">
    <div id="manage-posts">
        <h2>Manage Posts</h2>
        <?php
        if (isset($_SESSION['message'])) {
        ?>
            <div class="alert alert-<?= (isset($_SESSION['alerttype']) ? $_SESSION['alerttype'] : 'primary') ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
            unset($_SESSION['message']);
        }
        ?>
        <div class="row mt-3 mb-3">
            <div class="col">
                <a class="btn btn-primary" href="addpost.php" role="button">Add Post</a>
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


        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Status</th>
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
                            <td><?= $post['status'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                    data-id="<?= $post['id'] ?>"
                                    data-title="<?= $post['title'] ?>"
                                    data-category="<?= $post['category'] ?>"
                                    data-content="<?= $post['content'] ?>"
                                    data-image="<?= $post['image'] ?>"
                                    data-status="<?= $post['status'] ?>"
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
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active">
                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
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
                            <img id="postImagePreview" src="" alt="Image" style="width: 350px; height: 200px;">
                        </div>
                        <!-- Cho phép chọn file ảnh mới -->
                        <input type="file" name="image" class="form-control" id="postImageFile" name="image" accept="image/*">
                    </div>
                    <div class="mb-1">
                        <label for="post-status" class="form-label">Status</label>
                        <select name="status" class="form-select" id="post-status">
                            <option value="active">Active</option>
                            <option value="hidden">Hidden</option>
                        </select>
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
        var postStatus = button.getAttribute('data-status');

        // Gán dữ liệu vào các trường input của modal
        document.getElementById('postId').value = postId;
        document.getElementById('postTitle').value = postTitle;
        document.getElementById('postCategory').value = postCategory;
        document.getElementById('postContent').value = postContent;
        document.getElementById('postImagePreview').src = '../../assets/images/posts/' + postImage;
        document.getElementById('post-status').value = postStatus;

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

</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>