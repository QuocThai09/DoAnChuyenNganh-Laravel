<?php
$maloaiphong = $_GET['MALOAIPHONG'];

require_once 'ketnoi.php';
$editsql = "SELECT * FROM loaiphong WHERE MALOAIPHONG='$maloaiphong'";
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
    <title>Admin-Painel Loại phòng</title>
    <?php require('C:/xampp/htdocs/admin/inc/links.php'); ?>
</head>

<body>
    <?php require('C:/xampp/htdocs/admin/inc/header.php'); ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Cập nhật thông tin loại phòng</h3>
                <form action="update_loaiphong.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Thêm loại phòng</h5>

                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Mã Loại phòng</label>
                                    <input type="text" name="MALOAIPHONG" class="form-control shadow-none"
                                        value="<?php echo $row['MALOAIPHONG'] ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tên loại phòng</label>
                                    <input type="text" name="TENLOAIPHONG" class="form-control shadow-none"
                                        value="<?php echo $row['TENLOAIPHONG'] ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Giá ngày thường</label>
                                    <input type="number" name="GIANGAYTHUONG" class="form-control shadow-none"
                                        value="<?php echo $row['GIANGAYTHUONG'] ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Giá ngày lễ</label>
                                    <input type="number" name="GIANGAYLE" class="form-control shadow-none"
                                        value="<?php echo $row['GIANGAYLE'] ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Loại giường adasdasd </label>
                                    <select id=combobox_loaigiuong class="form-control shadow-none" name="LOAIGIUONG">
                                        <option value="Giường đơn">Giường đơn</option>
                                        <option value="Giường đôi">Giường đôi</option>
                                        <option value="Giường Family">Giường Family</option>
                                        <option value="Giường 8 người">Giường 8 người</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Số lượng giường</label>
                                    <input type="number" name="SLGIUONG" class="form-control shadow-none"
                                        value="<?php echo $row['SLGIUONG'] ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Khuyến mãi loại phòng</label>
                                    <input type="number" name="KHUYENMAILP" class="form-control shadow-none"
                                        value="<?php echo $row['KHUYENMAILP'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ảnh loại phòng</label>
                                <input type="file" name="HINHLP" class="form-control shadow-none">
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