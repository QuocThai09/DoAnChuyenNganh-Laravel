<?php



$maphieudat = $_POST['MAPHIEUDATPHONG'];
$maKH = $_POST['MAKH'];
$maphong = $_POST['MAPHONG'];
$soPhong = $_POST['SOPHONG'];
$ngayNhanPhong = $_POST['NGAYNHANPHONG'];
$ngayTraPhong = $_POST['NGAYTHUCTE'];
$soNgayThue = $_POST['SONGAYTHUE'];
$maLoaiPhong = $_POST['MALOAIPHONG'];

$MaKhuyenMai = $_POST['KHUYENMAI'];



if (isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] === true) {
    $employee_name = isset($_SESSION['employee_name']) ? $_SESSION['employee_name'] : '';
}
// lấy mã nv
//$hoTenNV = $_POST['hoTen'];
$selectMaNV = "SELECT * FROM `nhanvien` WHERE `HOTENNV`='$employee_name'";
$result = mysqli_query($conn, $selectMaNV);
$row = mysqli_fetch_assoc($result);
$maNV = $row['MANV'];


$sql_get_max_hd = "SELECT MAX(CAST(SUBSTRING(MAHOADON, 3) AS UNSIGNED)) AS max_mahd FROM HOADON";

$result = $conn->query($sql_get_max_hd);

if ($result) {
    $row = $result->fetch_assoc();

    if ($row) {
        $max_mahd = $row['max_mahd'];
    } else {
        $max_mahd = 0; // Set initial value if no records exist
    }

    $new_mahd = "HD" . (intval($max_mahd) + 1); // Convert max_mahd to integer before adding 1
} else {
    // Handle error in executing query
}


//Cập nhật hư hao 
if(!isset($_POST['myCheckbox'])){
    $huhao = 0;
}else{
    $huhao = $_POST['myCheckbox'];
    $slHH = $_POST['SOLUONGHUHAO'];

    $tongTienHuHao = 0;
    if(!isset($_POST['vitriDV'])){
        $_SESSION['errorMessage'] = "Vui  lòng chọn mục xác nhận vật dụng hư hao";
        header("Location: edit_checkout.php");
        return;
    }else{
        $viTriDV = $_POST['vitriDV'];
        $check = 0;
        for($i = 0;$i < count($huhao);$i++){
            for($vt = $check; $vt < count($viTriDV); $vt ++){
                for($j = $viTriDV[$vt];$j < count($slHH); $j++){
                    $selectTienVatDung = "SELECT `GIAVD` FROM `vatdung` WHERE `MAVATDUNG` = '$huhao[$i]' AND `MALOAIPHONG`= '$maLoaiPhong'";
                    $result = mysqli_query($conn, $selectTienVatDung);
                    $row = mysqli_fetch_assoc($result);
                    if($slHH[$j] == 1){
                        $sl = (int)$slHH[$j];
                        $tienVatDung = $row['GIAVD'];
                        $tongTienHuHao += $tienVatDung;
                        $tienHuHao = $tienVatDung * $sl;
                    }else{
                        $sl = (int)$slHH[$j];
                        $tienVatDung = (int)$row['GIAVD'];
                        $tongTienHuHao += $tienVatDung * $sl;
                        $tienHuHao = $tienVatDung * $sl;
                    }
                    $inSertHuHao = "INSERT INTO `huhao`(`MAPHIEUDATPHONG`, `MAVATDUNG`,`SOLUONG`, `TONGTIENHH`) VALUES ('$maphieudat','$huhao[$i]',$sl,$tienHuHao)";
                    mysqli_query($conn, $inSertHuHao);
                    break;
                }
                $check ++;
                break;
            }
            
        }
    }

    
}

// Tìm discount của khuyến mãi
if($MaKhuyenMai == 1){
    $tenKM = "Not values";
    $discount = 0;
}else{
    $selectKM = "SELECT * FROM `khuyenmai` WHERE `MAKHUYENMAI` ='$MaKhuyenMai'";
    $res = mysqli_query($conn, $selectKM);
    $row = mysqli_fetch_assoc($res);
    $discount = $row['DISCOUNT'];
    $tenKM = $row['TENKHUYENMAI'];
}


// cập nhật tổng tiền trong phiếu đặt phòng
$selectPDP = "SELECT `TONGTIENPDP` FROM `phieudatphong` WHERE `MAPHIEUDATPHONG` = '$maphieudat'";
$result =  mysqli_query($conn, $selectPDP);
$row1 = mysqli_fetch_assoc($result);
$tongTienPDP = $row1['TONGTIENPDP'];

