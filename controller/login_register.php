<?php
include '../config/dbcon.php';
session_start();


if (isset($_POST['register_btn'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);

   if ($select_user->rowCount() > 0) {
      $_SESSION['message'] = 'Email already exists!';
      header('location:../view/register.php');
   } else {
      if ($pass != $cpass) {
         $_SESSION['message'] = 'Confirm password not matched!';
         header('location:../view/register.php');
      } else {
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
         $select_user->execute([$email, $pass]);
         if ($select_user->rowCount() > 0) {
            $_SESSION['message'] = "Registered successfully";
            header('location: ../view/login.php');
         }
      }
   }
} elseif (isset($_POST['login_btn'])) {

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($select_user->rowCount() > 0) {
      $_SESSION['user_id'] = $row['id'];
      header('location:../view/index.php');
   } else {
      $_SESSION['message'] = 'incorrect username or password!';
      header('location: ../view/login.php');
   }
}
