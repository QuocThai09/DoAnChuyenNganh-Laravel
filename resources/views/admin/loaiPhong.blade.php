
<!DOCTYPE html>
<html lang="en">
<style>
    .centered-image {
        display: block;
        /* Hiển thị hình ảnh như một khối để có thể sử dụng margin */
        margin: 0 auto;
        /* Đặt margin tự động từ bên trái và phải để căn giữa theo chiều ngang */
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Painel Loại Phòng</title>
    @include ('layout.links')
    @include ('layout.essentials')
</head>

<body class="bg-light">
    @include ('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">LOẠI PHÒNG</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal"
                                data-bs-target="#add_typeRoom"><i class="bi bi-plus-square"></i>
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
                                        <th scope="col">Weekdays</th>
                                        <th scope="col">Holiday</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Introduce</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="room-data">
                                    <?php
                                    $i = 1;
                                    foreach($data as $item){
                                        ?>
                                        <tr style="text-align: center">
                                            <td >
                                                {{$i}}
                                            </td>
                                            <td>
                                                {{$item->MALOAIPHONG}}
                                            </td>
                                            <td>
                                                {{$item->TENLOAIPHONG}}
                                            </td>
                                            <td>
                                                {{number_format($item->GIANGAYTHUONG,0,'.','.')}}
                                            </td>
                                            <td>
                                                {{number_format($item->GIANGAYLE,0,'.','.')}}
                                            </td>
                                            <td>
                                                <?php
                                                $imagePath = "/images/typeRoom/" .$item->HINHLP;
                                                ?>
                                                <img class="centered-image" src="{{$imagePath}}"
                                                    alt="{{$item->TENLOAIPHONG}}" width="100">
                                            </td>
                                            <td>
                                                {{$item->LOAIGIUONG}}
                                            </td>
                                            <td>
                                                {{$item->SLGIUONG}}
                                            </td>
                                            <td style="text-align:justify;">
                                                {{$item->GIOITHIEULP}}
                                            </td>
                                            <td>
                                                {{$item->KHUYENMAILP}}
                                            </td>
                                            <?php
                                                $dataRoom = DB::table('phong')->where('MALOAIPHONG','=',$item->MALOAIPHONG)->first();
                                                if($dataRoom){
                                                    ?>
                                                        <td style="width: 120px">
                                                            <a data-bs-toggle="modal" data-bs-target="#update_typeRoom_{{$i}}"
                                                                class='btn btn-primary shadow-none'><i
                                                                    class='bi bi-pencil-square'></i></a>
                                                            <a class='btn btn-danger' style="pointer-events: none"><i class='bi bi-trash'></i></a>
                                                        </td>
                                                    <?php
                                                }else{
                                                    ?>
                                                        <td style="width: 120px">
                                                            <a data-bs-toggle="modal" data-bs-target="#update_typeRoom_{{$i}}"
                                                                class='btn btn-primary shadow-none'><i
                                                                    class='bi bi-pencil-square'></i></a>
                                                            <a onclick="return confirm('Bạn có muốn xóa loại phòng này không?');"
                                                                href="delete-loai-phong?MALOAIPHONG={{$item->MALOAIPHONG}}"
                                                                class='btn btn-danger'><i class='bi bi-trash'></i></a>
                                                        </td>
                                                    <?php
                                                }
                                            ?>
                                        </tr>
                                        <div class="modal fade" id="update_typeRoom_{{$i}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('updateTypeRoom') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Thêm khách hàng</h5>
                                                        </div>
                                    
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Mã loại phòng</label>
                                                                    <input type="text" name="MALOAIPHONG" class="form-control shadow-none" value="{{$item->MALOAIPHONG}}" required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Tên loại phòng</label>
                                                                    <input type="text" name="TENLOAIPHONG" class="form-control shadow-none" value="{{$item->TENLOAIPHONG}}" required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Giá ngày thường</label>
                                                                    <input type="number" name="GIANGAYTHUONG" class="form-control shadow-none" value="{{$item->GIANGAYTHUONG}}" required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Giá ngày lễ</label>
                                                                    <input type="number" name="GIANGAYLE" class="form-control shadow-none" value="{{$item->GIANGAYLE}}" required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Loại giường</label>
                                                                    <select id=combobox_loaigiuong class="form-control shadow-none" name="LOAIGIUONG">
                                                                        <option value="Giường đơn">Giường đơn</option>
                                                                        <option value="Giường đôi">Giường đôi</option>
                                                                        <option value="Giường Family">Giường Family</option>
                                                                        <option value="Giường 8 người">Giường 8 người</option>
                                                                    </select>
                                                                </div>
                                    
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Số lượng giường</label>
                                                                    <input type="number" name="SLGIUONG" class="form-control shadow-none" value="{{$item->SLGIUONG}}" required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Khuyến mãi loại phòng</label>
                                                                    <input type="text" name="KHUYENMAILP" class="form-control shadow-none" value="{{$item->KHUYENMAILP}}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label fw-bold">Ảnh loại phòng</label>
                                                                    <input type="file" name="HINHLP" class="form-control shadow-none" value="{{$item->HINHLP}}" required>
                                                                </div>
                                                                <div class="col mb-3">
                                                                    <label class="form-label fw-bold">Giới thiệu loại phòng</label>
                                                                    <textarea type="text" name="GIOITHIEULP" class="form-control shadow-none"  required 
                                                                    placeholder="Giới thiệu loại phòng ..."  cols="5" rows="4">{{$item->GIOITHIEULP}}
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Thêm loại phòng -->
    <div class="modal fade" id="add_typeRoom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('createTypeRoom')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thêm khách hàng</h5>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mã loại phòng</label>
                                <input type="text" name="MALOAIPHONG" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tên loại phòng</label>
                                <input type="text" name="TENLOAIPHONG" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá ngày thường</label>
                                <input type="number" name="GIANGAYTHUONG" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá ngày lễ</label>
                                <input type="number" name="GIANGAYLE" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Loại giường</label>
                                <select id=combobox_loaigiuong class="form-control shadow-none" name="LOAIGIUONG">
                                    <option value="Giường đơn">Giường đơn</option>
                                    <option value="Giường đôi">Giường đôi</option>
                                    <option value="Giường Family">Giường Family</option>
                                    <option value="Giường 8 người">Giường 8 người</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số lượng giường</label>
                                <input type="number" name="SLGIUONG" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Khuyến mãi loại phòng</label>
                                <input type="text" name="KHUYENMAILP" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ảnh loại phòng</label>
                                <input type="file" name="HINHLP" class="form-control shadow-none" required>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label fw-bold">Giới thiệu loại phòng</label>
                                <textarea type="text" name="GIOITHIEULP" class="form-control shadow-none" required 
                                placeholder="Giới thiệu loại phòng ..."  cols="5" rows="4">
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</body>

</html>