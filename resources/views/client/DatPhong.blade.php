<?php
use Illuminate\Support\Facades\DB;
?>
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


<body bg-light>
    @include ('layout.HeaderClient')
    <div class="container">
        <div class="row" style="margin-top: -30px">
            <div class="col-10 my-5 mb-1 px-4">
                <div class="font-size: 14px;">
                    <a href="TrangChu.php" class="text-secondary text-decoration-none">Trang Chủ</a>
                    <span class="text-secondary"> > </span>
                    <a href="Phong.php" class="text-secondary text-decoration-none">Phòng</a>
                </div>
                <h2 class="fw-bold">{{$data->TENLOAIPHONG}}</h2>
            </div>
            <div class="col-lg-7 col-md-12 px-4">
                <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="/images/typeRoom/{{$data->HINHLP}}" width="100%" height="400px" style="border-radius: 10px">
                        <div style="height: 10px"></div>
                        <h6 class="fw-bold" style="font-size: 20px;font-style: italic;color:red">{{doi_Tien($data->GIANGAYTHUONG)}} /Ngày</h6>
                        <a style="font-style: italic">{{$data->GIOITHIEULP}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">Đặt Lịch</h6>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Họ Tên</label>
                                <input name="tenKH" type="text" class="form-control shadow-none" style="font-weight: bold" required value="{{$_SESSION['client']->HOTENKH}}" readonly>
                            </div>

                            @if ($_SESSION['client']->SDTKH == null)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input name="SDTKH" type="tel" pattern="[0-9]{10}" class="form-control shadow-none" required>
                                </div>
                            @else
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input name="SDTKH" type="tel" pattern="[0-9]{10}" class="form-control shadow-none" required value="{{$_SESSION['client']->SDTKH}}">
                                </div>
                            @endif

                            @if ($_SESSION['client']->CMNDKH == null)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">CCCD</label>
                                    <input name="CMNDKH" type="text" pattern="\d{12}" class="form-control shadow-none" required>
                                </div>
                            @else
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">CCCD</label>
                                    <input name="CMNDKH" type="text" pattern="\d{12}" class="form-control shadow-none" required value="{{$_SESSION['client']->CMNDKH}}" readonly>
                                </div>
                            @endif
                            <form autocomplete="off" action="{{ route('close-order-room') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" id="MaLP" name="MaLP" value="{{ $data->MALOAIPHONG }}">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ngày Đến</label>
                                        <input id="NgayDen" name="NgayDen" type="date" class="form-control shadow-none" required min="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ngày Đi</label>
                                        <input id="NgayDi" name="NgayDi" type="date" class="form-control shadow-none" required min="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div class="col-md-12 mb-1" id="sophong">
                                        <label class="form-label">Số Phòng Còn Trống :
                                            {{locPhongTrong($data->MALOAIPHONG)}}
                                        </label>
                                    </div>
                                    <div class="col-md-6 mb-3" style="position: relative;left: 60px;">
                                        <input type="button" id="search" class="btn btn-success" value="Tìm Phòng">
                                    </div>
                                    <div class="col-md-6 mb-3" style="position: relative;left: 60px;">
                                        <button type="submit"  class="btn btn-primary">Đặt Lịch</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="height: 50px"></div>
    @include ('layout.FooterClient')

    <script>
        const button = document.getElementById('search');
        button.addEventListener('click', () => {
            var _token = document.querySelector('input[name="_token"]').value;
            var maLP = document.getElementById('MaLP').value;
            var ngayDen = document.getElementById('NgayDen').value;
            var ngayDi = document.getElementById('NgayDi').value;
            var erorr ="Vui lòng chọn ";
            if(!ngayDen){
                erorr += "Ngày đến";
            }
            if(!ngayDi){
                erorr += " Ngày đi";
            }
            if(!ngayDen || !ngayDi){
                alert(erorr);
            }else{
                $.ajax({
                    url: "{{ url('client/search-so-luong-phong') }}",
                    method: "POST",
                    data: { maLP: maLP, ngayDen: ngayDen,ngayDi: ngayDi,_token:_token },
                    success: function (data) {
                        $("#sophong").html(data);
                    }
                });
            }
        });
    </script>

</body>
</html>
