<?php
// require_once 'essentials.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;

// adminLogin();
// session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <title>CHECK IN</title>
    @include ('layout.links')
    @include('layout.essentials')
    <style>
        #dashboard-menu {
            position: fixed;
            height: 100%;
        }

        @media screen and (max-width: 990px) {

            #dashboard-menu {
                height: auto;
                width: 100%;
            }

            #main-content {
                margin-top: 60px;
            }
        }
    </style>

</head>

<body class="bg-light">
    @include('layout.header') 
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-3 overflow-hidden">
                <h3>CHECK IN: <span id="text-date"></span></h3>
                <div style="margin: 10px">
                    <form onsubmit="return false">
                        @csrf
                        <input class="input-search" type="text" id="nameKH" placeholder="Họ tên Khách Hàng ..." list="dataKH">
                        <datalist id="dataKH">
                            @foreach ($dskh as $item)
                                <option value="{{$item->HOTENKH}}"></option>
                            @endforeach
                        </datalist>
                        <button type="submit" class="btn-search" id="search">
                            <svg width="25" height="25" fill="#2183de" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14.385 15.446a6.751 6.751 0 1 1 1.06-1.06l5.156 5.155a.75.75 0 1 1-1.06 1.06l-5.156-5.155ZM6.46 13.884a5.25 5.25 0 1 1 7.43-.005l-.005.005-.005.004a5.25 5.25 0 0 1-7.42-.004Z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                <div id="danhsachcheckin">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body" style="height: 500px; overflow-y: scroll;"> 
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light" style="text-align: center">
                                        <th >STT</th>
                                        <th >ID</th>
                                        <th >Booking date</th>
                                        <th >CheckIn</th>
                                        <th >CheckOut</th>
                                        <th >Customer</th>
                                        <th >Kind of room</th>
                                        <th >Room</th>
                                        <th >Deposits</th>
                                        <th >Action</th>
                                    </tr>           
                                </thead>
                                <?php $i = 1; ?>
                                @foreach ($dsPDP as $item)
                                    @if (isset($item->SOPHONG) && $item->TRANGTHAI == 0)
                                        <tr style="text-align: center; line-height: 2;">
                                            <td>{{$i}}</td>
                                            <td>{{$item->MAPHIEUDATPHONG}}</td>
                                            <td>{{$item->NGAYDATPHONG}}</td>
                                            <td>{{$item->NGAYNHANPHONG}}</td>
                                            <td>{{$item->NGAYTRAPHONG}}</td>
                                            <td>{{$item->HOTENKH}}</td>
                                            <td>{{$item->TENLOAIPHONG}}</td>
                                            <td>{{$item->SOPHONG}}</td>
                                            <td>{{number_format($item->TONGTIENPDP,0,',','.')}}</td>
                                            <td>
                                                <a href="doi-phong?MAPHIEUDAT={{$item->MAPHIEUDATPHONG}}"
                                                    class="btn btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" ="bi bi-repeat" viewBox="0 0 16 16">
                                                        <path d="M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.34a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192Zm3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z"/>
                                                    </svg>
                                                </a>
                                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                                                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Check-in Confirmation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn đã chắc chắn khách hàng đã đến nhận phòng?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                    <a href="check-in-room?MAPHIEUDAT={{$item->MAPHIEUDATPHONG}}" class="btn btn-primary">Yes</a>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $i++?>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous">
    </script>
    <script>
        document.getElementById('search').addEventListener('click', () => {
                var _token = $('input[name="_token"]').val();
                var nameKH = document.getElementById('nameKH').value;
                if(nameKH == ''){
                    alert('Vui lòng nhập tên khách hàng');
                }
                $.ajax({
                        url: "{{ url('admin/dsCheckIn') }}",
                        method: "POST",
                        data: { nameKH: nameKH,_token:_token },
                        success: function (data) {
                            $("#danhsachcheckin").html(data);
                        }
                    });
            })
    </script>
</body>
</html>