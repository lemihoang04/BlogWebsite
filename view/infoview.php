<?php include("sidebar.php"); ?>
<div class="col py-3 ms-3">
    <h1>Profile update</h1>
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
    <?php
    $user = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $user->execute([$user_id]);
    $userfetch = $user->fetch(PDO::FETCH_ASSOC);
    ?>
    <form action="../controller/updateinfo.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            <!-- Phần bên trái: Name và Email -->


            <!-- Phần bên phải: Avatar và nút chọn ảnh -->
            <div class="col-md-6">
                <div class="form-group text-center">
                    <label for="avatar">Avatar</label>
                    <div>
                        <img id="avatarPreview" src="../assets/images/avatars/<?= $userfetch['avatar'] ?>" alt="Avatar" class="img-thumbnail mb-3" style="width: 250px; height: 250px; object-fit: cover;">
                    </div>
                    <input type="file" name="image" class="form-control-file" id="avatar" onchange="previewAvatar(event)">
                </div>
            </div>
            <div class="col-md-5">
                <h2>Personal info</h2>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?= $userfetch['name'] ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?= $userfetch['email'] ?>">
                </div>
                <button type="submit" name="update" class="btn btn-primary mt-3">Update</button>
            </div>
        </div>


    </form>

    <script>
        function previewAvatar(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('avatarPreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>