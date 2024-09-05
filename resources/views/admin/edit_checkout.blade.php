<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>CHECK OUT</title>
    @include ('layout.links')
    @include ('layout.essentials')
</head>

<body>
    @include ('layout.header')
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">CHECK OUT</h3>
                <form action="{{ route('createHD')}}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header"></div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Mã phiếu đặt</label>
                                    <input type="text" name="MAPHIEUDATPHONG" class="form-control shadow-none"
                                        value="{{$data->MAPHIEUDATPHONG}}" readonly>
                                </div>
                                <div style="display: none;">
                                    <label class="form-label fw-bold">Mã LOẠI PHÒNG</label>
                                    <input type="text" name="MALOAIPHONG" class="form-control shadow-none"
                                        value="{{$data->MALOAIPHONG}}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ngày nhận phòng</label>
                                    <input type="text" name="NGAYNHANPHONG" class="form-control shadow-none"
                                        value="{{$data->NGAYNHANPHONG}}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ngày trả phòng khi đặt</label>
                                    <input type="text" name="NGAYTRAPHONG" class="form-control shadow-none"
                                        value="{{$data->NGAYTRAPHONG}}" readonly>
                                </div>
                                <?php 
                                    $date = getdate();
                                    $ngay = $date['mday'];
                                    $thang = $date['mon'];
                                    $nam = $date['year'];
                                    $tNgayThucTe = $nam.'-'.$thang.'-'.$ngay;
                                ?>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ngày trả phòng thực tế</label>
                                    <input type="text" name="NGAYTHUCTE" class="form-control shadow-none"
                                        value="<?php echo $tNgayThucTe?>" readonly>
                                </div>
                                <?php
                                    $ngayTra = $data->NGAYNHANPHONG;
                                    $first_date = strtotime($ngayTra);
                                    $second_date = strtotime($tNgayThucTe);
                                    $datediff = abs($first_date - $second_date);
                                    $soNgayO = floor($datediff / (60*60*24));
                                ?>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Số ngày thuê</label>
                                    <input type="text" name="SONGAYTHUE" class="form-control shadow-none"
                                        value="<?php echo $soNgayO?>" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Họ tên Khách hàng</label>
                                    <input type="text" name="HOTENKH" class="form-control shadow-none"
                                        value="{{$data->HOTENKH}}" readonly>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tên loại phòng</label>
                                    <input type="text" name="TENLOAIPHONG" class="form-control shadow-none"
                                        value="{{$data->TENLOAIPHONG}}" readonly>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Phòng</label>
                                    <input type="text" name="SOPHONG" class="form-control shadow-none"
                                        value="{{$data->SOPHONG}}" readonly>
                                </div>
                                <div class="col-md-6 mb-3" style="display: none;">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Xác nhận hư hao</label><br>
                                    <?php 
                                        $i = 0;
                                        foreach($vatdung as $item){
                                            $soLuong = $item->SOLUONGVD;
                                            if($soLuong > 1){
                                                ?>
                                                    <p style="display: inline"><input type="checkbox" name="myCheckbox[]" value = "<?php echo $item->MAVATDUNG ?>">   <?php echo $item->TENVATDUNG ?>. Số lượng: </input></p>
                                                    <input type="number" name="SOLUONGHUHAO[]" class="form-control shadow-none" min="0" max="200" step="1" style="width: 50px; height: 30px;position: relative;top:0px; display: inline"
                                                        value="0">
                                                    <p style="display: inline"><input type="checkbox" name="vitriDV[]" value = "<?php echo $i ?>"> Xác nhận</input></p>
                                                        <br>
                                                        <br>
                                                <?php
                                                $i++;
                                            }else{
                                                ?>
                                                <p style="display: inline"><input type="checkbox" name="myCheckbox[]" value = "<?php echo $item->MAVATDUNG ?>">   <?php echo $item->TENVATDUNG ?></input></p>
                                                <input type="number" name="SOLUONGHUHAO[]" class="form-control shadow-none" min="0" max="200" step="1" style="width: 50px; height: 30px;position: relative;top:0px; display: inline;" readonly 
                                                        value="1">
                                                <p style="display: inline"><input type="checkbox" name="vitriDV[]" value = "<?php echo $i ?>"> Xác nhận</input></p>
                                                        <br>
                                                        <br>
                                                <?php
                                                $i++;
                                            }
                                            
                                        }
                                    ?>
                                </div>
                                <div class="col-md-6 mb-3">
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
                                                $i = 1;
                                                foreach($ctPDP as $item){
                                                    if(isset($item->DONGIADV)){
                                                        $tien = number_format($item->DONGIADV, 0, ',', '.');
                                                    }else{
                                                        $tien = 0;
                                                    }
                                                    if(isset($item->TONGTIEN)){
                                                        $tongtien = number_format($item->TONGTIEN, 0, ',', '.');
                                                    }else{
                                                        $tongtien = 0;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $i?></th>
                                                        <td><?php echo $item->TENDICHVU ?></td>
                                                        <td><?php echo $item->SOLANSD ?></td>
                                                        <td><?php echo $item->DVT ?></td>
                                                        <td><?php echo $tien ?></td>
                                                        <td><?php echo $tongtien ?></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            ?>

                                        </tbody>
                                    </table>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Khuyến mãi</label>
                                        <select id=combobox_sophong class="form-control shadow-none" name="KHUYENMAI">
                                            <option value= "0"> --Not value--</option> 
                                            @foreach($km as $item)
                                                <option value="<?php echo $item->MAKHUYENMAI ?>"><?php echo $item->TENKHUYENMAI ?></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div style="display: none;">
                                    <input type="text" name="MAKH" class="form-control shadow-none"
                                        value="{{$data->MAKH}}" readonly>
                                </div>
                                <?php 
                                    // $SOPHONG = $data->SOPHONG;
                                    // $editsql = "SELECT `MAPHONG`FROM `phong` WHERE `SOPHONG` = '$SOPHONG'";
                                    // $result = mysqli_query($conn, $editsql);
                                    // $row1 = mysqli_fetch_assoc($result);
                                ?>
                                <div style="display: none;">
                                    <input type="text" name="MAPHONG" class="form-control shadow-none"
                                        value="{{$data->MAPHONG}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="quay_lai_trang_truoc()" class="btn btn-outline-danger">CANCEL</button>
                            <button type="submit" class="btn btn-outline-success">
                            CHECK OUT
                            </button>
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