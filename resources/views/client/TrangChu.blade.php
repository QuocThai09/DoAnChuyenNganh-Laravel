<?php
    use Illuminate\Support\Facades\DB;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đồ Án Khách Sạn</title>
    @include ('layout.linkClient')
    <style>
        .availability-form {
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }
    </style>
</head>
<?php
    function tinhtb_DanhGia($ma_phong){
        // $ma_phong = $_GET["keyLP"];
        //SELECT MALOAIPHONG, AVG(DIEMDANHGIA) AS TRUNGBINH
        // FROM FEEDBACK, PHIEUDATPHONG
        // WHERE FEEDBACK.MAPHIEUDATPHONG = PHIEUDATPHONG.MAPHIEUDATPHONG AND MALOAIPHONG = '$ma_phong'
        // GROUP BY MALOAIPHONG;
        $tb_DanhGia = DB::table('feedback')
            ->join('phieudatphong','phieudatphong.MAPHIEUDATPHONG','=','feedback.MAPHIEUDATPHONG')
            ->where('MALOAIPHONG','=',$ma_phong)
            ->avg('DIEMDANHGIA');
        return $tb_DanhGia;
    }
?>

<body bg-light>
    @include ('layout.HeaderClient')

    <!-- Swiper slide -->
    <div class="container-fluid px-lg-4 mt-4" >
        <div class="swiper swiper-container">
            <div class="swiper-wrapper" >
                <div class="swiper-slide">
                    <img src="images/hotel/Hinh1KS.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="images/hotel/HinhKS2.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="images/hotel/HinhKS3.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="images/hotel/HinhKS4.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="images/hotel/HinhKS5.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="images/hotel/HinhKS6.jpg" />
                </div>
            </div>
        </div>
    </div>

    <!-- Form Đặt Phòng -->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-9 bg-white p-4 shadow" style="margin-top: -70px">
                <h5 class="mb-3">Đặt Phòng</h5>
                <form method="post" action="{{ route('button-dat-phong') }}">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-lg-3">
                            <label class="form-label" style="font-weight: 500;">Ngày Đến</label>
                            <input type="date" name="ngayDen" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label" style="font-weight: 500;">Ngày Đi</label>
                            <input type="date"  name="ngayDi" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label" style="font-weight: 500;">Loại Phòng</label>
                            <select class="form-select" aria-label="Default select example" name="MALOAIPHONG" required>
                                @foreach ($DBloai_phong as $item)
                                    <option value="{{$item->MALOAIPHONG}}">
                                        {{$item->TENLOAIPHONG}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn text-white custom-bg">Đặt Ngay</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Các loại phòng -->
    <h2 class="mt-5 pt-4 mb-2 text-center fw-bold h-font">PHÒNG NGHỈ</h2>
    <div class="bg-dark" style="width: 150px; height: 1.7px; margin: 0 auto;"></div>
    <div class="container">
        <div class="row">
            @for($i = 0; $i < 3; $i++)
                <div class="col-lg-4 col-md-6 my-3">
                    <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <img src="images/typeRoom/{{$DBloai_phong[$i]->HINHLP}}" class="card-img-top">
                        <div class="card-body">
                            <h5>
                                {{$DBloai_phong[$i]->TENLOAIPHONG}}
                            </h5>
                            <h6 class="mb-4">
                                {{doi_Tien($DBloai_phong[$i]->GIANGAYTHUONG)}}/Ngày
                            </h6>
                            <div class="DacTrung mb-3">
                                <h6 class="mb-2">Đặc Trưng</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    {{$DBloai_phong[$i]->SLGIUONG}}
                                    {{$DBloai_phong[$i]->LOAIGIUONG}}
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    1 Phòng Tắm
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    1 Máy Lạnh
                                </span>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    1 Tivi
                                </span>
                            </div>
                            <p class="card-text mb-3">
                                {{$DBloai_phong[$i]->GIOITHIEULP}}
                            </p>
                            @if (tinhtb_DanhGia($DBloai_phong[$i]->MALOAIPHONG) == 0)
                                <div style="height: 25px"></div>
                            @else
                                <div class="rating mb-3">
                                    @for ($j = 1; $j <= tinhtb_DanhGia($DBloai_phong[$i]->MALOAIPHONG); $j++)
                                        <i class="bi bi-star-fill text-warning"></i>
                                        @if ((tinhtb_DanhGia($DBloai_phong[$i]->MALOAIPHONG) - $i) > 0 && (tinhtb_DanhGia($DBloai_phong[$i]->MALOAIPHONG) - $i) < 1)
                                            <i class="bi bi-star-half text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                            @endif
                            
                            <div class="d-flex my-3 justify-content-evenly mb-2">
                                @if (isset($_SESSION['client']) && $_SESSION['client'] == true)
                                    <a href="client/dat-phong?MALOAIPHONG={{$DBloai_phong[$i]->MALOAIPHONG}}" class="btn btn-sm text-white custom-bg">Đặt Lịch</a>
                                @else
                                    <button type="button" class="btn btn-sm text-white custom-bg" data-bs-toggle="modal" data-bs-target="#LoginModal">
                                        Đặt Lịch
                                    </button>
                                @endif
                                <a href="client/detail-room?maLP={{$DBloai_phong[$i]->MALOAIPHONG}}"
                                    class="btn btn-sm text-white custom-bg">Xem Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor

            <div class="col-lg-12 text-center mt-5">
                <a href="Phong.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold">Xem Thêm</a>
            </div>
        </div>
    </div>

    <!-- Dịch Vụ -->
    <h2 class="mt-5 pt-4 mb-2 text-center fw-bold h-font">TIỆN ÍCH</h2>
    <div class="bg-dark" style="width: 150px; height: 1.7px; margin: 0 auto;"></div>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            @foreach ($DBdich_vu as $item)
                <div class="col-lg-3 col-md-2 text-center bg-white shadow py-4 my-3" style="margin-right: 20px;">
                    <img src="images/service/{{$item->HINHDV}}" width="80px">
                    <h5 class="mt-3">
                        {{$item->TENDICHVU}}
                    </h5>
                    <p class="card-text mb-3">
                        {{$item->GIOITHIEUDV}}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Đánh Giá -->
    <h2 class="mt-5 pt-4 mb-2 text-center fw-bold h-font">ĐÁNH GIÁ</h2>
    <div class="bg-dark" style="width: 150px; height: 1.7px; margin: 0 auto;"></div>
    <div class="container">
        <div class="swiper swiper-rating">
            <div class="swiper-wrapper mb-5">
                @foreach ($DBdanh_gia as $item)
                    <div class="swiper-slide bg-white p-4">
                        <div class="profile d-flex align-items-center mb-3">
                            <i class="bi bi-person-circle"></i>
                            <h6 class="m-0 ms-2">
                                {{$item->HOTEN}}
                            </h6>
                        </div>
                        <p>
                            {{$item->NHANXET}}
                        </p>
                        <div class="rating">
                            @for ($i = 0; $i < $item->DIEMDANHGIA; $i++)
                                <i class="bi bi-star-fill text-warning"></i>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Liên Hệ -->
    <h2 class="mt-5 pt-4 mb-2 text-center fw-bold h-font">LIÊN HỆ</h2>
    <div class="bg-dark" style="width: 150px; height: 1.7px; margin: 0 auto;"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white">
                <iframe class="w-100"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0672268557546!2d106.62607571110689!3d10.806163158599073!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752be27d8b4f4d%3A0x92dcba2950430867!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBUaMawxqFuZyBUUC4gSOG7kyBDaMOtIE1pbmg!5e0!3m2!1svi!2s!4v1698835365757!5m2!1svi!2s"
                    height="320px" loading="lazy"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 mb-4">
                    <h5>Gọi Cho Chúng Tôi</h5>
                    <a href="tel: 0702025375" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> 0702025375
                    </a>
                    <br>
                    <a href="tel: 0702025375" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> 0702025375
                    </a>
                </div>

                <div class="bg-white p-4 mb-4">
                    <h5>Liên Hệ</h5>
                    <a href="#" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-facebook"></i> Facebook
                        </span>
                    </a>
                    <br>
                    <a href="#" class="d-inline-block mb-3">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-instagram"></i> Instagram
                        </span>
                    </a>
                    <br>
                    <a href="#" class="d-inline-block">
                        <span class="badge bg-light text-dark fs-6 p-2">
                            <i class="bi bi-twitter"></i> Twitter
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @include ('layout.FooterClient')
</body>

</html>