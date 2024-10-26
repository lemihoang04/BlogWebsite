<?php include("sidebar.php"); ?>
<div class="col py-3 ms-3">
    <!-- Button to toggle form visibility -->


    <!-- User Management Section -->
    <div id="manage-users">
        <h2>Manage Users</h2>
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
        <!-- User Form -->
        <div id="add-users" class="d-none">
            <form id="user-form" class="mb-4">
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
                    <input type="file" class="form-control" id="user-picture" accept="image/*">
                </div>
                <button type="submit" class="btn btn-success">Add User</button>
            </form>
        </div>

        <!-- User Table -->
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
                                <button class="btn btn-warning btn-sm" onclick="editUser(<?= $user['id'] ?>)">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $user['id'] ?>)">Delete</button>
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
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>