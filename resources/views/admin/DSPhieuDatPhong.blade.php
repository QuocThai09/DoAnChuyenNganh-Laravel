<?php

// require_once 'essentials.php';
// require_once 'db_config.php';
// adminLogin();
use Illuminate\Support\Facades\DB;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
        @include('layout.links') 
        @include('layout.essentials')
    <title>Xác nhận đặt phòng</title>
</head>

<body>
    @include ('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">DANH SÁCH ĐẶT PHÒNG CHƯA XÁC NHẬN</h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body" style="height: 550px; overflow-y: scroll;">
                        <table class="table table-striped table-hover" style="width: 1130px">
                            <thead class="table-dark">
                                <tr style="text-align: center;">
                                    <th>STT</th>
                                    <th style="width: 100px">ID</th>
                                    <th style="width: 150px">Booking date</th>
                                    <th style="width: 120px">CheckIn</th>
                                    <th style="width: 180px">CheckOut</th>
                                    <th style="width: 170px">Customer</th>
                                    <th style="width: 220px">Kind of room</th>
                                    <th style="width: 10px">Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <?php
                            
                            // $dsPDP = "SELECT PD.*, KH.HOTENKH, LP.TENLOAIPHONG
                            //     FROM PHIEUDATPHONG PD
                            //     JOIN KHACHHANG KH ON PD.MAKH = KH.MAKH
                            //     JOIN LOAIPHONG LP ON PD.MALOAIPHONG = LP.MALOAIPHONG
                            //     ORDER BY PD.MAPHIEUDATPHONG";

                            // $result = mysqli_query($conn, $dsPDP);

                            $phieuDatPhong = DB::table('phieudatphong')
                                ->join('khachhang','phieudatphong.MAKH','=','khachhang.MAKH')
                                ->join('loaiphong','phieudatphong.MALOAIPHONG','=','loaiphong.MALOAIPHONG')
                                ->orderBy('MAPHIEUDATPHONG')
                                ->get();
                            $i = 1;
                            ?>
                            <div style="margin-top:25px">
                                <?php
                                    foreach ($phieuDatPhong as $item) {
                                        if(!isset($item->SOPHONG)){
                                            ?>
                                                <tr style="text-align: center;">
                                                    <td>
                                                        <?php echo $i ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item->MAPHIEUDATPHONG ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item->NGAYDATPHONG ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item->NGAYNHANPHONG ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item->NGAYTRAPHONG ?>
                                                    </td>
                                                    <td style="width: 200px">
                                                        <?php echo $item->HOTENKH ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item->TENLOAIPHONG ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item->SOPHONG ?>
                                                    </td>
                                                    <td> 
                                                        <a data-bs-toggle="modal" data-bs-target="#xacnhan_room_{{$i}}"
                                                            class='btn btn-primary shadow-none'>
                                                            <i class='bi bi-pencil-square'></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="xacnhan_room_{{$i}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{ route('editDatPhong') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-bold">Mã phiếu đặt</label>
                                                                            <input type="text" name="MAPHIEUDATPHONG" class="form-control shadow-none"
                                                                                value="{{$item->MAPHIEUDATPHONG}}" readonly>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-bold">Họ tên Khách hàng</label>
                                                                            <input type="text" name="HOTENKH" class="form-control shadow-none"
                                                                                value="{{$item->HOTENKH}}" readonly>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-bold">Ngày đặt phòng</label>
                                                                            <input type="text" name="NGAYDATPHONG" class="form-control shadow-none"
                                                                                value="{{$item->NGAYDATPHONG}}" readonly>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-bold">Ngày nhận phòng</label>
                                                                            <input type="text" name="NGAYNHANPHONG" class="form-control shadow-none"
                                                                                value="{{$item->NGAYNHANPHONG}}" readonly>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-bold">Ngày trả phòng</label>
                                                                            <input type="text" name="NGAYTRAPHONG" class="form-control shadow-none"
                                                                                value="{{$item->NGAYTRAPHONG}}" readonly>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-bold">Tên loại phòng</label>
                                                                            <input type="text" name="TENLOAIPHONG" class="form-control shadow-none"
                                                                                value="{{$item->TENLOAIPHONG}}" readonly>
                                                                        </div>
                                                                        <input type="hidden" name="MAKH" class="form-control shadow-none"
                                                                            value="{{$item->MAKH}}">
                                                                        <input type="hidden" name="MALOAIPHONG" class="form-control shadow-none"
                                                                            value="{{$item->MALOAIPHONG}}">
                                                                        <input type="hidden" name="TAIKHOAN" class="form-control shadow-none"
                                                                            value="{{$item->TAIKHOAN}}">
                                                                        <?php
                                                                        //SELECT * FROM phong WHERE MALOAIPHONG = '$maloaiphong'
                                                                        $select_room = DB::table('phong')
                                                                            ->where([
                                                                                ['MALOAIPHONG','=',$item->MALOAIPHONG],
                                                                                ['TRANGTHAIPHONG','=',0]
                                                                            ])
                                                                            ->get();
                                                                        ?>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-bold">Phòng</label>
                                                                            <select id=combobox_sophong class="form-control shadow-none" name="SOPHONG">
                                                                                @foreach ($select_room as $val)
                                                                                    <option value="{{$val->SOPHONG}}">
                                                                                        {{$val->SOPHONG}}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                        
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-outline-success">UPDATE</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php
                                            $i++;
                                        }
                                    }
                                ?>
                            </div>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>