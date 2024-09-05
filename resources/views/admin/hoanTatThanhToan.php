<?php
session_start();

require_once 'ketnoi.php';

$maHD = $_POST['MAHOADON'];
$ngayTra = $_POST['NGAYTRAPHONG'];
$tongtien = $_POST['THANHTIEN'];

$updateHD = "UPDATE `hoadon` SET `TRANGTHAI`=1 WHERE `MAHOADON`='$maHD'";

if(mysqli_query($conn, $updateHD)){
    //Tìm ngày thống kê
    $selectNgay = "SELECT * FROM `thongke` WHERE `ngay` = '$ngayTra'";
    $res = $conn->query($selectNgay);
    if($res){
        $row = $res->fetch_assoc();
        if($row){
            //Cập nhật doanh thu
            $doanhThuCu = $row['doanhthu'];
            $moi =  $doanhThuCu + $tongtien;
            $updateDoanhThu = "UPDATE `thongke` SET `doanhthu`= $moi WHERE `ngay`='$ngayTra'";
            if(mysqli_query($conn, $updateDoanhThu)){
                $_SESSION['successMessage'] = "Thanh toán thành công.";
                header("Location: hoadonKH.php");
            }else{
                $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
                header("Location: hoadonKH.php");
            }
        }else{
            //tạo doanh thu mới
            $insertDoanhThu = "INSERT INTO `thongke`(`ngay`, `doanhthu`) VALUES ('$ngayTra','$tongtien')";
            if(mysqli_query($conn, $insertDoanhThu)){
                $_SESSION['successMessage'] = "Thanh toán thành công.";
                header("Location: hoadonKH.php");
            }else{
                $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
                header("Location: hoadonKH.php");
            }
        }
    }
}

?>