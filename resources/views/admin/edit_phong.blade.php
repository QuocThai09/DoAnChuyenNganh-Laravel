<?php
use Illuminate\Support\Facades\DB;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Painel Loại phòng</title>
    @include ('layout.links')
</head>

<body>
    @include ('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <form action="{{ route('updateRoom') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="font-weight: bold">Cập nhật thông tin phòng</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Mã phòng</label>
                                    <input type="text" name="MAPHONG" class="form-control shadow-none"
                                        value="{{$id}}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Số phòng</label>
                                    <input type="text" name="SOPHONG" class="form-control shadow-none"
                                        value="{{$data->SOPHONG}}">
                                </div>
                                {{-- <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Trạng thái phòng</label>
                                    <select id=combobox_trangthaip class="form-control shadow-none"
                                        name="TRANGTHAIPHONG">
                                        @if ($data->TRANGTHAIPHONG == 0)
                                            <option value="{{$data->TRANGTHAIPHONG}}" selected>CHƯA THUÊ</option>
                                            <option value="1">ĐÃ ĐƯỢC THUÊ</option>
                                        @else
                                            <option value="{{$data->TRANGTHAIPHONG}}" selected>ĐÃ ĐƯỢC THUÊ</option>
                                            <option value="0">CHƯA THUÊ</option>
                                        @endif
                                    </select>
                                </div>  --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ghi chú</label>
                                    <input type="text" name="GHICHU" class="form-control shadow-none"
                                        value="{{$data->GHICHU}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Loại phòng</label>
                                    <select id=combobox_trangthaip class="form-control shadow-none" name="MALOAIPHONG">
                                        @foreach ($dataLoaiPhong as $item)
                                            @if ($item->MALOAIPHONG == $data->MALOAIPHONG)
                                                <option value="{{$item->MALOAIPHONG}}" selected>{{$item->TENLOAIPHONG}}</option>
                                            @else
                                                <option value="{{$item->MALOAIPHONG}}">{{$item->TENLOAIPHONG}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tầng</label>
                                    <select id=combobox_trangthaip class="form-control shadow-none" name="MATANGLAU">
                                        @foreach ($dataTang as $item)
                                            @if ($item->MATANGLAU == $data->MATANGLAU)
                                                <option value="{{$item->MATANGLAU}}" selected>{{$item->MATANGLAU}}</option>
                                            @else
                                                <option value="{{$item->MATANGLAU}}">{{$item->MATANGLAU}}</option>
                                            @endif
                                        @endforeach
                                    </select>
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