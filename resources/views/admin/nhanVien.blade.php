
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Painel TÀI KHOẢN</title>
    @include ('layout.links')
    @include ('layout.essentials')
</head>

<body class="bg-light">
    @include ('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">DANH SÁCH NHÂN VIÊN</h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal"
                                data-bs-target="#add_loaiphong"><i class="bi bi-plus-square"></i>
                                ADD
                            </button>
                        </div>
                        <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light" style="text-align: center">
                                        <th scope="col">STT</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Position</th>
                                        <th scope="col">Birth date</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Account</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="room-data">
                                    <?php $i = 1; 
                                    foreach ($data as $item){
                                        if($id != "" && $id == $item->TAIKHOAN){
                                            ?>
                                                <tr style="text-align: center;background-color: #00FF33">
                                                    <td>
                                                        {{$i}}
                                                    </td>
                                                    <td style="width: 70px;">
                                                        {{$item->MANV}}
                                                    </td>
                                                    <td style="width: 170px;">
                                                        {{$item->HOTENNV}}
                                                    </td>
                                                    <td>
                                                        {{$item->CHUCVU}}
                                                    </td>
                                                    <td style="width: 110px;">
                                                        {{$item->NAMSINH}}
                                                    </td>
                                                    <td style="width: 90px;">
                                                        {{$item->GIOITINH}}
                                                    </td>
                                                    <td>
                                                        {{$item->DIACHI}}
                                                    </td>
                                                    <td style="width: 130px;">
                                                        {{$item->SDTNV}}
                                                    </td>
                                                    <td>
                                                        {{$item->TAIKHOAN}}
                                                    </td>
                                                    <td style="width: 110px;">
                                                        <a href="show-thong-tin-nhan-vien?MANV={{$item->MANV}}"
                                                            class='btn btn-primary shadow-none'><i
                                                                class='bi bi-pencil-square'></i></a>
                                                        <a onclick="return confirm('Bạn có muốn xóa nhân viên này không?');"
                                                            href="delete-thong-tin-nhan-vien?MANV={{$item->MANV}}&&TAIKHOAN={{$item->TAIKHOAN}}"
                                                            class='btn btn-danger'><i class='bi bi-trash'></i></a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }else{
                                            ?>
                                                <tr style="text-align: center">
                                                    <td>
                                                        {{$i}}
                                                    </td>
                                                    <td style="width: 70px;">
                                                        {{$item->MANV}}
                                                    </td>
                                                    <td style="width: 170px;">
                                                        {{$item->HOTENNV}}
                                                    </td>
                                                    <td>
                                                        {{$item->CHUCVU}}
                                                    </td>
                                                    <td style="width: 110px;">
                                                        {{$item->NAMSINH}}
                                                    </td>
                                                    <td style="width: 90px;">
                                                        {{$item->GIOITINH}}
                                                    </td>
                                                    <td>
                                                        {{$item->DIACHI}}
                                                    </td>
                                                    <td style="width: 130px;">
                                                        {{$item->SDTNV}}
                                                    </td>
                                                    <td>
                                                        {{$item->TAIKHOAN}}
                                                    </td>
                                                    <td style="width: 110px;">
                                                        <a href="show-thong-tin-nhan-vien?MANV={{$item->MANV}}"
                                                            class='btn btn-primary shadow-none'><i
                                                                class='bi bi-pencil-square'></i></a>
                                                        <a onclick="return confirm('Bạn có muốn xóa nhân viên này không?');"
                                                            href="delete-thong-tin-nhan-vien?MANV={{$item->MANV}}&&TAIKHOAN={{$item->TAIKHOAN}}"
                                                            class='btn btn-danger'><i class='bi bi-trash'></i></a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--Thêm nhân viên -->
    <div class="modal fade" id="add_loaiphong" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('createNhanVien') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thêm nhân viên mới </h5>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">ID</label>
                                <input type="text" name="MANV" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="HOTENNV" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Position</label>
                                <select id=combobox_chucvu class="form-control shadow-none" name="CHUCVU">
                                    <option value="0">Not value</option>
                                    <option value="Quản lý">Quản lý</option>
                                    <option value="Thu ngân">Thu ngân</option>
                                    <option value="Tiếp tân">Tiếp tân</option>
                                    <option value="Hỗ trợ">Hỗ trợ</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Birth date</label>
                                <input type="date" name="NAMSINH" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Gender</label>
                                <select id=combobox_Gioitinh class="form-control shadow-none" name="GIOITINH">
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <input type="text" name="DIACHI" class="form-control shadow-none" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="number" name="SDTNV" class="form-control shadow-none" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>