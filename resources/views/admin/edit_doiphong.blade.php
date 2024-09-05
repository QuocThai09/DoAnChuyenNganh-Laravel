
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi phòng</title>
    @include  ('layout.links')
</head>

<body>
    @include  ('layout.header')
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Xác nhận phòng cho khách hàng</h3>
                <form action="{{ route('updateRoom') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">

                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Mã phiếu đặt</label>
                                    <input type="text" name="MAPHIEUDATPHONG" class="form-control shadow-none"
                                        value="{{$data->MAPHIEUDATPHONG}}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ngày đặt phòng</label>
                                    <input type="text" name="NGAYDATPHONG" class="form-control shadow-none"
                                        value="{{$data->NGAYDATPHONG}}" readonly>
                                </div>
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
                                    <label class="form-label fw-bold">Phòng cũ</label>
                                    <input type="text" name="SOPHONG" class="form-control shadow-none"
                                        value="{{$data->SOPHONG}}" readonly>
                                </div>
                                <div class="col-md-6 mb-3" style="visibility: hidden;">
                                    <input type="text" name="MAKH" class="form-control shadow-none"
                                        value="{{$data->MAKH}}" readonly>
                                </div>
                                <div class="col-md-6 mb-3" style="visibility: hidden;">
                                    <input type="text" name="MALOAIPHONG" class="form-control shadow-none"
                                        value="{{$data->MALOAIPHONG}}" readonly>
                                </div>
                                <div class="col-md-6 mb-3" style="top:-85px;position: relative;">
                                    <label class="form-label fw-bold">Phòng mới</label>
                                    <select id=combobox_sophong class="form-control shadow-none" name="SOPHONGMOI">
                                        <?php
                                        foreach ($dataRoom as $item) {
                                            $trangthai = $item->TRANGTHAIPHONG;
                                            if ($trangthai == 0) {
                                                ?>
                                                <option value="{{$item->SOPHONG}}">
                                                    {{$item->SOPHONG}}
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="quay_lai_trang_truoc()"
                                class="btn btn-outline-danger">CANCEL</button>
                            <button type="submit" class="btn btn-outline-success">UPDATE</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>

</body>
<script>
    function quay_lai_trang_truoc() {
        history.back();
    }
</script>