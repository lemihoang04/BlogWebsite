<?php
$servername = 'localhost:3307';
$username = 'root';
$password = '';
$db = 'blog_db';
$conn = new PDO("mysql:host=" . $servername . ";dbname=" . $db, $username, $password);
