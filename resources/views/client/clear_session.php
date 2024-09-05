<?php
// Khởi động session
session_start();

if (isset($_POST["HuyDatPhong"])) {
    // Xóa tất cả các biến session
    session_unset();
    session_destroy();
}

// Chuyển hướng người dùng đến trang LichDatPhong.php sau khi xóa session
header("Location: LichDatPhong.php");
exit(); // Đảm bảo không có mã PHP hoặc HTML nào được thực thi sau khi chuyển hướng
?>