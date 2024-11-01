<?php include("sidebar.php"); ?>
<div class="col py-3 ms-3">
    <div id="manage-posts">
        <h2>Add Post</h2>



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
            <button type="submit" name="addpost" class="btn btn-success mt-2">Add Post</button>
        </form>



    </div>
</div>





</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>