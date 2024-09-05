<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
ob_start();
?>
@include('layout.essentials')
@include('layout.FuncLocPhong')



<?php
// if (isset($_POST["DangNhap"])) {
//     $TENKH = "";
//     $email_dn = $_POST["email_dn"];
//     $sql_tttk = "SELECT * FROM `khachhang` WHERE TAIKHOAN = '$email_dn';";
//     $statt = $pdo->prepare($sql_tttk);
//     $statt->execute();
//     $tt_tk = $statt->fetchAll(PDO::FETCH_OBJ);
//     if ($tt_tk) {
//         foreach ($tt_tk as $row) {
//             $MAKH = $row->MAKH;
//             $TENKH = $row->HOTENKH;
//             $SDTKH = $row->SDTKH;
//             $CMNDKH = $row->CMNDKH;
//         }
//     }

//     $kt = 0;
//     $email_dn = $_POST["email_dn"];
//     $pw_dn = $_POST["pw_dn"];
//     $sqldn = "SELECT * FROM `taikhoan` WHERE TAIKHOAN = '$email_dn' AND MATKHAU = '$pw_dn'";
//     $sta = $pdo->prepare($sqldn);
//     $sta->execute();
//     $count = $sta->rowCount();
//     if ($count == 1) {
//         alert('success', 'Đăng Nhập Thành Công');
//         $_SESSION['logged_in'] = true;
//         $_SESSION['MAKH'] = $MAKH;
//         $_SESSION['TEN_KH'] = $TENKH;
//         $_SESSION['SDTKH'] = $SDTKH;
//         $_SESSION['CMNDKH'] = $CMNDKH;

//     } else {
//         alert('error', 'Đăng Nhập Không Thành Công');
//     }

// }
?>

