<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        #sidebar {
            width: 200px;
            height: 100vh;
            background-color: #333;
            color: white;
            padding: 20px;
        }

        #sidebar h2 {
            margin-top: 0;
        }

        #sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        #sidebar li {
            margin-bottom: 10px;
        }

        #sidebar a {
            color: white;
            text-decoration: none;
        }

        #content {
            flex-grow: 1;
            padding: 20px;
        }

        .hidden {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-bottom: 20px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="#" onclick="showSection('create-post')">Create Post</a></li>
            <li><a href="#" onclick="showSection('manage-posts')">Manage Posts</a></li>
            <li><a href="#" onclick="showSection('manage-users')">Manage Users</a></li>
        </ul>
    </div>
    <div id="content">
        <div id="create-post" class="hidden">
            <h2>Create Post</h2>
            <form id="post-form">
                <input type="text" id="post-title" placeholder="Title" required>
                <textarea id="post-content" placeholder="Content" required></textarea>
                <input type="text" id="post-category" placeholder="Category" required>
                <input type="file" id="post-image" accept="image/*">
                <select id="post-status">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
                <button type="submit">Create Post</button>
            </form>
        </div>
        <div id="manage-posts" class="hidden">
            <h2>Manage Posts</h2>
            <table id="posts-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Admin ID</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
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

    <script>
        // Sample data (replace with actual data fetching in a real application)
        let posts = [
            { id: 1, admin_id: 1, name: "Admin", title: "First Post", content: "This is the first post.", category: "General", image: "image1.jpg", date: "2023-05-01", status: "published" },
            { id: 2, admin_id: 1, name: "Admin", title: "Second Post", content: "This is the second post.", category: "Technology", image: "image2.jpg", date: "2023-05-02", status: "draft" }
        ];

        let users = [
            { id: 1, name: "Admin User", email: "admin@example.com", picture: "admin.jpg" },
            { id: 2, name: "Regular User", email: "user@example.com", picture: "user.jpg" }
        ];

        function showSection(sectionId) {
            document.querySelectorAll('#content > div').forEach(div => div.classList.add('hidden'));
            document.getElementById(sectionId).classList.remove('hidden');
            if (sectionId === 'manage-posts') {
                renderPosts();
            } else if (sectionId === 'manage-users') {
                renderUsers();
            }
        }

        function renderPosts() {
            const tbody = document.querySelector('#posts-table tbody');
            tbody.innerHTML = '';
            posts.forEach(post => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${post.id}</td>
                    <td>${post.admin_id}</td>
                    <td>${post.name}</td>
                    <td>${post.title}</td>
                    <td>${post.content.substring(0, 50)}...</td>
                    <td>${post.category}</td>
                    <td>${post.image}</td>
                    <td>${post.date}</td>
                    <td>${post.status}</td>
                    <td>
                        <button onclick="updatePostStatus(${post.id})">Update Status</button>
                        <button onclick="editPost(${post.id})">Edit</button>
                        <button onclick="deletePost(${post.id})">Delete</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function renderUsers() {
            const tbody = document.querySelector('#users-table tbody');
            tbody.innerHTML = '';
            users.forEach(user => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.picture}</td>
                    <td>
                        <button onclick="editUser(${user.id})">Edit</button>
                        <button onclick="deleteUser(${user.id})">Delete</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function updatePostStatus(id) {
            const post = posts.find(p => p.id === id);
            post.status = post.status === 'published' ? 'draft' : 'published';
            renderPosts();
        }

        function editPost(id) {
            const post = posts.find(p => p.id === id);
            // Populate form with post data for editing
            document.getElementById('post-title').value = post.title;
            document.getElementById('post-content').value = post.content;
            document.getElementById('post-category').value = post.category;
            document.getElementById('post-status').value = post.status;
            showSection('create-post');
        }

        function deletePost(id) {
            posts = posts.filter(p => p.id !== id);
            renderPosts();
        }

        function editUser(id) {
            const user = users.find(u => u.id === id);
            // Populate form with user data for editing
            document.getElementById('user-name').value = user.name;
            document.getElementById('user-email').value = user.email;
            // Note: We don't populate the password field for security reasons
        }

        function deleteUser(id) {
            users = users.filter(u => u.id !== id);
            renderUsers();
        }

        document.getElementById('post-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const newPost = {
                id: posts.length + 1,
                admin_id: 1, // Assuming current admin id is 1
                name: "Admin", // Assuming current admin name
                title: document.getElementById('post-title').value,
                content: document.getElementById('post-content').value,
                category: document.getElementById('post-category').value,
                image: document.getElementById('post-image').files[0] ? document.getElementById('post-image').files[0].name : '',
                date: new Date().toISOString().split('T')[0],
                status: document.getElementById('post-status').value
            };
            posts.push(newPost);
            this.reset();
            showSection('manage-posts');
        });

        document.getElementById('user-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const newUser = {
                id: users.length + 1,
                name: document.getElementById('user-name').value,
                email: document.getElementById('user-email').value,
                picture: document.getElementById('user-picture').files[0] ? document.getElementById('user-picture').files[0].name : ''
            };
            users.push(newUser);
            this.reset();
            renderUsers();
        });

        // Initialize the dashboard
        showSection('create-post');
    </script>
</body>

</html>