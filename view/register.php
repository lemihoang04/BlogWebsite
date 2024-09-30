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
                            <img src="https://vectorlogoseek.com/wp-content/uploads/2019/10/bloq-vector-logo.png" alt="Logo" style="width: 150px; height: auto; margin-top: 30px;">
                        </div>

                        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 pt-5 pt-xl-0 mt-xl-n5">

                            <form style="width: 23rem;" action="../controller/login_register.php" method="POST">

                                <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Register</h3>
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="text" id="form2Example18" name="name" class="form-control form-control-lg" />
                                    <label class="form-label" for="form2Example18">Name</label>
                                </div>
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="email" id="form2Example18" name="email" class="form-control form-control-lg" />
                                    <label class="form-label" for="form2Example18">Email address</label>
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" id="form2Example28" name="pass" class="form-control form-control-lg" />
                                    <label class="form-label" for="form2Example28">Password</label>
                                </div>
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" id="form2Example28" name="cpass" class="form-control form-control-lg" />
                                    <label class="form-label" for="form2Example28">Comfirm password</label>
                                </div>

                                <div class="pt-1 mb-4">
                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-lg btn-block" type="submit" name="register_btn">Login</button>
                                </div>

                                <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">Forgot password?</a></p>
                                <p>Don't have an account? <a href="#!" class="link-info">Register here</a></p>
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
    </div>
</body>