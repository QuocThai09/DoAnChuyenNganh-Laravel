<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đồ Án Khách Sạn</title>
    @include ('layout.linkClient')
</head>

<body bg-light>

    @include ('layout.HeaderClient')
    <div class="container">
        <div class="row">
            @foreach ($data as $item)
            
                <div class="col-12 my-5 mb-4 px-4">
                    <div class="font-size: 14px;">
                        <a href="{{ route('index') }}" class="text-secondary text-decoration-none">Trang Chủ</a>
                        <span class="text-secondary"> > </span>
                        <a href="Phong.php" class="text-secondary text-decoration-none">Phòng</a>
                    </div>
                    <h2 class="fw-bold">{{$item->TENLOAIPHONG}}</h2>
                </div>
                <div class="col-lg-7 col-md-12 px-4">
                    <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/images/typeRoom/{{$item->HINHLP}}" class="d-block w-100">
                            </div>
                            @for ($i = 1; $i < 3; $i++)
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="/images/typeRoom/{{substr($item->HINHLP,0,-4)}}-{{$i}}.jpg" alt="Second slide">
                                </div>
                            @endfor
                        </div>
                        
                        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 px-4">
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-2">{{number_format($item->GIANGAYTHUONG,0,',','.')}} vnd/Ngày</h4>
                            <?php ?>
                            <div class="rating mb-3">
                                @for ($i = 1; $i < $diemDG; $i++)
                                    <i class="bi bi-star-fill text-warning"></i>
                                    @if (($diemDG - $i) > 0 && ($diemDG - $i) < 1)
                                        <i class="bi bi-star-half text-warning"></i>
                                    @endif
                                @endfor
                                </div>
                            <div class="DacTrung mb-3">
                                    <h6 class="mb-3">Đặc Trưng</h6>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                        {{$item->SLGIUONG}} - {{$item->LOAIGIUONG}}
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
                            <div class="d-grid gap-2">
                                @if (isset($_SESSION['client']) && $_SESSION['client'] == true)
                                    <a href="dat-phong?MALOAIPHONG={{$item->MALOAIPHONG}}" class="btn btn-primary">Đặt Lịch</a>
                                @else
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#LoginModal">
                                        Đặt Lịch
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-4 px-4">
                    <div class="mb-4">
                        <h5>Giới Thiệu</h5>
                        <p>{{$item->GIOITHIEULP}}</p>
                    </div>
                </div>
            @endforeach

            <!-- Đánh Giá -->
            <h5 class="mt-3 pt-4 mb-4 fw-bold h-font">ĐÁNH GIÁ</h5>
            <div class="container">
                <div class="swiper swiper-rating">
                    <div class="swiper-wrapper mb-5">
                        @foreach ($feedbackDB as $val)
                            <div class="swiper-slide bg-white p-4">
                                <div class="profile d-flex align-items-center mb-3">
                                    <i class="bi bi-person-circle"></i>
                                    <h6 class="m-0 ms-2">{{$val->HOTENKH}}</h6>
                                </div>
                                <p>{{$val->NHANXET}}</p>
                                <div class="rating">
                                    @for ($i = 0; $i < $val->DIEMDANHGIA; $i++)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include ('layout.FooterClient')
    

</body>
</html>