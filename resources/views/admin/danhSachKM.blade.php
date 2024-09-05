
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
    <title>khuyến mãi</title>
</head>

<body>
    @include ('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">DANH SÁCH KHUYẾN MÃI</h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal"
                                data-bs-target="#add_discount"><i class="bi bi-plus-square"></i>
                                ADD
                            </button>
                        </div>
                        <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light" style="text-align: center">
                                        <th >STT</th>
                                        <th>Mã khuyến mãi</th>
                                        <th>Tên khuyến mãi</th>
                                        <th >Discount</th>
                                        <th >Trạng thái</th>
                                        <th >Action</th>
                                    </tr>
                                </thead>

                            <?php
                            $i = 1;
                            foreach($data as $item){
                                ?>
                                <tr style="text-align: center">
                                    <td >
                                        {{$i}}
                                    </td>
                                    <td>
                                        {{$item->MAKHUYENMAI}}
                                    </td>
                                    <td>
                                        {{$item->TENKHUYENMAI}}
                                    </td>
                                    <td >
                                        {{$item->DISCOUNT}}
                                    </td>
                                    @if ($item->TRANGTHAIKHUYENMAI == 1)
                                        <td style="color: green">
                                            ON
                                        </td>
                                    @else
                                        <td style="color: red">
                                            OFF
                                        </td>
                                    @endif
                                    <td ><a data-bs-toggle="modal" data-bs-target="#update_discount_{{$i}}"
                                            class='btn btn-primary shadow-none'><i class='bi bi-pencil-square'></i></a>
                                        <a onclick="return confirm('Bạn có muốn xóa khuyến mãi này không???');"
                                            href="delete-khuyen-mai?MAKHUYENMAI={{$item->MAKHUYENMAI}}"
                                            class='btn btn-danger'><i class='bi bi-trash'></i></a>
                                    </td>

                                </tr>
                                {{-- update discount --}}
                                <div class="modal fade" id="update_discount_{{$i}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('updateDiscount') }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Update khuyến mãi</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Mã khuyến mãi</label>
                                                            <input type="text" name="MAKHUYENMAI" class="form-control shadow-none" readonly value="{{$item->MAKHUYENMAI}}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Tên khuyến mãi</label>
                                                            <input type="text" name="TENKHUYENMAI" class="form-control shadow-none" value="{{$item->TENKHUYENMAI}}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Discount</label>
                                                            <input type="text" name="DISCOUNT" class="form-control shadow-none" value="{{$item->DISCOUNT}}">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Loại</label>
                                                            <select id=combobox_loaikh class="form-control shadow-none" name="TRANGTHAIKHUYENMAI">
                                                                @if ($item->TRANGTHAIKHUYENMAI ==  1)
                                                                    <option value="0">Tạm ngừng</option>
                                                                    <option value="1" selected>Đang hoạt động</option>
                                                                @else
                                                                    <option value="0" selected>Tạm ngừng</option>
                                                                    <option value="1">Đang hoạt động</option>
                                                                @endif
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

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal thêm khuyến mãi -->
    <div class="modal fade" id="add_discount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('createDiscount') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thêm khuyến mãi</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mã khuyến mãi</label>
                                <input type="text" name="MAKHUYENMAI" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tên khuyến mãi</label>
                                <input type="text" name="TENKHUYENMAI" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Discount</label>
                                <input type="text" name="DISCOUNT" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Loại</label>
                                <select id=combobox_loaikh class="form-control shadow-none" name="TRANGTHAIKHUYENMAI">
                                    <option value="0">Tạm ngừng</option>
                                    <option value="1" selected>Đang hoạt động</option>
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

</body>

</html>