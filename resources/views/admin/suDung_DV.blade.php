
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
    @include('layout.links')
    @include('layout.essentials')
    <title>Dịch vụ</title>
</head>

<body>
    @include('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">DANH SÁCH DỊCH VỤ ĐÃ SỬ DỤNG</h3>
                <div class="card border-0 shadow-sm mb-4" style="margin-top: -20px;">
                    <div class="card-body" style="overflow-y: scroll; height: 200px;">
                        <table class="table table-striped table-hover" style="">
                            <thead class="table-dark"  style="position: absolute; top:0px;">
                                <tr style="text-align: center">
                                    <th style="width: 100px">STT</th>
                                    <th style="width: 520px;text-align: left">Name</th>
                                    <th style="width: 150px">Price</th>
                                    <th style="width: 40px">Quantity</th>
                                    <th style="width: 100px;">Unit</th>
                                    <th style="width: 190px">Total</th>
                                </tr>
                            </thead>
                            <?php $i= 1;?>
                            <div style="margin-top: 25px">
                                @foreach($ctPDP as $item)
                                    <?php
                                        $tien = number_format($item->TONGTIEN, 0, ',', '.');
                                        $dongia = number_format($item->DONGIADV, 0, ',', '.');
                                        ?>
                                        <tr style="text-align: center;">
                                            <td style="width: 100px">
                                                <?php echo $i ?>
                                            </td>
                                            <td style="text-align: left;width: 600px;">
                                                <?php echo $item->TENDICHVU ?>
                                            </td>
                                            <td style="width: 150px;">
                                                <?php echo $dongia ?>
                                            </td>
                                            <td style="width: 90px;">
                                                <?php echo $item->SOLANSD ?>
                                            </td>
                                            <td style="width: 100px;">
                                                <?php echo $item->DVT ?>
                                            </td>
                                            <td style="width: 200px;">
                                                <?php echo $tien ?>
                                            </td>
                                        </tr>
                                        <?php $i++;?>
                                @endforeach
                            </div>
                        </table>
                    </div>
                </div>
                <h3 class="mb-4">DANH SÁCH DỊCH VỤ</h3>
                <div class="card border-0 shadow-sm mb-4" style="margin-top: -10px">
                    <div class="card-body" style="overflow-y: scroll;height: 290px; width: 1197px;">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark" style="position: absolute; top:0px;">
                                <tr style="text-align: center">
                                    <th>STT</th>
                                    <th style="width: 60px">ID</th>
                                    <th style="text-align: left;width: 300px">Name</th>
                                    <th style="width:110px">Price</th>
                                    <th style="width: 60px">Unit</th>
                                    <th style="text-align: left;width: 390px;">Introduce</th>
                                    <th style="width: 120px">Image</th>
                                    <th style="width: 0px">Action</th>
                                </tr>
                            </thead>
                            <?php $i= 1;?>
                            <div style="margin-top: 25px">
                                @foreach($dv as $item)
                                    <?php
                                    $tien = number_format($item->DONGIADV, 0, ',', '.');
                                    ?>

                                    <tr style="text-align: center">
                                        <td>
                                            <?php echo $i ?>
                                        </td>
                                        <td>
                                            <?php echo $item->MADICHVU ?>
                                        </td>
                                        <td style="text-align: left;width: 300px">
                                            <?php echo $item->TENDICHVU ?>
                                        </td>
                                        <td>
                                            <?php echo $tien ?>
                                        </td>
                                        <td>
                                            <?php echo $item->DVT ?>
                                        </td>
                                        <td style="text-align: left;width: 400px;">
                                            <?php echo $item->GIOITHIEUDV ?>
                                        </td>
                                        <td>
                                            <img class="centered-image" src="/images/service/{{$item->HINHDV}}"
                                                alt="{{$item->TENDICHVU}}" width="50">
                                        </td>
                                        <td style="text-align: center">
                                            <a class='btn btn-success' data-bs-toggle="modal" data-bs-target="#add_DV_to_HD_<?php echo $item->MADICHVU?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-plus-circle-dotted" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 0c-.176 0-.35.006-.523.017l.064.998a7.117 7.117 0 0 1 .918 0l.064-.998A8.113 8.113 0 0 0 8 0M6.44.152c-.346.069-.684.16-1.012.27l.321.948c.287-.098.582-.177.884-.237L6.44.153zm4.132.271a7.946 7.946 0 0 0-1.011-.27l-.194.98c.302.06.597.14.884.237l.321-.947zm1.873.925a8 8 0 0 0-.906-.524l-.443.896c.275.136.54.29.793.459l.556-.831zM4.46.824c-.314.155-.616.33-.905.524l.556.83a7.07 7.07 0 0 1 .793-.458zM2.725 1.985c-.262.23-.51.478-.74.74l.752.66c.202-.23.418-.446.648-.648l-.66-.752zm11.29.74a8.058 8.058 0 0 0-.74-.74l-.66.752c.23.202.447.418.648.648l.752-.66m1.161 1.735a7.98 7.98 0 0 0-.524-.905l-.83.556c.169.253.322.518.458.793l.896-.443zM1.348 3.555c-.194.289-.37.591-.524.906l.896.443c.136-.275.29-.54.459-.793l-.831-.556zM.423 5.428a7.945 7.945 0 0 0-.27 1.011l.98.194c.06-.302.14-.597.237-.884l-.947-.321zM15.848 6.44a7.943 7.943 0 0 0-.27-1.012l-.948.321c.098.287.177.582.237.884l.98-.194zM.017 7.477a8.113 8.113 0 0 0 0 1.046l.998-.064a7.117 7.117 0 0 1 0-.918l-.998-.064zM16 8a8.1 8.1 0 0 0-.017-.523l-.998.064a7.11 7.11 0 0 1 0 .918l.998.064A8.1 8.1 0 0 0 16 8M.152 9.56c.069.346.16.684.27 1.012l.948-.321a6.944 6.944 0 0 1-.237-.884l-.98.194zm15.425 1.012c.112-.328.202-.666.27-1.011l-.98-.194c-.06.302-.14.597-.237.884l.947.321zM.824 11.54a8 8 0 0 0 .524.905l.83-.556a6.999 6.999 0 0 1-.458-.793l-.896.443zm13.828.905c.194-.289.37-.591.524-.906l-.896-.443c-.136.275-.29.54-.459.793l.831.556zm-12.667.83c.23.262.478.51.74.74l.66-.752a7.047 7.047 0 0 1-.648-.648l-.752.66zm11.29.74c.262-.23.51-.478.74-.74l-.752-.66c-.201.23-.418.447-.648.648l.66.752m-1.735 1.161c.314-.155.616-.33.905-.524l-.556-.83a7.07 7.07 0 0 1-.793.458l.443.896zm-7.985-.524c.289.194.591.37.906.524l.443-.896a6.998 6.998 0 0 1-.793-.459l-.556.831zm1.873.925c.328.112.666.202 1.011.27l.194-.98a6.953 6.953 0 0 1-.884-.237l-.321.947zm4.132.271a7.944 7.944 0 0 0 1.012-.27l-.321-.948a6.954 6.954 0 0 1-.884.237l.194.98zm-2.083.135a8.1 8.1 0 0 0 1.046 0l-.064-.998a7.11 7.11 0 0 1-.918 0l-.064.998zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                                                </svg>
                                            </a>
                                        </td>

                                    </tr>
                                    <?php
                                        $i++;
                                    ?>
                                    <!--Thêm dịch vụ khi khách hàng muốn sử dụng -->
                                    <div class="modal fade" id="add_DV_to_HD_<?php echo $item->MADICHVU?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('add_ctPDP_DV')}}" method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Add services to the invoice</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-2">
                                                                <label class="form-label fw-bold">Customer</label>
                                                                <label for="">{{$kh->HOTENKH}}</label>
                                                            </div>
                                                            
                                                            <div class="col-md-6 mb-2">
                                                                <label class="form-label fw-bold">Tên Dịch vụ</label><br>
                                                                <label><?php echo $item->TENDICHVU ?></label>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label class="form-label fw-bold">Số phòng</label><br>
                                                                <label for="">{{$kh->SOPHONG}}</label>
                                                            </div>
                                                            <div class="col-md-6 mb-3" style="width: 200px;">
                                                                <label class="form-label fw-bold">Số lượng</label>
                                                                <input type="number" name="SOLUONG" class="form-control shadow-none" min="1"
                                                                    max="50" value="" >
                                                            </div>
                                                            <div style="position: relative;left: 420px;top:-40px">
                                                                <label class="form-label fw-bold">/<?php echo $item->DVT?></label>
                                                            </div>
                                                            <div style="display: none;" >
                                                                <input type="text" name="MAPHIEUDATPHONG" class="form-control shadow-none"
                                                                    value="{{$id}}" >
                                                            </div>
                                                            <div  style="display: none;">
                                                                <input type="text" name="MADICHVU" class="form-control shadow-none"
                                                                    value="<?php echo $item->MADICHVU ?>" >
                                                            </div>
                                                            <div style="display: none;">
                                                                <input type="text" name="DONGIADV" class="form-control shadow-none"
                                                                    value="<?php echo $item->DONGIADV ?> " >
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
                                @endforeach
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>