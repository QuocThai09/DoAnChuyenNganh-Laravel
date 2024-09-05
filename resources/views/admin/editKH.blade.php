
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Painel Khách hàng</title>
    @include ('layout.links')
    @include ('layout.essentials')

</head>

<body>
    @include ('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <form action="{{ route('updateCustomer') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Cập nhật thông tin khách hàng</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">ID</label>
                                    <input type="text" name="MAKH" class="form-control shadow-none"
                                        value="{{$id}}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <input type="text" name="HOTENKH" class="form-control shadow-none"
                                        value="{{$data->HOTENKH}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Phone</label>
                                    <input type="text" name="SDTKH" class="form-control shadow-none"
                                        value="{{$data->SDTKH}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">CMND</label>
                                    <input type="text" name="CMNDKH" class="form-control shadow-none"
                                        value="{{$data->CMNDKH}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Type</label>
                                    <select id=combobox_loaikh class="form-control shadow-none" name="LOAIKHACHHANG">
                                        <option value="0">Normal Customer</option>
                                        <option value="1">VIP Customer</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Account</label>
                                    <input type="text" name="TAIKHOAN" class="form-control shadow-none"
                                        value="{{$data->TAIKHOAN}}" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <a href="khach-hang" class='btn btn-outline-secondary'>CANCEL</a>
                            <button type="submit" class="btn btn-outline-success">UPDATE</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>

</body>