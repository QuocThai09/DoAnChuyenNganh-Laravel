
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
    <title>Hóa đơn KH</title>
    @include ('layout.links')
    @include ('layout.essentials')
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
    @include ('layout.header')
    <div style="height: 60px"></div>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3>Hóa đơn khách hàng: <span id="text-date"></span></h3>
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
                <div id="danhsachhoadon">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body" style="height: 500px; overflow-y: scroll;"> 
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light" style="text-align: center">
                                        <th>STT</th>
                                        <th>Mã HD</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Staff</th>
                                        <th>Customer</th>
                                        <th>Room</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead> 
                                <?php $i = 1; ?>
                                @foreach ($dsHoaDon as $item)
                                    @if ($item->TRANGTHAI == 1)
                                        <tr style="text-align: center; line-height: 2;">
                                            <td>{{$i}}</td>
                                            <td>{{$item->MAHOADON}}</td>
                                            <td>{{$item->NGAYNHANPHONG}}</td>
                                            <td>{{$item->NGAYTRAPHONG}}</td>
                                            <td>{{$item->HOTENNV}}</td>
                                            <td>{{$item->HOTENKH}}</td>
                                            <td>{{$item->DANHSACHPHONG}}</td>
                                            <td>{{number_format($item->THANHTIEN,0,',','.')}}</td>
                                            <td>
                                                <a href="xem-chi-tiet-hoa-don?MAHOADON='.$item->MAHOADON.'"
                                                    class="btn btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @elseif($item->TRANGTHAI == 0)
                                        <tr style="text-align: center; line-height: 2;">
                                            <td>{{$i}}</td>
                                            <td>{{$item->MAHOADON}}</td>
                                            <td>{{$item->NGAYNHANPHONG}}</td>
                                            <td>{{$item->NGAYTRAPHONG}}</td>
                                            <td>{{$item->HOTENNV}}</td>
                                            <td>{{$item->HOTENKH}}</td>
                                            <td>{{$item->DANHSACHPHONG}}</td>
                                            <td>{{number_format($item->THANHTIEN,0,',','.')}}</td>
                                            <td>
                                                <a href="xem-chi-tiet-hoa-don?MAHOADON='.$item->MAHOADON.'"
                                                    class="btn btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                                    </svg>
                                                </a>
                                                <a href="thanh-toan-hoa-don?MAHOADON='.$item->MAHOADON.'"
                                                    class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                                                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                    <?php $i++;?>
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
    crossorigin="anonymous"></script>
    <script>
        document.getElementById('search').addEventListener('click', () => {
                var _token = $('input[name="_token"]').val();
                var nameKH = document.getElementById('nameKH').value;
                if(nameKH == ''){
                    alert('Vui lòng nhập tên khách hàng');
                }
                $.ajax({
                        url: "{{ url('admin/danh-sach-customer-HD') }}",
                        method: "POST",
                        data: { nameKH: nameKH,_token:_token },
                        success: function (data) {
                            $("#danhsachhoadon").html(data);
                        }
                    });
            })
    </script>
</body>



</html>