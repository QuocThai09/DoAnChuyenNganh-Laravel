<?php
$maphieudat = $_GET['MAPHIEUDATPHONG'];

require_once 'ketnoi.php';
$editsql = "SELECT PD.*, KH.HOTENKH, LP.TENLOAIPHONG FROM PHIEUDATPHONG PD JOIN KHACHHANG KH ON PD.MAKH = KH.MAKH 
JOIN LOAIPHONG LP ON PD.MALOAIPHONG = LP.MALOAIPHONG WHERE PD.MAPHIEUDATPHONG = '$maphieudat'";
$result = mysqli_query($conn, $editsql);
$row = mysqli_fetch_assoc($result);
?>

<?php
require_once 'essentials.php';
require_once 'db_config.php';
adminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu đặt phòng</title>
    <?php require('C:/xampp/htdocs/admin/inc/links.php'); ?>
</head>

<body>
    <?php require('C:/xampp/htdocs/admin/inc/header.php'); ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Xác nhận phòng cho khách hàng</h3>
                <form action="update_phieudat.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">

                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Mã phiếu đặt</label>
                                    <input type="text" name="MAPHIEUDATPHONG" class="form-control shadow-none"
                                        value="<?php echo $row['MAPHIEUDATPHONG'] ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ngày đặt phòng</label>
                                    <input type="text" name="NGAYDATPHONG" class="form-control shadow-none"
                                        value="<?php echo $row['NGAYDATPHONG'] ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ngày nhận phòng</label>
                                    <input type="text" name="NGAYNHANPHONG" class="form-control shadow-none"
                                        value="<?php echo $row['NGAYNHANPHONG'] ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ngày trả phòng</label>
                                    <input type="text" name="NGAYTRAPHONG" class="form-control shadow-none"
                                        value="<?php echo $row['NGAYTRAPHONG'] ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Họ tên Khách hàng</label>
                                    <input type="text" name="HOTENKH" class="form-control shadow-none"
                                        value="<?php echo $row['HOTENKH'] ?>" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tên loại phòng</label>
                                    <input type="text" name="TENLOAIPHONG" class="form-control shadow-none"
                                        value="<?php echo $row['TENLOAIPHONG'] ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3" style="visibility: hidden;">
                                    <input type="text" name="MAKH" class="form-control shadow-none"
                                        value="<?php echo $row['MAKH'] ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3" style="visibility: hidden;">
                                    <input type="text" name="MALOAIPHONG" class="form-control shadow-none"
                                        value="<?php echo $row['MALOAIPHONG'] ?>" readonly>
                                </div>
                                <?php
                                $maloaiphong = $row['MALOAIPHONG'];
                                $editsql = "SELECT * FROM phong WHERE MALOAIPHONG = '$maloaiphong'";
                                $result = mysqli_query($conn, $editsql);
                                ?>
                                <div class="col-md-6 mb-3" style="top:-50px;position: relative;">
                                    <label class="form-label fw-bold">Phòng</label>
                                    <select id=combobox_sophong class="form-control shadow-none" name="SOPHONG">
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $trangthai = $row['TRANGTHAIPHONG'];
                                            if ($trangthai == 0) {
                                                ?>
                                                <option value="<?php echo $row['SOPHONG'] ?>">
                                                    <?php echo $row['SOPHONG'] ?>
                                                </option>
                                                <?php
                                            } else {

                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="quay_lai_trang_truoc()"
                                class="btn btn-outline-danger">CANCEL</button>
                            <button type="submit" class="btn btn-outline-success">UPDATE</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>

</body>
<script>
    function quay_lai_trang_truoc() {
        history.back();
    }
</script>