$tongTien = $tongTienPDP + $tongTienHuHao;
$tienKM = $tongTien * $discount;
$t = $tongTien - $tienKM;
$updateTongTien = "UPDATE `phieudatphong` SET `TONGTIENPDP`='$t' WHERE `MAPHIEUDATPHONG`='$maphieudat'";
mysqli_query($conn, $updateTongTien);

// Tìm hóa đơn của khách hàng đó 
$selectKhachHang = "SELECT * FROM `hoadon` WHERE `MAKH` = '$maKH' AND `NGAYTRAPHONG` = '$ngayTraPhong'";
$res = $conn->query($selectKhachHang);
if($res){
    $row = $res->fetch_assoc();
    if($row){
        if($row['TRANGTHAI'] == 1){
            //Tạo hóa đơn mới
            $km = $tenKM.'-'.$soPhong;
            $danhSachKMMoi = $km;
            $createsql = "INSERT INTO `hoadon`(`MAHOADON`, `NGAYNHANPHONG`, `NGAYTRAPHONG`, `SONGAYTHUE`,`THANHTIEN`,`MANV`, `MAKH`,`DANHSACHPHONG`,`ThongTinKM`,`TRANGTHAI`)
            VALUES ('$new_mahd','$ngayNhanPhong','$ngayTraPhong',$soNgayThue,$t,'$maNV','$maKH','$soPhong','$danhSachKMMoi',0)";
            if (mysqli_query($conn, $createsql)) {
                $updatePhieuDatPhong = "UPDATE `phieudatphong` SET `TRANGTHAI`= 2 WHERE MAPHIEUDATPHONG = '$maphieudat'";
                mysqli_query($conn, $updatePhieuDatPhong);
            
                // Tạo chi tiết hóa đơn
                $createCTHD = "INSERT INTO `cthd`(`MAHOADON`, `MAPHIEUDATPHONG`, `TONGTIEN`) VALUES ('$new_mahd','$maphieudat','$t')";
                mysqli_query($conn, $createCTHD);

                //cập nhật số lần thuê phòng
                $selectSL = "SELECT * FROM `solanthuephong` WHERE `SOPHONG` = '$soPhong'";
                $res = $conn->query($selectSL);
                if($res){
                    $row = $res->fetch_assoc();
                    if($row){
                        //UPDATE SỐ LƯỢNG 
                        $slCu = $row["SOLAN"];
                        $sl = $slCu + 1;
                        $update = "UPDATE `solanthuephong` SET `SOLAN`='$sl' WHERE `SOPHONG`='$soPhong'";
                        if(mysqli_query($conn, $update)){
                            $_SESSION['successMessage'] = "Check out thành công.";
                            header("Location: checkout.php");
                        }else{
                            $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
                            header("Location: checkout.php");
                        }
                    }else{
                        //insert số lần sd phòng
                        $insert = "INSERT INTO `solanthuephong`(`SOPHONG`, `SOLAN`) VALUES ('$soPhong',1)";
                        if(mysqli_query($conn, $insert)){
                            $_SESSION['successMessage'] = "Check out thành công.";
                            header("Location: checkout.php");
                        }else{
                            $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
                            header("Location: checkout.php");
                        }
                    }
                }
            }
        }else{
            $maHD = $row['MAHOADON'];
            // Tạo chi tiết hóa đơn
            $createCTHD = "INSERT INTO `cthd`(`MAHOADON`, `MAPHIEUDATPHONG`, `TONGTIEN`) VALUES ('$maHD','$maphieudat',$t)";
            mysqli_query($conn, $createCTHD);

            // Cập nhật danh sách phòng và tổng tiền cho hóa đơn
            $danhSachPhongCu = $row['DANHSACHPHONG'];
            $danhSachPhongMoi = $danhSachPhongCu.'-'.$soPhong;
            
            $km = $tenKM.'-'.$soPhong;
            if(!isset($row['ThongTinKM'])){
                $danhSachKMMoi = $km;
            }else{
                $danhSachKMCu = $row['ThongTinKM'];
                $danhSachKMMoi = $danhSachKMCu.';'.$km;
            }
            


            $thanhTienCu = $row['THANHTIEN'];
            $tongThanhTien = $thanhTienCu + $t;
            $updateHD = "UPDATE `hoadon` SET `THANHTIEN`=$tongThanhTien,`DANHSACHPHONG`='$danhSachPhongMoi',`ThongTinKM`='$danhSachKMMoi' WHERE `NGAYTRAPHONG`='$ngayTraPhong' AND `MAKH`='$maKH'";
            if(mysqli_query($conn, $updateHD)){
                $updatePhieuDatPhong = "UPDATE `phieudatphong` SET `TRANGTHAI`= 2 WHERE MAPHIEUDATPHONG = '$maphieudat'";
                mysqli_query($conn, $updatePhieuDatPhong);
                
                //cập nhật số lần thuê phòng
                $selectSL = "SELECT * FROM `solanthuephong` WHERE `SOPHONG` = '$soPhong'";
                $res = $conn->query($selectSL);
                if($res){
                    $row = $res->fetch_assoc();
                    if($row){
                        //UPDATE SỐ LƯỢNG 
                        $slCu = $row["SOLAN"];
                        $sl = $slCu + 1;
                        $update = "UPDATE `solanthuephong` SET `SOLAN`='$sl' WHERE `SOPHONG`='$soPhong'";
                        if(mysqli_query($conn, $update)){
                            $_SESSION['successMessage'] = "Check out thành công.";
                            header("Location: checkout.php");
                        }else{
                            $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
                            header("Location: checkout.php");
                        }
                    }else{
                        //insert số lần sd phòng
                        $insert = "INSERT INTO `solanthuephong`(`SOPHONG`, `SOLAN`) VALUES ('$soPhong',1)";
                        if(mysqli_query($conn, $insert)){
                            $_SESSION['successMessage'] = "Check out thành công.";
                            header("Location: checkout.php");
                        }else{
                            $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
                            header("Location: checkout.php");
                        }
                    }
                }
            }
        }
    }else{
        //Tạo hóa đơn 
        $km = $tenKM.'-'.$soPhong;
        $danhSachKMMoi = $km;
        $createsql = "INSERT INTO `hoadon`(`MAHOADON`, `NGAYNHANPHONG`, `NGAYTRAPHONG`, `SONGAYTHUE`,`THANHTIEN`,`MANV`, `MAKH`,`DANHSACHPHONG`,`ThongTinKM`,`TRANGTHAI`)
        VALUES ('$new_mahd','$ngayNhanPhong','$ngayTraPhong',$soNgayThue,$t,'$maNV','$maKH','$soPhong','$danhSachKMMoi',0)";
        if (mysqli_query($conn, $createsql)) {
            $updatePhieuDatPhong = "UPDATE `phieudatphong` SET `TRANGTHAI`= 2 WHERE MAPHIEUDATPHONG = '$maphieudat'";
            mysqli_query($conn, $updatePhieuDatPhong);
        
            // Tạo chi tiết hóa đơn
            $createCTHD = "INSERT INTO `cthd`(`MAHOADON`, `MAPHIEUDATPHONG`, `TONGTIEN`) VALUES ('$new_mahd','$maphieudat','$t')";
            mysqli_query($conn, $createCTHD);

            //cập nhật số lần thuê phòng
            $selectSL = "SELECT * FROM `solanthuephong` WHERE `SOPHONG` = '$soPhong'";
            $res = $conn->query($selectSL);
            if($res){
                $row = $res->fetch_assoc();
                if($row){
                    //UPDATE SỐ LƯỢNG 
                    $slCu = $row["SOLAN"];
                    $sl = $slCu + 1;
                    $update = "UPDATE `solanthuephong` SET `SOLAN`='$sl' WHERE `SOPHONG`='$soPhong'";
                    if(mysqli_query($conn, $update)){
                        $_SESSION['successMessage'] = "Check out thành công.";
                        header("Location: checkout.php");
                    }else{
                        $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
                        header("Location: checkout.php");
                    }
                }else{
                    //insert số lần sd phòng
                    $insert = "INSERT INTO `solanthuephong`(`SOPHONG`, `SOLAN`) VALUES ('$soPhong',1)";
                    if(mysqli_query($conn, $insert)){
                        $_SESSION['successMessage'] = "Check out thành công.";
                        header("Location: checkout.php");
                    }else{
                        $_SESSION['errorMessage'] = "Lỗi: " . mysqli_error($conn);
                        header("Location: checkout.php");
                    }
                }
            }
        }
    }
}




?>