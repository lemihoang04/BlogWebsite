<link rel="stylesheet" type="text/css" href="../assets/css/navbar.css?v=9">
<nav class="navbar navbar-dark bg-dark navbar-expand-lg custom-navbar">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="../assets/images/logo1.png" alt="Logo" width="40" height="40">
      BLOG
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Post</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>


        <?php
        if (isset($_SESSION['user_id'])) {
        ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Account
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="infoview.php">Update Profile</a></li>
              <li><a class="dropdown-item" href="../controller/logout.php">Logout</a></li>
            </ul>
          <?php
        } else {
          ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
        <?php
        }
        ?>
        </li>
      </ul>
    </div>
  </div>
</nav>