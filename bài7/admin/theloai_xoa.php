<?php
include("../connect.php");

if (isset($_GET["idTL"])) {
    $key = $_GET["idTL"];
    $sl = "DELETE FROM theloai WHERE idTL=" . $key;
    
    if (mysqli_query($connect, $sl)) {
        echo "<script language='javascript'>alert('Xoa thanh cong');";
        echo "location.href='theloai.php';</script>";
    }
}
?>