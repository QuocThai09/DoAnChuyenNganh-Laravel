<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đồ Án Khách Sạn</title>
    @include ('layout.linkClient')
    <style>
        .btn-thanh-toan {
            background-color: #007bff;
            /* Màu xanh dương */
        }
    </style>
</head>


<body bg-light>
    @include ('layout.HeaderClient')
    <h2 class="mt-5 pt-4 mb-2 text-center fw-bold h-font">Lịch Đặt Phòng</h2>
    <div class="bg-dark" style="width: 150px; height: 1.7px; margin: 0 auto;"></div>
    <div class="container">
        <div class="row">
            @foreach ($data as $item)
                <div class="col-md-4 px-4 mb-4 mt-5">
                    <div class="card border-0 bg-white p-4 rounded shadow">
                        <h5 class="fw-bold">
                            {{$item->TENLOAIPHONG}}
                        </h5>
                        <p>
                            <b>Ngày Nhận Phòng : </b>
                            {{$item->NGAYNHANPHONG}}<br>
                            <b>Ngày Trả Phòng : </b>
                            {{$item->NGAYTRAPHONG}}
                        </p>
                        <p>
                            <b>Ngày Đặt Phòng : </b>
                            {{$item->NGAYDATPHONG}}<br>
                            <b>Số Phòng : </b>
                            {{$item->SOPHONG}}<br>
                            <b>Giá : </b>
                            {{tinh_Tien($item->MALOAIPHONG, $item->NGAYNHANPHONG, $item->NGAYTRAPHONG)}}<br>
                        </p>
                        @if ($item->SOPHONG != null)
                            <p>
                                <span class="badge bg-success">Đã xác nhận</span>
                            </p>
                        @else
                            <p>
                                <span class="badge bg-danger">Chưa xác nhận</span>
                            </p>
                        @endif
                        <div class="row">
                            <div class="col-6">
                                <form method="post" action="{{ route('remove-dat-phong') }}">
                                    @csrf
                                    <input type="hidden" name="MAPHIEUDATPHONG"
                                        value="{{$item->MAPHIEUDATPHONG}}">
                                    <input type="hidden" name="NGAYDATPHONG" value="{{$item->NGAYDATPHONG}}">
                                    <input type="hidden" name="NGAYNHANPHONG" value="{{$item->NGAYNHANPHONG}}">
                                    <button type="submit" class="btn w-100 text-white bg-dark shadow-none mb-1"
                                        onclick=" return confirm('Bạn có muốn hủy đặt phòng không?')">Hủy</button>
                                </form>
                            </div>
                            <div class="col-6">
                                <form method="post">
                                    <input type="hidden" name="MAPHIEUDATPHONG"
                                        value="{{$item->MAPHIEUDATPHONG}}>">
                                    @if (loc_DanhGia($item->MAPHIEUDATPHONG))
                                        <button type="button" class="btn w-100  btn-primary shadow-none mb-1" disabled>Đã Đánh
                                        Giá</button>
                                    @else
                                        @if ($item->TRANGTHAI == 2)
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#DanhGia_{{$item->MAPHIEUDATPHONG}}"
                                            class="btn w-100 text-white bg-dark shadow-none mb-1">Đánh Giá</button>
                                        @else
                                        <button type="button" class="btn w-100 text-white bg-secondary shadow-none mb-1" disabled>Đánh Giá</button>
                                        @endif
                                    
                                    @endif
                                </form>
                            </div>
                            <div class="col-6">
                                @if ($item->TRANGTHAI != 0)
                                    <button name="ThanhToan" class="btn w-100 text-white btn-thanh-toan shadow-none mb-1"
                                    disabled style="cursor: all-scroll">Đã Đặt Cọc</button>    
                                @else
                                    <form action="{{ route('vnpay-payment') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="maPDP" value="{{$item->MAPHIEUDATPHONG}}">
                                        <input type="hidden" name="total" value="{{$item->TONGTIENPDP}}">
                                        <button  type="submit" name="ThanhToan" class="btn w-100 text-white bg-dark shadow-none mb-1">
                                            Thanh Toán VNPAY
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- Đánh Giá -->
                <div class="modal fade" id="DanhGia_{{$item->MAPHIEUDATPHONG}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('add-feed-back') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="bi bi-star-fill fs-3 me-2"></i>ĐÁNH GIÁ VÀ NHẬN XÉT
                                </h5>
                                <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Đánh Giá </label>
                                    <select class="form-select" name="Rating">
                                        <option value="5" selected>Rất Tốt</option>
                                        <option value="4">Tốt</option>
                                        <option value="3">Bình Thường</option>
                                        <option value="2">Tệ</option>
                                        <option value="1">Rất Tệ</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nhận Xét</label>
                                    <textarea rows="5" class="form-control shadow-none" name="review" required></textarea>
                                </div>
                                <div>
                                    <input type="hidden" name="maPDP" value="{{$item->MAPHIEUDATPHONG}}">
                                    <input type="submit" class="btn btn-dark shadow-none btn-sm" name="DanhGia"
                                        value="ĐÁNH GIÁ">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    @include ('layout.FooterClient')
</body>

</html>