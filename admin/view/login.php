<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-sm" style="width: 100%; max-width: 400px;">
            <h4 class="text-center mb-4">Admin Login</h4>
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
            <form action="../controller/login.php" method="POST">
                <!-- Email input -->
                <div class="mb-3">
                    <label for="form2Example1" class="form-label">Username</label>
                    <input type="text" name="username" id="form2Example1" class="form-control" placeholder="Username">
                </div>

                <!-- Password input -->
                <div class="mb-3">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" name="pass" id="pass" class="form-control" placeholder="Enter your password">
                </div>

                <!-- Checkbox and Forgot password link -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="showpass">
                        <label class="form-check-label" for="showpass"> Show password </label>
                    </div>

                </div>

                <!-- Submit button -->
                <button type="submit" name="login_btn" class="btn btn-primary w-100">Login</button>

                <!-- Register buttons -->

            </form>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        document.getElementById("showpass").addEventListener("change", function() {
            var passwordInput = document.getElementById("pass");
            passwordInput.type = (this.checked) ? "text" : "password";
        });
    </script>
</body>

</html>