<?php
include '../config/dbcon.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $getUser = $conn->prepare('SELECT * FROM users WHERE id = :id');
    $getUser->bindParam(':id', $id, PDO::PARAM_INT);
    $getUser->execute();

    if ($getUser->rowCount() > 0) {
        $user = $getUser->fetch(PDO::FETCH_ASSOC);
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
