<?php
// Bật hiển thị lỗi PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once('../connect.php');

$icon = $_FILES['image']['name'];
$anhminhhoa_tmp = $_FILES['image']['tmp_name'];
move_uploaded_file($anhminhhoa_tmp, "../image/" . $icon);

$theloai = $_POST['TenTL'];
$thutu = $_POST['ThuTu'];
$an = $_POST['AnHien'];

$sl = "INSERT INTO theloai (TenTL, ThuTu, AnHien, icon) VALUES ('$theloai', '$thutu', '$an', '$icon')";

if (mysqli_query($connect, $sl)) {
    echo "<script language='javascript'>alert('Them thanh cong');";
    echo "location.href='theloai.php';</script>";
} else {
    // Dừng chương trình và in ra lỗi MySQL chi tiết
    die("Loi MySQL: " . mysqli_error($connect));
}
?>