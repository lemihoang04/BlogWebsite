<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$db = 'blog_db';
$conn = new PDO("mysql:host=" . $servername . ";dbname=" . $db, $username, $password);
