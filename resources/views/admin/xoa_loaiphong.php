<?php
session_start();

require_once 'essentials.php';
$maloaiphong = $_GET['MALOAIPHONG'];
require_once 'ketnoi.php';
$xoasql = "DELETE FROM `LOAIPHONG` WHERE `MALOAIPHONG`='$maloaiphong'";
if (mysqli_query($conn, $xoasql)) {
    $_SESSION['successMessage'] = "Xóa loại phòng thành công";
    header("Location: LoaiPhong.php");
} else {
    $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
    header("Location: LoaiPhong.php");
}
?>