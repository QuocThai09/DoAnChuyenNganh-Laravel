<?php
include("Connection.php");
include("LocPhong.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $MAPHIEUDATPHONG = $_POST['MAPHIEUDATPHONG'];
    $MALOAIPHONG = $_POST['MALOAIPHONG'];
    $NGAYNHANPHONG = $_POST['NGAYNHANPHONG'];
    $NGAYTRAPHONG = $_POST['NGAYTRAPHONG'];

    echo 'MAPHIEUDATPHONG: ' . $MAPHIEUDATPHONG . '<br>';
    echo 'MALOAIPHONG: ' . $MALOAIPHONG . '<br>';
    echo 'NGAYNHANPHONG: ' . $NGAYNHANPHONG . '<br>';
    echo 'NGAYTRAPHONG: ' . $NGAYTRAPHONG . '<br>';

    $tongTien = cocnuatien($MALOAIPHONG, $NGAYNHANPHONG, $NGAYTRAPHONG);

    $sql = "UPDATE PHIEUDATPHONG SET TONGTIENPDP = :TONGTIENPDP, TRANGTHAITHANHTOAN = 1 WHERE MAPHIEUDATPHONG = :MAPHIEUDATPHONG";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':TONGTIENPDP', $tongTien);
    $stmt->bindParam(':MAPHIEUDATPHONG', $MAPHIEUDATPHONG, PDO::PARAM_STR);
    $stmt->execute();

    echo "Cập nhật thành công";
} else {
    echo "Yêu cầu không hợp lệ";
}
?>