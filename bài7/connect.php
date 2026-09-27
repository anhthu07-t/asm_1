<?php 
$connect = mysqli_connect('localhost', 'root', '', 'tintuc');

// Kiểm tra kết nối
if (mysqli_connect_errno() !== 0) {
    die("Error: Could not connect to the database. An error " . mysqli_connect_error() . " occurred.");
}

mysqli_set_charset($connect, 'utf8');
?>