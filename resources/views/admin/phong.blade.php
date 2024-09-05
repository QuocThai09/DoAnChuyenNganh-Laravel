
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Painel Phòng và Loại Phòng</title>
    @include ('layout.links')
    @include ('layout.essentials')
</head>

<body class="bg-light">
    @include ('layout.header')
    <div style="height: 60px;"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Danh sách PHÒNG</h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal"
                                data-bs-target="#add_phong"><i class="bi bi-plus-square"></i>
                                ADD
                            </button>
                        </div>
                        <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light" style="text-align: center">
                                        <th scope="col">#</th>
                                        <th scope="col">Mã phòng</th>
                                        <th scope="col">Số phòng</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Loại phòng</th>
                                        <th scope="col">Tầng lầu</th>
                                        <th scope="col">Ghi chú</th>
                                        <th scope="col">Action</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="room-data">
                                    <?php
                                    $i = 1;
                                    foreach($data as $item) {
                                        ?>

                                        <tr style="text-align: center">
                                            <td>
                                                {{$i}}
                                            </td>
                                            <td>
                                                {{$item->MAPHONG}}
                                            </td>
                                            <td>
                                                {{$item->SOPHONG}}
                                            </td>

                                            <td>
                                                <?php
                                                if ($item->TRANGTHAIPHONG == 0) {
                                                    echo ('CHƯA THUÊ');
                                                } else if ($item->TRANGTHAIPHONG == 1) {
                                                    echo ('ĐÃ ĐƯỢC THUÊ');
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                {{$item->TENLOAIPHONG}}
                                            </td>
                                            <td>
                                                {{$item->TENTANGLAU}}
                                            </td>
                                            <td>
                                                {{$item->GHICHU}}
                                            </td>
                                            @if ($item->TRANGTHAIPHONG == 1)
                                                <td>
                                                    <a class='btn btn-primary shadow-none' style="cursor: auto">
                                                        <i class='bi bi-pencil-square'></i>
                                                    </a>
                                                    <a class='btn btn-danger' style="cursor: auto">
                                                        <i class='bi bi-trash'></i>
                                                    </a>
                                                </td>
                                            @else
                                                <td><a href="show-thong-tin-phong?MAPHONG={{$item->MAPHONG}}"
                                                        class='btn btn-primary shadow-none'><i
                                                            class='bi bi-pencil-square'></i></a>
                                                    <a onclick="return confirm('Bạn có muốn xóa phòng này không?');"
                                                        href="delete-phong?MAPHONG={{$item->MAPHONG}}"
                                                        class='btn btn-danger'><i class='bi bi-trash'></i></a>
                                                </td>
                                            @endif
                                        </tr>
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
    <!-- Thêm phòng mới -->
    <div class="modal fade" id="add_phong" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('createRoom') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thêm phòng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mã phòng</label>
                                <input type="text" name="MAPHONG" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số phòng</label>
                                <input type="text" name="SOPHONG" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ghi chú</label>
                                <input type="text" name="GHICHU" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3" required>
                                <label class="form-label fw-bold">Loại phòng</label>
                                <select id=combobox_loaphong class="form-control shadow-none" name="MALOAIPHONG" required>
                                    @foreach ($dataLoaiPhong as $item)
                                            <option value="{{$item->MALOAIPHONG}}">{{$item->TENLOAIPHONG}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số tầng</label>
                                <select id=combobox_tang class="form-control shadow-none" name="MATANGLAU" required>
                                    @foreach ($dataTang as $item)
                                            <option value="{{$item->MATANGLAU}}">{{$item->TENTANGLAU}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn text-secondary shadow-none"
                                data-bs-dismiss="modal">CANCEL</button>
                            <button type="submit" class="btn custom-bg text-black shadow-none">SUBMIT</button>
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