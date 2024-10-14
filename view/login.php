<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"></script>
    <link href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/mdb5/fonts/roboto-subset.css?ver=3.9.0-update.5" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/login.css">

</head>

<body>
    <div class="outer-container">
        <section class="vh-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 text-black">
                        <?php
                        if (isset($_SESSION['message'])) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong></strong> <?= $_SESSION['message']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['message']);
                        }
                        ?>
                        <div class="px-5 ms-xl-4">
                            <img src="../assets/images/logo1.png" alt="Logo" style="width: 100px; height: auto; margin-top: 30px;">
                        </div>

                        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 pt-5 pt-xl-0 mt-xl-n5">

                            <form style="width: 23rem;" action="../controller/login_register.php" method="POST">

                                <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="addon-wrapping">Email</span>
                                    <input type="text" class="form-control" placeholder="" name="email" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="addon-wrapping">Password</span>
                                    <input type="password" class="form-control" placeholder="" name="pass" id="pass" aria-label="Username" aria-describedby="addon-wrapping">
                                </div>

                                <div class="pt-1 mb-4">
                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-lg btn-block" type="submit" name="login_btn">Login</button>
                                </div>

                                <!-- <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">Forgot password?</a></p> -->
                                <input type="checkbox" id="showpass" class="showpass" name="showpass"><label for=" showpass"> Show password</label>

                                <p>Don't have an account? <a href="register.php" class="link-info">Register here</a></p>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 px-0 d-none d-sm-block">
                        <img src="../assets/images/japan.jpg"
                            alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                    </div>
                </div>
            </div>
        </section>
        <script>
            document.getElementById("showpass").addEventListener("change", function() {
                var passwordInput = document.getElementById("pass");
                if (this.checked) {
                    passwordInput.type = "text"; // Hiển thị mật khẩu
                } else {
                    passwordInput.type = "password"; // Ẩn mật khẩu
                }
            });
        </script>
    </div>
</body>