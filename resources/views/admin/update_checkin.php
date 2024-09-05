<?php
session_start();
require('C:/xampp/htdocs/admin/inc/essentials.php');

$maPDP = $_POST['MAPHIEUDATPHONG'];

require_once 'ketnoi.php';

$updatesql = "UPDATE `phieudatphong` SET `TRANGTHAI`= 1 WHERE `MAPHIEUDATPHONG`='$maPDP'";

if (mysqli_query($conn, $updatesql)) {
    $_SESSION['successMessage'] = "Checkin thành công";

    //alert('error', 'Đăng nhập không thành công - Thông tin xác thực không hợp lệ!');
    header("Location: checkin.php");
    exit();
} else {
    $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
    header("Location: checkin.php");
    exit();
}
?>