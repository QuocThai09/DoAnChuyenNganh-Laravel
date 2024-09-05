<?php
session_start(); // Bắt đầu session

if (isset($_POST['MAPHIEUDATPHONG'])) {
    $_SESSION['MAPHIEUDATPHONG'] = $_POST['MAPHIEUDATPHONG'];
    echo 'Giá trị đã được lưu vào biến session.';
} else {
    echo 'Không có giá trị được gửi đến server.';
}
?>