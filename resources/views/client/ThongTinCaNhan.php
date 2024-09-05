<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đồ Án Khách Sạn</title>
    <?php require('link.php'); ?>

</head>
<?php
include("Connection.php");
$sql = "SELECT * FROM `loaiphong`";
$sta = $pdo->prepare($sql);
$sta->execute();
$loai_phong = $sta->fetchAll(PDO::FETCH_OBJ);
$ma_kh = $_GET["key"];
$sql_chitietkh = "Select * from KHACHHANG where MAKH = '$ma_kh'";
$chi_tiet_kh = $pdo->query($sql_chitietkh);


?>

<body class="bg-light">
    <?php require('Header.php'); ?>


    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">THÔNG TIN KHÁCH HÀNG</h2>
                <div style="font-size: 14px;">
                    <a href="TrangChu.php" class="text-secondary text-decoration-none">Trang Chủ</a>
                    <span class="text-secondary"> > </span>
                    <a href="ThongTinCaNhan.php" class="text-secondary text-decoration-none">Thông Tin Khách Hàng</a>
                </div>
            </div>

            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 shadow-sm">
                    <form method="post" action="">
                        <h5 class="mb-3 fw-bold">Thông Tin Cá Nhân</h5>
                        <div class="row">
                            <?php foreach ($chi_tiet_kh as $key) { ?>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tên Khách Hàng</label>
                                    <input type="text" class="form-control shadow-none" name="tenKH"
                                        value="<?php echo $key[3] ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Số Điện Thoại</label>
                                    <input type="text" class="form-control shadow-none" name="SDTKH"
                                        value="<?php echo $key[1] ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">CMND</label>
                                    <input type="text" class="form-control shadow-none" name="cmndKH"
                                        value="<?php echo $key[2] ?>">
                                </div>
                        </div>
                        <button type="submit" class="btn btn-dark shadow-none text-white custom-bg" name="Doi_Thong_Tin" onclick="return XacNhanDoiThongTin()">Lưu Thay
                            Đổi</button>
                    </form>
                </div>

                <div class="bg-white p-3 p-md-4 shadow-sm">
                    <form method="post">
                        <input type="hidden" name="taikhoanKH" value="<?php echo $key[5] ?>">
                        <h5 class="mb-3 fw-bold">Đổi Mật Khẩu</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mật Khẩu Mới</label>
                                <input type="text" class="form-control shadow-none" name="mkMoi">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nhập Lại Mật Khẩu</label>
                                <input type="text" class="form-control shadow-none" name="mkNL">
                            </div>

                        </div>
                        <button type="submit" class="btn btn-dark shadow-none text-white custom-bg" onclick="return XacNhanDoiMatKhau()" name="Doi_Mat_Khau">Đổi Mật
                            Khẩu</button>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function XacNhanDoiThongTin(){
            var xacnhan = confirm('Bạn có muốn cập nhập thông tin không?');
            return xacnhan;
        }
    </script>

    <script>
        function XacNhanDoiMatKhau(){
            var xacnhan = confirm('Bạn có muốn đổi mật khẩu không?');
            return xacnhan;
        }
    </script>


    <?php
    if(isset($_POST["Doi_Thong_Tin"])){
        $tenkh = $_POST["tenKH"];
        $sdt = $_POST["SDTKH"];
        $cmnd = $_POST["cmndKH"];
        $sql_doitt = "UPDATE KHACHHANG SET HOTENKH = '$tenkh', SDTKH = '$sdt', CMNDKH = '$cmnd' WHERE MAKH = '$ma_kh'";
        $sta_doitt = $pdo->prepare($sql_doitt);
        $sta_doitt->execute();
        if ($sta_doitt->rowCount() > 0) {
            alert('success', 'Thay Đổi Thông Tin Thành Công! Vui Lòng Đăng Nhập Lại!');
        } else {
            alert('error', 'Thay Đổi Thông Tin Thất Bại');
        }

    }
    ?>

    <?php
    if(isset($_POST["Doi_Mat_Khau"])){
        $new_pw = $_POST["mkMoi"];
        $conf_newpw = $_POST["mkNL"];
        $taikhoanKH = $_POST["taikhoanKH"];
        if($new_pw != $conf_newpw)
        {
            alert('error', 'Nhập Lại Mật Khẩu Không Trùng Khớp');
        } else {
            $sql_doimk = "UPDATE TAIKHOAN SET MATKHAU = '$new_pw' WHERE TAIKHOAN.TAIKHOAN = '$taikhoanKH'";
            $sta_doimk = $pdo->prepare($sql_doimk);
            $sta_doimk->execute();
            if ($sta_doimk->rowCount() > 0) {
                alert('success', 'Đổi Mật Khẩu Thành Công! Vui Lòng Đăng Nhập Lại!');
            } else {
                alert('error', 'Đổi Mật Khẩu Thất Bại');
            }
        }
    }
    ?>


    
    <?php require('Footer.php') ?>


</body>

</html>