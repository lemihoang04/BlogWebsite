<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/login1.css?v=1">
    <title>Login</title>
</head>

<body>

    <!----------------------- Main Container -------------------------->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!----------------------- Login Container -------------------------->

        <div class="row border rounded-4 p-3 bg-white shadow box-area">

            <!--------------------------- Left Box ----------------------------->

            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background-image: url('../assets/images/lake.jpg');">

                <!-- <div class="featured-image mb-3">
                    <img src="../assets/images/lake.jpg" class="img-fluid" style="width: 100%;"> -->
                <!-- </div> -->
                <!-- <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be Verified</p>
                <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Join experienced Designers on this platform.</small> -->
            </div>

            <!-------------------- ------ Right Box ---------------------------->

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
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
                        <h2>Login</h2>

                    </div>
                    <form action="../controller/login_register.php" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email address">
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" name="pass" id="pass" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="showpass">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Show password</small></label>
                            </div>
                            <div class="forgot">
                                <small><a href="#">Forgot Password?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" name="login_btn" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                        </div>
                    </form>
                    <div class="input-group mb-3">
                        <button class="btn btn-lg btn-light w-100 fs-6"><img src="../assets/images/google.png" style="width:20px" class="me-2"><small>Sign In with Google</small></button>
                    </div>
                    <div class="row">
                        <small>Don't have account? <a href="register.php">Sign Up</a></small>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.getElementById("showpass").addEventListener("change", function() {
            var passwordInput = document.getElementById("pass");
            passwordInput.type = (this.checked) ? "text" : "password";
        });
    </script>
</body>

</html>