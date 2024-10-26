<?php include("sidebar.php"); ?>
<div class="col py-3 ms-3">
    <div id="manage-users" class="hidden">
        <h2>Manage Users</h2>
        <form id="user-form">
            <input type="text" id="user-name" placeholder="Name" required>
            <input type="email" id="user-email" placeholder="Email" required>
            <input type="password" id="user-password" placeholder="Password" required>
            <input type="file" id="user-picture" accept="image/*">
            <button type="submit">Add User</button>
        </form>
        <table id="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>