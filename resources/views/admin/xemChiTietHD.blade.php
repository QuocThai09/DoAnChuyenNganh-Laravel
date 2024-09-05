    <?php 
        use Illuminate\Support\Facades\DB;
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <title>Thanh Toán</title>
        @include ('layout.links')
        @include ('layout.essentials')
    </head>

    <body>
        @include ('layout.header')
        <div style="height: 60px"></div>
        <div class="container-fluid" id="main-content">
            <div class="row">
                <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                    <h3 class="mb-4">CHI TIẾT HÓA ĐƠN</h3>
                    <form action="create_hoaDon.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Mã hóa đơn</label>
                                    <input type="text" name="MAPHIEUDATPHONG" class="form-control shadow-none"
                                    value="{{$id}}" readonly>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Khách hàng</label>
                                        <input type="text" name="HOTENKH" class="form-control shadow-none"
                                        value="{{$data->HOTENKH}}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Nhân viên</label>
                                        <input type="text" name="HOTENNV" class="form-control shadow-none"
                                        value="{{$data->HOTENNV}}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Số ngày thuê</label>
                                        <input type="text" name="SONGAYTHUE" class="form-control shadow-none"
                                            value="{{$data->SONGAYTHUE}}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3"></div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Ngày nhận phòng</label>
                                        <input type="text" name="NGAYNHANPHONG" class="form-control shadow-none"
                                            value="{{$data->NGAYNHANPHONG}}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Ngày trả phòng</label>
                                        <input type="text" name="NGAYTRAPHONG" class="form-control shadow-none"
                                            value="{{$data->NGAYTRAPHONG}}" readonly>
                                    </div>
                                    <?php 
                                        foreach($dataCTHD as $item){
                                            //SELECT PDP.*, KH.HOTENKH, LP.TENLOAIPHONG
                                            // FROM phieudatphong PDP
                                            // JOIN KHACHHANG KH ON PDP.MAKH = KH.MAKH
                                            // JOIN LOAIPHONG LP ON PDP.MALOAIPHONG = LP.MALOAIPHONG
                                            // WHERE PDP.MAPHIEUDATPHONG = '$maPhieu'
                                            $dataTTPhong = DB::table('phieudatphong')
                                                ->join('khachhang','phieudatphong.MAKH','=','khachhang.MAKH')
                                                ->join('loaiphong','phieudatphong.MALOAIPHONG','=','loaiphong.MALOAIPHONG')
                                                ->where('phieudatphong.MAPHIEUDATPHONG','=',$item->MAPHIEUDATPHONG)
                                                ->get();
                                            foreach ($dataTTPhong as $val) {
                                                ?>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Số phòng</label>
                                                        <input type="text" name="TENLOAIPHONG" class="form-control shadow-none"
                                                        value="{{$val->SOPHONG}}-{{$val->TENLOAIPHONG}}" readonly>
                                                    </div>
                                                    
                                                    <br>
                                                    <label class="form-label fw-bold">Dịch vụ đã sử dụng</label>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                            <th scope="col">STT</th>
                                                            <th scope="col">Tên dịch vụ</th>
                                                            <th scope="col">Số lần SD</th>
                                                            <th scope="col">DVT</th>
                                                            <th scope="col">Giá</th>
                                                            <th scope="col">Tổng tiền</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            //SELECT ch.*, dv.TENDICHVU, dv.DVT, dv.DONGIADV
                                                            // FROM chitietPDP ch
                                                            // JOIN dichvu dv ON ch.MADICHVU = dv.MADICHVU
                                                            // WHERE ch.MAPHIEUDATPHONG = '$maPhieu'"
                                                            $dataCTPDP = DB::table('chitietPDP')
                                                                ->join('dichvu','chitietPDP.MADICHVU','=','dichvu.MADICHVU')
                                                                ->where('chitietPDP.MAPHIEUDATPHONG','=',$item->MAPHIEUDATPHONG)
                                                                ->get();
                                                                $i = 1;
                                                                foreach ($dataCTPDP as $value) {
                                                                    if(isset($value->DONGIADV)){
                                                                        $tien = number_format($value->DONGIADV, 0, ',', '.');
                                                                    }else{
                                                                        $tien = 0;
                                                                    }
                                                                    if(isset($value->TONGTIEN)){
                                                                        $tongtien = number_format($value->TONGTIEN, 0, ',', '.');
                                                                    }else{
                                                                        $tongtien = 0;
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <th scope="row">{{$i}}</th>
                                                                        <td>{{$value->TENDICHVU}}</td>
                                                                        <td>{{$value->SOLANSD}}</td>
                                                                        <td>{{$value->DVT}}</td>
                                                                        <td>{{$tien}}</td>
                                                                        <td>{{$tongtien}}</td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <br>
                                                    <label class="form-label fw-bold">Đồ dùng bị hư hao</label>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                            <th scope="col">STT</th>
                                                            <th scope="col">Tên vật dụng</th>
                                                            <th scope="col">Giá</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            // SELECT hh.*, vd.TENVATDUNG, vd.GIAVD
                                                            // FROM huhao hh
                                                            // JOIN vatdung vd ON hh.MAVATDUNG = vd.MAVATDUNG
                                                            // WHERE hh.MAPHIEUDATPHONG = '$maPhieu'
                                                            $dataHuHao = DB::table('huhao')
                                                                ->join('vatdung','huhao.MAVATDUNG','=','vatdung.MAVATDUNG')
                                                                ->where('huhao.MAPHIEUDATPHONG','=',$item->MAPHIEUDATPHONG)
                                                                ->get();
                                                                $i = 1;
                                                                foreach ($dataHuHao as $value) {
                                                                    if(isset($value->GIAVD)){
                                                                        $tien = number_format($value->GIAVD, 0, ',', '.');
                                                                    }else{
                                                                        $tien = 0;
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <th scope="row">{{$i}}</th>
                                                                        <td>{{$value->TENVATDUNG}}</td>
                                                                        <td>{{$tien}}</td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <br>
                                                   <?php 
                                                     //SELECT `TONGTIENPDP` FROM `phieudatphong` WHERE `MAPHIEUDATPHONG` = '$maPhieu'
                                                     $dataTongTien =  DB::table('phieudatphong')
                                                            ->where('MAPHIEUDATPHONG','=',$item->MAPHIEUDATPHONG)
                                                            ->first();
                                                    $total = number_format($dataTongTien->TONGTIENPDP, 0, ',', '.');
                                                   ?>
                                                   {{-- <label class="form-label fw-bold">Tổng tiền</label>
                                                   <input type="text" name="TONGTIENPDP" class="form-control shadow-none"
                                                       value="{{$total}}" readonly>    --}}
                                                <?php
                                            }
                                        }
                                        $tien = number_format($data->THANHTIEN, 0, ',', '.');
                                    ?>
                                    <div class="col-md-6 mb-3" ></div>  
                                    <div>
                                        <label class="form-label fw-bold">Thông tin khuyến mãi</label>
                                        <p>{{$data->ThongTinKM}}</p>
                                    </div>
                                    <div class="col-md-6 mb-3" ></div>
                                    <div class="col-md-6 mb-3" ></div>
                                    <div class="col-md-6 mb-3" ></div>
                                    <div class="col-md-6 mb-3" style="width: 150px;position: relative;left: 330px;" >
                                        <label style="color: #FF3333;font-weight: bold;font-size: 28px;">{{$tien}}đ</label>
                                    </div>
                                    <div style="display: none;">
                                        <input type="text" name="MAKH" class="form-control shadow-none"
                                            value="{{$data->MAKH}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="quay_lai_trang_truoc()" class="btn btn-outline-danger">CANCEL</button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>

    </body>
    <script>
        function quay_lai_trang_truoc(){
            history.back();
        }
    </script>