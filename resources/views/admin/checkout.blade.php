<?php
use Carbon\Carbon;
use Carbon\CarbonInterval;

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
    <title>CHECK OUT</title>
    @include('layout.essentials')
    @include('layout.links')
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
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3>CHECK OUT: <span id="text-date"></span></h3>
                <form onsubmit="return false"  style="margin: 10px">
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
                <div id="danhsachcheckout">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body" style="height: 500px; overflow-y: scroll;"> 
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light" style="text-align: center">
                                        <th>STT</th>
                                        <th>ID</th>
                                        <th>CheckIn</th>
                                        <th>CheckOut</th>
                                        <th>Customer</th>
                                        <th>Room</th>
                                        <th>Deposits</th>
                                        <th>Action</th>
                                    </tr>
                                </thead> 
                                <?php $i = 1; ?>
                                @foreach ($dsPDP as $item)
                                    @if ($item->TRANGTHAI == 1)
                                    <tr style="text-align: center; line-height: 2;">
                                        <td>{{$i}}</td>
                                        <td>{{$item->MAPHIEUDATPHONG}}</td>
                                        <td>{{$item->NGAYNHANPHONG}}</td>
                                        <td>{{$item->NGAYTRAPHONG}}</td>
                                        <td>{{$item->HOTENKH}}</td>
                                        <td>{{$item->SOPHONG}}</td>
                                        <td>{{number_format($item->TONGTIENPDP,0,',','.')}}</td>
                                        <td>
                                            <a href="su-dung-dich-vu?MAPHIEUDAT='.$item->MAPHIEUDATPHONG.'" class="btn btn-success">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wifi" viewBox="0 0 16 16">
                                                   <path d="M15.384 6.115a.485.485 0 0 0-.047-.736A12.444 12.444 0 0 0 8 3C5.259 3 2.723 3.882.663 5.379a.485.485 0 0 0-.048.736.518.518 0 0 0 .668.05A11.448 11.448 0 0 1 8 4c2.507 0 4.827.802 6.716 2.164.205.148.49.13.668-.049z"/>
                                                   <path d="M13.229 8.271a.482.482 0 0 0-.063-.745A9.455 9.455 0 0 0 8 6c-1.905 0-3.68.56-5.166 1.526a.48.48 0 0 0-.063.745.525.525 0 0 0 .652.065A8.46 8.46 0 0 1 8 7a8.46 8.46 0 0 1 4.576 1.336c.206.132.48.108.653-.065zm-2.183 2.183c.226-.226.185-.605-.1-.75A6.473 6.473 0 0 0 8 9c-1.06 0-2.062.254-2.946.704-.285.145-.326.524-.1.75l.015.015c.16.16.407.19.611.09A5.478 5.478 0 0 1 8 10c.868 0 1.69.201 2.42.56.203.1.45.07.61-.091zM9.06 12.44c.196-.196.198-.52-.04-.66A1.99 1.99 0 0 0 8 11.5a1.99 1.99 0 0 0-1.02.28c-.238.14-.236.464-.04.66l.706.706a.5.5 0 0 0 .707 0l.707-.707z"/>
                                               </svg>
                                            </a>
                                            <a href="khach-tra-phong?MAPHIEUDAT='.$item->MAPHIEUDATPHONG.'" class="btn btn-primary">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                               <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                                               <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                               </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $i++;?>
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
                        url: "{{ url('admin/dsCheckOut') }}",
                        method: "POST",
                        data: { nameKH: nameKH,_token:_token },
                        success: function (data) {
                            $("#danhsachcheckout").html(data);
                        }
                    });
            })
    </script>
</body>
</html>