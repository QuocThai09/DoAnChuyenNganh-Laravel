
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
    @include ('layout.links')
    @include ('layout.essentials')
    <title>Khách hàng</title>
</head>

<body>
    @include ('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">DANH SÁCH KHÁCH HÀNG</h3>
                <div class="card border-0 shadow-sm mb-4" style="margin-top: -20px">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal"
                                data-bs-target="#add_customer"><i class="bi bi-plus-square"></i>
                                ADD
                            </button>
                        </div>
                        <div style="overflow-y: scroll;height: 450px;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light" style="text-align: center">
                                        <th>STT</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>CMND</th>
                                        <th>Type</th>
                                        <th>Account</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                foreach ($data as $item){
                                    if($id != "" && $id == $item->TAIKHOAN){
                                        ?>
                                            <tr style="text-align: center;background-color: #00FF33">
                                                <td>
                                                    <?php echo $i ?>
                                                </td>
                                                <td>
                                                    {{$item->MAKH}}
                                                </td>
                                                <td>
                                                    {{$item->HOTENKH}}
                                                </td>
                                                <td>
                                                    {{$item->SDTKH}}
                                                </td>
                                                <td>
                                                    {{$item->CMNDKH}}
                                                </td>
                                                <td>
                                                    @if ($item->LOAIKHACHHANG == 0)
                                                        Normal
                                                    @else
                                                        VIP
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$item->TAIKHOAN}}
                                                </td>
                                                <td style="text-align: center">
                                                <a href="show-khach-hang?MAKH={{$item->MAKH}}"
                                                        class='btn btn-primary shadow-none'><i class='bi bi-pencil-square'></i>
                                                    </a>
                                                </td>
        
                                            </tr>
                                        <?php
                                    }else{
                                        ?>
                                            <tr style="text-align: center;">
                                                <td>
                                                    <?php echo $i ?>
                                                </td>
                                                <td>
                                                    {{$item->MAKH}}
                                                </td>
                                                <td>
                                                    {{$item->HOTENKH}}
                                                </td>
                                                <td>
                                                    {{$item->SDTKH}}
                                                </td>
                                                <td>
                                                    {{$item->CMNDKH}}
                                                </td>
                                                <td>
                                                    @if ($item->LOAIKHACHHANG == 0)
                                                        Normal
                                                    @else
                                                        VIP
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$item->TAIKHOAN}}
                                                </td>
                                                <td style="text-align: center">
                                                <a href="show-khach-hang?MAKH={{$item->MAKH}}"
                                                        class='btn btn-primary shadow-none'><i class='bi bi-pencil-square'></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                    $i++;
                                }
                                ?>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal thêm khách hàng -->
    <div class="modal fade" id="add_customer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
                <form action="{{ route('createCustomer') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Customer</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">ID</label>
                                    <input type="text" name="MAKH" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <input type="text" name="HOTENKH" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Phone</label>
                                    <input type="number" name="SDTKH" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">CMND</label>
                                    <input type="number" name="CMNDKH" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Type</label>
                                    <select id=combobox_loaikh class="form-control shadow-none" name="LOAIKHACHHANG">
                                        <option value="0">Normal Customer</option>
                                        <option value="1">VIP Customer</option>
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

</body>

</html>