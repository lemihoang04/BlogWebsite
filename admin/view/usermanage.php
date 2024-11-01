<?php include("sidebar.php"); ?>
<div class="col py-3 ms-3">
    <div id="manage-users">
        <h2>Manage Users</h2>
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
                <button id="toggle-user-form" class="btn btn-primary mr-2">Add User</button>
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
        <div id="add-users" class="d-none">
            <form id="user-form" class="mb-4" action="../controller/usercrud.php" method="POST" enctype="multipart/form-data">
                <div class="mb-1">
                    <label for="user-name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="user-name" placeholder="Name" required>
                </div>
                <div class="mb-1">
                    <label for="user-email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="user-email" placeholder="Email" required>
                </div>
                <div class="mb-1">
                    <label for="user-password" class="form-label">Password</label>
                    <input type="password" name="pass" class="form-control" id="user-password" placeholder="Password" required>
                </div>
                <div class="mb-1">
                    <label for="user-picture" class="form-label">Avatar</label>
                    <input type="file" name="image" class="form-control" id="user-picture">
                </div>
                <button type="submit" name="adduser" class="btn btn-success">Add User</button>
            </form>
        </div>

        <table class="table table-hover table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getuser = $conn->prepare('SELECT * FROM users');
                $getuser->execute();
                if ($getuser->rowCount() > 0) {
                    while ($user = $getuser->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['avatar'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                    data-id="<?= $user['id'] ?>"
                                    data-name="<?= $user['name'] ?>"
                                    data-email="<?= $user['email'] ?>"
                                    data-avatar="<?= $user['avatar'] ?>"
                                    onclick="editUser(this)">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="showDeleteModal(<?= $user['id'] ?>)">Delete</button>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="5">No users data</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editUserForm" action="../controller/usercrud.php" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="userName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="userName" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="userAvatar" class="form-label">Avatar</label>
                        <!-- Hiển thị ảnh avatar hiện tại -->
                        <div class="mb-2">
                            <img id="avatarPreview" src="" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;">
                        </div>
                        <!-- Cho phép chọn file ảnh mới -->
                        <input type="file" name="image" class="form-control" id="userAvatarFile" name="avatar" accept="image/*">
                    </div>
                    <input type="hidden" id="userId" name="id">

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
                Are you sure you want to delete this user?
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
    function editUser(button) {
        // Lấy dữ liệu từ các thuộc tính data-* của nút
        var userId = button.getAttribute('data-id');
        var userName = button.getAttribute('data-name');
        var userEmail = button.getAttribute('data-email');
        var userAvatar = button.getAttribute('data-avatar');

        // Gán dữ liệu vào các trường input của modal
        document.getElementById('userId').value = userId;
        document.getElementById('userName').value = userName;
        document.getElementById('userEmail').value = userEmail;
        document.getElementById('avatarPreview').src = '../../assets/images/avatars/' + userAvatar;

        // Hiển thị modal chỉnh sửa
        var editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        editUserModal.show();
    }
    document.getElementById('userAvatarFile').addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Cập nhật src của ảnh xem trước
                document.getElementById('avatarPreview').src = e.target.result;
            };
            reader.readAsDataURL(file); // Đọc file dưới dạng URL dữ liệu
        }
    });
</script>
<script>
    let deleteUserId = null;

    function showDeleteModal(id) {
        deleteUserId = id;
        $('#deleteModal').modal('show');

    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteUserId) {

            window.location.href = '../controller/usercrud.php?deleteid=' + deleteUserId; // Chuyển đến trang xóa nếu xác nhận
        }
    });
</script>
<script>
    // Toggle form visibility
    document.getElementById('toggle-user-form').addEventListener('click', function() {
        const manageUsersDiv = document.getElementById('add-users');
        if (manageUsersDiv.classList.contains('d-none')) {
            manageUsersDiv.classList.remove('d-none');
        } else {
            manageUsersDiv.classList.add('d-none');
        }
    });
</script>

</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>