<!-- Thanh Menu -->
<nav class="navbar navbar-expand-lg navbar-light bg-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-2 h-font" href="{{ route('index') }}">TVT Hotel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active me-2" aria-current="page" href="{{ route('index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="Phong.php">Phòng Khách Sạn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="#">Dịch Vụ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="LienHe.php">Liên Hệ</a>
                </li>
            </ul>
            <div class="d-flex">
                @if (isset($_SESSION['client']) && $_SESSION['client'] == true)
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                            data-bs-display="static" aria-expanded="false">
                            <i class="bi bi-person-circle" style="width: 25px; height: 25px;" class="me-1"></i>
                            {{$_SESSION['client']->HOTENKH}}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><a href="ThongTinCaNhan.php?key={{$_SESSION['client']->MAKH}}" class="nav-link"><button
                                        class="dropdown-item" type="button">Thông Tin Khách Hàng</button></a></li>
                            <li><a href="{{ route('all-lich-dat-phong') }}" class="nav-link"><button class="dropdown-item" type="button">Lịch
                                        Đặt Phòng</button></a></li>
                            <li><a href="{{ route('logoutClient') }}" class="nav-link"><button class="dropdown-item" type="button">
                                Đăng Xuất</button></a></li>
                        </ul>
                    </div>
                @else
                    <button type="button" class="btn btn-outline-dark me-lg-3 me-2" data-bs-toggle="modal"
                        data-bs-target="#LoginModal">
                        Đăng Nhập
                    </button>
                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                        data-bs-target="#RegisterModal">
                        Đăng Ký
                    </button>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Nút Đăng Nhập -->
<div class="modal fade" id="LoginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('loginClient') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" style="font-weight: bold;margin-left: 180px">
                        Đăng Nhập
                    </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email_dn">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="pw_dn">
                    </div>
                    <div>
                        <input type="submit" class="btn btn-primary" name="DangNhap" value="Tiếp Tục" style="width: 100%">
                        <a href="javascript: void(0)" style="margin-left: 170px">Quên Mật Khẩu?</a>
                    </div>
                    <div style="margin-top: 20px">
                        <h2 style="text-align: center; border-bottom: 1px solid #000; line-height: 0.1em; margin: 10px 0 20px; font-size: 20px">
                            <span style="background:#fff; padding:0 10px; ">
                                OR
                            </span>
                        </h2>
                    </div>
                    <div class="mb-3">
                        <a type="button" class="btn btn-outline-sucess" href="{{ route('login-by-google') }}" style="color: #2183de;border: solid 1px; width: 100%;">
                            <svg width="25" height="25" fill="#2a5884" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.66 10.2c.096 0 .179.067.195.161.094.526.145 1.092.145 1.639a8.967 8.967 0 0 1-2.293 6.001.197.197 0 0 1-.274.018l-2.445-2.07a.206.206 0 0 1-.016-.297 5.398 5.398 0 0 0 1.114-1.852H12.2a.2.2 0 0 1-.2-.2v-3.2c0-.11.09-.2.2-.2h8.46Z"></path>
                            <path d="M14.473 16.8a.205.205 0 0 1 .226.024l2.568 2.173a.196.196 0 0 1-.01.309A8.959 8.959 0 0 1 12 21a8.993 8.993 0 0 1-7.548-4.097.197.197 0 0 1 .046-.263l2.545-1.962a.207.207 0 0 1 .303.062 5.398 5.398 0 0 0 7.127 2.06Z"></path>
                            <path d="M6.68 12.926a.205.205 0 0 1-.076.197L3.869 15.23a.196.196 0 0 1-.304-.084A8.98 8.98 0 0 1 3 12c0-1.152.217-2.254.612-3.267a.196.196 0 0 1 .299-.085l2.732 2.004c.065.047.095.13.078.208a5.419 5.419 0 0 0-.042 2.066Z"></path>
                            <path d="M7.147 9.161c.096.07.231.042.295-.058A5.396 5.396 0 0 1 12 6.6a5.37 5.37 0 0 1 3.44 1.245.205.205 0 0 0 .276-.01l2.266-2.267a.197.197 0 0 0-.007-.286A8.953 8.953 0 0 0 12 3a8.992 8.992 0 0 0-7.484 4 .197.197 0 0 0 .049.267l2.582 1.894Z"></path>
                            </svg>
                            Đăng nhập với Google
                        </a>
                    </div>
                    <div class="mb-3">
                        <a type="button" class="btn btn-outline-sucess" href="" style="color: #2183de;border: solid 1px; width: 100%;">
                            <svg width="25" height="25" fill="#2183de" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.2 2.875A4.625 4.625 0 0 0 9.575 7.5v2.575H7.1c-.124 0-.225.1-.225.225v3.4c0 .124.1.225.225.225h2.475V20.9c0 .124.1.225.225.225h3.4c.124 0 .225-.1.225-.225v-6.975h2.497c.103 0 .193-.07.218-.17l.85-3.4a.225.225 0 0 0-.218-.28h-3.347V7.5a.775.775 0 0 1 .775-.775h2.6c.124 0 .225-.1.225-.225V3.1c0-.124-.1-.225-.225-.225h-2.6Z"></path>
                            </svg>
                            Đăng nhập với Facebook
                        </a>
                    </div>
                    <div class="mb-2">
                        <p style="text-align: center;font-size: 15px">Bằng cách đăng ký, bạn đồng ý với <a style="color: #2183de;font-weight: bold">Điều khoản & Điều kiện</a><br> của chúng tôi và bạn đã đọc <a style="color: #2183de;font-weight: bold">Chính Sách Quyền Riêng Tư</a><br> của chúng tôi.</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Nút Đăng Ký -->
<div class="modal fade" id="RegisterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="TrangChu.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-circle fs-3 me-2"></i>Đăng Ký
                    </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Họ Tên</label>
                                <input type="text" class="form-control" name="Ten_KH" id="Ten_KH">
                                <div class="invalid-feedback" id="nameError">
                                    Bạn chưa nhập họ tên.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="Email_KH" id="Email_KH">
                                <div class="invalid-feedback" id="nameError">
                                    Bạn chưa nhập email.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid mt-2">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Số Điện Thoại</label>
                                <input type="number" class="form-control" name="SDT_KH" id="SDT_KH">
                                <div class="invalid-feedback" id="nameError">
                                    Bạn chưa nhập số điện thoại.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CMND</label>
                                <input type="number" class="form-control" name="CMND_KH" id="CMND_KH">
                                <div class="invalid-feedback" id="nameError">
                                    Bạn chưa nhập chứng minh nhân dân.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid mt-2">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="PW_KH" id="PW_KH">
                                <div class="invalid-feedback" id="nameError">
                                    Bạn chưa nhập PassWord.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="ConfPW_KH" id="ConfPW_KH">
                                <div class="invalid-feedback" id="nameError">
                                    Nhập lại PassWord sai.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center my-3">
                        <input type="submit" class="btn btn-dark" name="DangKy" value="Đăng Ký"
                            onclick=" return validateForm()">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validateForm() {
        // Lấy giá trị từ input
        var isValid = true;
        var Ten_KH = document.getElementById("Ten_KH").value;
        var Email_KH = document.getElementById("Email_KH").value;
        var SDT_KH = document.getElementById("SDT_KH").value;
        var CMND_KH = document.getElementById("CMND_KH").value;
        var PW_KH = document.getElementById("PW_KH").value;
        var ConfPW_KH = document.getElementById("ConfPW_KH").value;

        if (Ten_KH == "") {
            document.getElementById("Ten_KH").classList.add("is-invalid");
            isValid = false;
        } else {
            document.getElementById("Ten_KH").classList.remove("is-invalid");
        }

        if (Email_KH == "") {
            document.getElementById("Email_KH").classList.add("is-invalid");
            isValid = false;
        } else {
            document.getElementById("Email_KH").classList.remove("is-invalid");
        }

        if (SDT_KH == "") {
            document.getElementById("SDT_KH").classList.add("is-invalid");
            isValid = false;
        } else {
            document.getElementById("SDT_KH").classList.remove("is-invalid");
        }

        if (CMND_KH == "") {
            document.getElementById("CMND_KH").classList.add("is-invalid");
            isValid = false;
        } else {
            document.getElementById("CMND_KH").classList.remove("is-invalid");
        }

        if (PW_KH == "") {
            document.getElementById("PW_KH").classList.add("is-invalid");
            isValid = false;
        } else {
            document.getElementById("PW_KH").classList.remove("is-invalid");
        }

        if (ConfPW_KH == "" || ConfPW_KH != PW_KH) {
            document.getElementById("ConfPW_KH").classList.add("is-invalid");
            isValid = false;
        } else {
            document.getElementById("ConfPW_KH").classList.remove("is-invalid");
        }

        if (!isValid) {
            document.getElementById("nameError").style.display = "block";
        } else {
            document.getElementById("nameError").style.display = "none";
        }

        return isValid;
    }
</script>




<?php
if (isset($_POST["DangKy"])) {
    $tenkh = $_POST["Ten_KH"];
    $emailkh = $_POST["Email_KH"];
    $sdtkh = $_POST["SDT_KH"];
    $cmndkh = $_POST["CMND_KH"];
    $pwkh = $_POST["PW_KH"];
    $conpwkh = $_POST["ConfPW_KH"];
    $sql_kttrung = "SELECT TAIKHOAN FROM KHACHHANG WHERE TAIKHOAN = '$emailkh';";
    $sta_kttrung = $pdo->prepare($sql_kttrung);
    $sta_kttrung->execute();
    $tt_kttrung = $sta_kttrung->fetchAll(PDO::FETCH_OBJ);
    if ($tt_kttrung) {
        alert('error', 'Email đã được sử dụng');
    } else if ($tenkh == "" || $emailkh == "" || $sdtkh == "" || $cmndkh == "" || $pwkh == "" || $conpwkh == "" || $pwkh != $conpwkh) {

    } else {
        // Tạo mã khách hàng (MAKH) dạng "KH" kết hợp với số nguyên tăng dần
        $sql_get_max_makh = "SELECT MAX(CAST(SUBSTRING(MAKH, 3) AS UNSIGNED)) AS max_makh FROM khachhang";
        $result = $pdo->query($sql_get_max_makh);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $max_makh = $row['max_makh'];
        $new_makh = "KH" . ($max_makh + 1);
        $sql_themkh = "INSERT INTO `khachhang`(`MAKH`, `SDTKH`, `CMNDKH`, `HOTENKH`, `LOAIKHACHHANG`, `TAIKHOAN`) VALUES ('$new_makh','$sdtkh','$cmndkh','$tenkh', 0, '$emailkh')";
        $sql_dk = "INSERT INTO `taikhoan`(`TAIKHOAN`, `MATKHAU`, `MAPQ`) VALUES ('$emailkh','$pwkh', '3')";
        $sta1 = $pdo->prepare($sql_themkh);
        $sta2 = $pdo->prepare($sql_dk);
        $sta1->execute();
        $sta2->execute();
        if ($sta1->rowCount() > 0 && $sta2->rowCount() > 0) {
            alert('success', 'Tạo Tài Khoản Thành Công');
        } else {
            alert('error', 'Tạo Tài Khoản Thất Bại');
        }
    }
}

?>