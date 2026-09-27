<?php
// 1. Kết nối CSDL
// LƯU Ý: Thay 'connect.php' hoặc 'config.php' đúng với tên file kết nối CSDL của bạn
include("../connect.php");

// Khai báo các biến mặc định
$TenTL = "";
$ThuTu = 0;
$AnHien = 1;
$icon = "";

// 2. Lấy ID thể loại từ URL
$idTL = isset($_GET['idTL']) ? $_GET['idTL'] : 0;

// 3. XỬ LÝ KHI NGƯỜI DÙNG BẤM NÚT "SỬA" (POST)
if (isset($_POST['sua'])) {
    $TenTL = $_POST['TenTL'];
    $ThuTu = $_POST['ThuTu'];
    $AnHien = $_POST['AnHien'];
    
    // Tên ảnh mới được chọn từ máy
    $ten_anh = $_FILES['image']['name'];
    
    if (!empty($ten_anh)) {
        // Nếu người dùng chọn ảnh mới -> Xóa ảnh cũ
        $ten_anh_cu = $_POST['ten_anh_cu'];
        if (!empty($ten_anh_cu)) {
            $duong_dan_anh_cu = "../image/" . $ten_anh_cu;
            if (is_file($duong_dan_anh_cu) && file_exists($duong_dan_anh_cu)) {
                unlink($duong_dan_anh_cu);
            }
        }
        
        // Upload ảnh mới vào thư mục ../image/
        $duong_dan_anh_moi = "../image/" . $ten_anh;
        move_uploaded_file($_FILES['image']['tmp_name'], $duong_dan_anh_moi);
        
        // Cập nhật bao gồm cả ảnh mới
        $sl = "UPDATE theloai SET TenTL='$TenTL', ThuTu='$ThuTu', AnHien='$AnHien', icon='$ten_anh' WHERE idTL='$idTL'";
    } else {
        // Nếu không chọn ảnh mới -> Giữ nguyên ảnh cũ
        $sl = "UPDATE theloai SET TenTL='$TenTL', ThuTu='$ThuTu', AnHien='$AnHien' WHERE idTL='$idTL'";
    }
    
    // Thực thi câu lệnh UPDATE
    if (mysqli_query($connect, $sl)) {
        // Chuyển hướng quay lại trang danh sách thể loại
        echo "<script>alert('Sửa thể loại thành công!'); window.location.href='theloai.php';</script>";
        exit();
    } else {
        echo "Lỗi cập nhật: " . mysqli_error($connect);
    }
}

// 4. LẤY DỮ LIỆU CŨ ĐỂ HIỂN THỊ LÊN FORM (GET)
if ($idTL > 0) {
    $sl_select = "SELECT * FROM theloai WHERE idTL='$idTL'";
    $res = mysqli_query($connect, $sl_select);
    if ($row = mysqli_fetch_array($res)) {
        $TenTL = $row['TenTL'];
        $ThuTu = $row['ThuTu'];
        $AnHien = $row['AnHien'];
        $icon = $row['icon'];
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Thể Loai</title>
    <style>
        table { margin: 20px auto; border-collapse: collapse; width: 450px; background: #f9f9f9; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>

<form action="" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <th colspan="2">SỬA THỂ LOẠI</th>
        </tr>
        <tr>
            <td>Tên Thể Loại:</td>
            <td><input type="text" name="TenTL" value="<?php echo htmlspecialchars($TenTL); ?>" required></td>
        </tr>
        <tr>
            <td>Thứ Tự:</td>
            <td><input type="number" name="ThuTu" value="<?php echo $ThuTu; ?>" required></td>
        </tr>
        <tr>
            <td>Ẩn / Hiện:</td>
            <td>
                <select name="AnHien">
                    <option value="1" <?php if ($AnHien == 1) echo "selected"; ?>>Hiện</option>
                    <option value="0" <?php if ($AnHien == 0) echo "selected"; ?>>Ẩn</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Hình ảnh:</td>
            <td>
                <?php if (!empty($icon)): ?>
                    <img src="../image/<?php echo $icon; ?>" width="80"><br>
                <?php endif; ?>
                <input type="file" name="image">
                <input type="hidden" name="ten_anh_cu" value="<?php echo $icon; ?>">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="sua" value="Sửa">
                <input type="reset" value="Hủy">
            </td>
        </tr>
    </table>
</form>

</body>
</html>