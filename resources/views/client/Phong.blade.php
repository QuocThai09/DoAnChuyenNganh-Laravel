<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <title>Đồ Án Khách Sạn</title>
    @include ('layout.linkClient')
</head>

<!-- Trung bình đánh giá -->
<?php
    // function tinhtb_DanhGia($ma_phong){
    //     include("Connection.php");
    //     $sql_tbDanhGia = "SELECT MALOAIPHONG, AVG(DIEMDANHGIA) AS TRUNGBINH
    //                       FROM FEEDBACK, PHIEUDATPHONG
    //                       WHERE FEEDBACK.MAPHIEUDATPHONG = PHIEUDATPHONG.MAPHIEUDATPHONG AND MALOAIPHONG = '$ma_phong'
    //                       GROUP BY MALOAIPHONG;";
    //     $sta_tbDanhGia = $pdo->prepare($sql_tbDanhGia);
    //     $sta_tbDanhGia->execute();
    //     $tb_DanhGia = $sta_tbDanhGia->fetchAll(PDO::FETCH_OBJ);
    //     foreach($tb_DanhGia as $tb){
    //         return $tb->TRUNGBINH;
    //     }
    // }
?>

<body bg-light>

    @include ('layout.headerClient')
    <?php
        if(isset($_POST['TimPhong']))
        {
            $ngayDen = $_POST['ngayden'];
            $ngayDi = $_POST['ngaydi'];
        }
    ?>
    <div class="my-3 px-4">
        <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
        <div class="bg-dark" style="width: 150px; height: 1.7px; margin: 0 auto;"></div>
    </div>

    <div class="contaner">
        <div class="row" style="width: 100%">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4" style="margin-left: 40px;">
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">TÌM KIẾM</h4>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#LocLoaiPhong" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <form method="post" action="#">
                            @csrf
                            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="LocLoaiPhong">
                                <div class="border bg-light p-3 mb-3">
                                    <input type="hidden" id="MaLP" value="{{$data->MALOAIPHONG}}">
                                    <h5 class="mb-3" style="font-size: 18px;">Kiểm Tra Phòng Trống</h5>
                                    <label class="form-label">Ngày Đến</label>
                                    <input type="date" class="form-control shadow-none" id="NgayDen" required value="{{$ngayDen}}" min="<?php echo date('Y-m-d'); ?>">
                                    <label class="form-label">Ngày Đi</label>
                                    <input type="date" class="form-control shadow-none" id="NgayDi" required value="{{$ngayDi}}" min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="border bg-light p-3 mb-3">
                                    <h5 class="mb-3" style="font-size: 18px;">Số Giường</h5>
                                    <div class="mb-2">
                                        <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
                                        <label class="form-label" for="f1">1 Giường</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="checkbox" id="f2" class="form-check-input shadow-none me-1">
                                        <label class="form-label" for="f2">2 Giường</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="checkbox" id="f3" class="form-check-input shadow-none me-1">
                                        <label class="form-label" for="f3">4 Giường</label>
                                    </div>
                                </div>
                                <div style="text-align: center;">
                                    <button type="button" id="search" class="btn btn-success w-100">Tìm Phòng</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </nav>
            </div>
            <div class="col-lg-8 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow">
                    <div style=" position: absolute; top: 0px;background-color: brown;width: 200px;height: 50px;left: 734px;border-radius: 0px 0px 0px 20px">
                        <h6 style="font-style: italic;color: rgb(255, 255, 255);font-size: 20px;margin: 10px">{{doi_Tien($data->GIANGAYTHUONG)}}/Ngày</h6>
                    </div>
                    <div class="row g-0 p-3 align-items-center">
                        <div class="col-md-5">
                            <img src="/images/typeRoom/{{$data->HINHLP}}" class="img-fluid" style="border-radius: 10px">
                        </div>
                        <div class="col-md-7 px-lg-3" style="position: relative">
                            
                            <h5 class="mb-3">{{$data->TENLOAIPHONG}}</h5>
                            
                            <div class="DacTrung mb-3">
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    {{$data->SLGIUONG}} {{$data->LOAIGIUONG}}
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
                            <h6 id="locPhong" class="mb-3">Số Phòng Còn Trống:  
                                {{locPhongTrong($data->MALOAIPHONG)}}
                            </h6>
                            <p class="card-text mb-2">{{$data->GIOITHIEULP}}</p>
                            <div class="rating mb-2">
                                @for ($i = 1; $i <= $diemDG; $i++)
                                    <i class="bi bi-star-fill text-warning"></i>
                                    @if (($diemDG - $i) > 0 && ($diemDG - $i) < 1)
                                        <i class="bi bi-star-half text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <div style="text-align: center">
                                @if (isset($_SESSION['client']) && $_SESSION['client'] == true)
                                    <a href="dat-phong?MALOAIPHONG={{$data->MALOAIPHONG}}" style="width: 40%;margin-right: 10px" class="btn btn-primary">Đặt Lịch</a>
                                @else
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#LoginModal">
                                        Đặt Lịch
                                    </button>
                                @endif
                                <a href="detail-room?maLP={{$data->MALOAIPHONG}}" style="width: 40%;margin-left: 10px" class="btn btn-secondary">Xem Chi Tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    

    @include ('layout.FooterClient')
    

</body>
<script>
    const button = document.getElementById('search');
    button.addEventListener('click', () => {
        var _token = document.querySelector('input[name="_token"]').value;
        var maLP = document.getElementById('MaLP').value;
        var ngayDen = document.getElementById('NgayDen').value;
        var ngayDi = document.getElementById('NgayDi').value;
        $.ajax({
                url: "{{ url('client/search-so-luong-phong-detail') }}",
                method: "POST",
                data: { maLP: maLP, ngayDen: ngayDen,ngayDi: ngayDi,_token:_token },
                success: function (data) {
                    $("#locPhong").html(data);
                }
            });
            
    });
</script>
</html>

