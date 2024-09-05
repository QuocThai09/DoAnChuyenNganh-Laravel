<?php 
use Illuminate\Support\Facades\DB;
?>
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
    <title>Dịch vụ</title>
</head>

<body>
    @include ('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">DANH SÁCH DỊCH VỤ</h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal"
                                data-bs-target="#add_service"><i class="bi bi-plus-square"></i>
                                ADD
                            </button>
                        </div>
                        <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light" style="text-align: center">
                                        <th >STT</th>
                                        <th>Mã dịch vụ</th>
                                        <th>Tên dịch vụ</th>
                                        <th>Đơn giá</th>
                                        <th>Đơn vị tính</th>
                                        <th>Giới thiệu</th>
                                        <th>Hình ảnh</th>
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
                                            {{$item->MADICHVU}}
                                        </td>
                                        <td>
                                            {{$item->TENDICHVU}}
                                        </td>
                                        <td>
                                            {{$item->DONGIADV}}
                                        </td>
                                        <td>
                                            {{$item->DVT}}
                                        </td>
                                        <td style="width: 300px;text-align:justify;">
                                            {{$item->GIOITHIEUDV}}
                                        </td>
                                        <td>
                                            <?php
                                            $imagePath = "/images/service/" .$item->HINHDV;
                                            ?>
                                            <img class="centered-image" src="{{$imagePath}}"
                                                alt="{{$item->TENDICHVU}}" width="50">
                                        </td>
                                        @if ($item->TRANGTHAIDICHVU == 1)
                                            <td style="text-align: center;color: green">
                                                ON
                                            </td>
                                        @else
                                            <td style="text-align: center;color:red">
                                                OFF
                                            </td>
                                        @endif
                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#update_service_{{$i}}"
                                                class='btn btn-primary shadow-none'><i
                                                    class='bi bi-pencil-square'></i></a>
                                            <a onclick="return confirm('Bạn có muốn xóa dịch vụ này không?');"
                                                href="delete-dich-vu?MADICHVU={{$item->MADICHVU}}"
                                                class='btn btn-danger'><i class='bi bi-trash'></i></a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="update_service_{{$i}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('updateService') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">
                                                            Cập nhật thông tin dịch vụ
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Mã dịch vụ</label>
                                                                <input type="text" name="MADICHVU" class="form-control shadow-none" value="{{$item->MADICHVU}}" readonly>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Tên dịch vụ</label>
                                                                <input type="text" name="TENDICHVU" class="form-control shadow-none" value="{{$item->TENDICHVU}}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Đơn giá</label>
                                                                <input type="number" name="DONGIADV" class="form-control shadow-none" value="{{$item->DONGIADV}}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">DVT</label>
                                                                <input type="text" name="DVT" class="form-control shadow-none" value="{{$item->DVT}}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Ảnh</label>
                                                                <input type="file" name="image" class="form-control shadow-none" accept="image/*" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Trạng thái</label>
                                                                <select id=combobox_loaikh class="form-control shadow-none" name="TRANGTHAIDICHVU">
                                                                    
                                                                    @if ($item->TRANGTHAIDICHVU == 1)
                                                                        <option value="1" selected>Đang hoạt động</option>
                                                                        <option value="0">Tạm ngừng</option>    
                                                                    @else
                                                                        <option value="1" >Đang hoạt động</option>
                                                                        <option value="0" selected>Tạm ngừng</option>
                                                                    @endif
                                                                    
                                                                </select>
                                                            </div>
                                                            <div class="col mb-3">
                                                                <label class="form-label fw-bold">Giới thiệu dịch vụ</label>
                                                                <textarea name="GIOITHIEUDV" id="" cols="10" rows="5" class="form-control shadow-none">{{$item->GIOITHIEUDV}}
                                                                </textarea>
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
    </div>


    <!-- Modal thêm dịch vụ -->
    <div class="modal fade" id="add_service" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('createService') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thêm dịch vụ</h5>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mã dịch vụ</label>
                                <input type="text" name="MADICHVU" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tên dịch vụ</label>
                                <input type="text" name="TENDICHVU" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Đơn giá</label>
                                <input type="number" name="DONGIADV" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">DVT</label>
                                <input type="text" name="DVT" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ảnh</label>
                                <input type="file" name="image" class="form-control shadow-none" accept="image/*" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Trạng thái</label>
                                <select id=combobox_loaikh class="form-control shadow-none" name="TRANGTHAIDICHVU">
                                    <option value="0" selected>Tạm ngừng</option>
                                    <option value="1">Đang hoạt động</option>
                                </select>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label fw-bold">Giới thiệu dịch vụ</label>
                                <textarea name="GIOITHIEUDV" id="" cols="10" rows="5" class="form-control shadow-none"
                                placeholder="Giới thiệu dịch vụ ..." required>
                                </textarea>
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