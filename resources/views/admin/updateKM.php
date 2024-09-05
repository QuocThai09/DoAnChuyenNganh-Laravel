<?php
$makm = $_POST['MAKHUYENMAI'];
$tenkm = $_POST['TENKHUYENMAI'];
$discount = $_POST['DISCOUNT'];
$trangthai = $_POST['TRANGTHAIKHUYENMAI'];

require_once 'ketnoi.php';

$updatesql = "UPDATE `khuyenmai` SET `TENKHUYENMAI`='$tenkm',`DISCOUNT`='$discount',`TRANGTHAIKHUYENMAI`='$trangthai' WHERE `MAKHUYENMAI`='$makm'";
//echo $updatesql; exit;


if (mysqli_query($conn, $updatesql)) {
    header("Location: danhSachKM.php");
}


?>