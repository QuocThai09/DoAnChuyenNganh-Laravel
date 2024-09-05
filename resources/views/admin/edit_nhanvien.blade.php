
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Painel Loại phòng</title>
    @include ('layout.links')
    @include ('layout.essentials')
</head>

<body>
    @include ('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <form action="{{ route('updateNhanVien') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Cập nhật thông tin NHÂN VIÊN</h5>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">ID</label>
                                    <input type="text" name="MANV" class="form-control shadow-none"
                                        value="{{$id}}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <input type="text" name="HOTENNV" class="form-control shadow-none" required
                                        value="{{$data->HOTENNV}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Position</label>
                                    <select id=combobox_chucvu class="form-control shadow-none" name="CHUCVU">
                                        <option value="Quản lý">Quản lý</option>
                                        <option value="Thu ngân">Thu ngân</option>
                                        <option value="Tiếp tân">Tiếp tân</option>
                                        <option value="Hỗ trợ">Hỗ trợ</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Birth date</label>
                                    <input type="date" name="NAMSINH" class="form-control shadow-none"
                                        value="{{$data->NAMSINH}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Gender</label>
                                    <select id=combobox_gioitinh class="form-control shadow-none" name="GIOITINH">
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <input type="text" name="DIACHI" class="form-control shadow-none"
                                        value="{{$data->DIACHI}}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Phone</label>
                                    <input type="text" name="SDTNV" class="form-control shadow-none"
                                        value="{{$data->SDTNV}}" required>
                                </div>
                                <?php
                                    if($data->TAIKHOAN == null){
                                        ?>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Chọn tài khoản</label>
                                                <select name="TAIKHOAN" class="form-select shadow-none" required>
                                                    <option value="0">Not value</option>
                                                    @foreach ($dataAccount as $item)
                                                        <option value="{{$item->TAIKHOAN}}">{{$item->TAIKHOAN}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        <?php
                                    }else{
                                        ?>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Account</label>
                                                <input type="text" name="SDTNV" class="form-control shadow-none"
                                                    value="{{$data->TAIKHOAN}}" readonly>
                                            </div>
                                        <?php
                                    }
                                ?>
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