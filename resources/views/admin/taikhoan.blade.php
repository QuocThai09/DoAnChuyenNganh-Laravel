
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Painel TÀI KHOẢN</title>
    @include  ('layout.links')
    @include  ('layout.essentials')
</head>

<body class="bg-light">
    @include  ('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">TÀI KHOẢN</h3>
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
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Tài khoản</th>
                                        <th scope="col">Quyền</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody id="room-data">
                                    <?php
                                    $i = 1;
                                    foreach ($data as $item) {
                                        ?>
                                        <tr>
                                            <td>
                                                {{$i}}
                                            </td>
                                            <td>
                                                {{$item->TAIKHOAN}}
                                            </td>
                                            <td>
                                                <?php
                                                if ($item->MAPQ == 1) {
                                                    echo ('Admin');
                                                }
                                                if ($item->MAPQ == 2) {
                                                    echo ('Nhân viên');
                                                }
                                                if ($item->MAPQ == 3) {
                                                    echo ('Khách hàng');
                                                }
                                                ?>
                                            </td>
                                            
                                            <?php
                                                $TK_NV = DB::table('nhanvien')->where('TAIKHOAN','=',$item->TAIKHOAN)->first();
                                                $TK_KH = DB::table('khachhang')->where('TAIKHOAN','=',$item->TAIKHOAN)->first();
                                                if($TK_NV == null){
                                                    if($TK_KH == null){
                                                        ?>
                                                            <td>
                                                                <label style="color:brown">OFF</label>
                                                            </td>
                                                            <td>
                                                                <a data-bs-toggle="modal" data-bs-target="#edit_taikhoan_{{$i}}"
                                                                    class='btn btn-primary shadow-none'><i
                                                                        class='bi bi-pencil-square'></i></a>
                                                                <a onclick="return confirm('Bạn có muốn xóa tài khoản này không?');"
                                                                    href="delete-tai-khoan?TAIKHOAN={{$item->TAIKHOAN}}"
                                                                    class='btn btn-danger'><i class='bi bi-trash'></i></a>
                                                            </td>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <td>
                                                                <label style="color: #33CC00">ON</label>
                                                            </td>
                                                            <td>
                                                                <a data-bs-toggle="modal" data-bs-target="#edit_taikhoan_{{$i}}"
                                                                    class='btn btn-primary shadow-none'><i
                                                                        class='bi bi-pencil-square'></i></a>
                                                                <a href="khach-hang?TAIKHOAN={{$item->TAIKHOAN}}"
                                                                    class='btn btn-success'>
                                                                    <i class="bi bi-arrow-right-circle"></i>
                                                                </a>
                                                            </td>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                        <td>
                                                            <label style="color: #33CC00">ON</label>
                                                        </td>
                                                        <td>
                                                            <a data-bs-toggle="modal" data-bs-target="#edit_taikhoan_{{$i}}"
                                                                    class='btn btn-primary shadow-none'><i
                                                                        class='bi bi-pencil-square'></i></a>
                                                            <a href="nhan-vien?TAIKHOAN={{$item->TAIKHOAN}}"
                                                                class='btn btn-success'>
                                                                <i class="bi bi-arrow-right-circle"></i>
                                                            </a>
                                                        </td>
                                                    <?php                                                   
                                                }
                                            ?>
                                        </tr>
                                        <!-- Edit tài khoản -->
                                        <div class="modal fade" id="edit_taikhoan_{{$i}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('updateAccount') }}" method="post">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Sửa tài khoản</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Tài khoản</label>
                                                                    <input type="text" name="TAIKHOAN" class="form-control shadow-none"
                                                                        value="{{$item->TAIKHOAN}}" readonly>
                                                                </div>
                                                                <div class=" col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Phân quyền</label>
                                                                    <select id=combobox_loaigiuong class="form-control shadow-none" name="MAPQ">
                                                                        @foreach ($dataPhanQuyen as $n)
                                                                            @if ($n->MAPQ == $item->MAPQ)
                                                                                <option selected value="{{$n->MAPQ}}">{{$n->TENQUYEN}}</option>
                                                                                <?php  continue;?>
                                                                            @endif
                                                                            <option value="{{$n->MAPQ}}">{{$n->TENQUYEN}}</option>
                                                                        @endforeach
                                                                    </select>
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
                                        <?php
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
    <!--Thêm tài khoản -->
    <div class="modal fade" id="add_loaiphong" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('createAccount')}}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thêm tài khoản</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-8">
                                <label class="form-label fw-bold">Tên tài khoản</label>
                                <input type="text" name="TAIKHOAN" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mật khẩu</label>
                                <input type="text" name="MATKHAU" class="form-control shadow-none" value="123" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Phân quyền</label>
                                <select id="combobox_loaigiuong" class="form-control shadow-none" name="MAPQ" required>
                                    <option value="0">--Hãy chọn quyền--</option>
                                    @foreach ($dataPhanQuyen as $item)
                                        <option value="{{$item->MAPQ}}">{{$item->TENQUYEN}}</option>
                                    @endforeach
                                </select>
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
    <?php


    if (isset($_SESSION['successMessage'])) {
        echo "<div class='alert alert-success'>" . $_SESSION['successMessage'] . "</div>";
        unset($_SESSION['successMessage']); // Clear the session variable
    }

    if (isset($_SESSION['errorMessage'])) {
        echo "<div class='alert alert-danger'>" . $_SESSION['errorMessage'] . "</div>";
        unset($_SESSION['errorMessage']); // Clear the session variable
    }
    ?>

</body>

</html>