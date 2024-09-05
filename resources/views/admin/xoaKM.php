<?php
$makm = $_GET['MAKHUYENMAI'];

require_once 'ketnoi.php';

$xoasql = "DELETE FROM khuyenmai WHERE MAKHUYENMAI='$makm'";
if (mysqli_query($conn, $xoasql)) {
    $_SESSION['successMessage'] = "Xóa khuyến mãi thành công.";
    header("Location: danhSachKM.php");
} else {
    $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
    header("Location: danhSachKM.php");
}
?>