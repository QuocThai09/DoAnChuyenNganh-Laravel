
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
    <title>Sơ đồ phòng theo tầng</title>
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
                <h3>Sơ đồ : <span id="text-date"></span></h3>
                <form autocomplete="off">
                    @csrf
                    <p>
                        <select class="select-date" style="border-radius: 5px;padding: 5px;">
                            @foreach ($data as $item)
                                <option value="{{$item->TENTANGLAU}}">
                                    {{$item->TENTANGLAU}}
                                </option>
                            @endforeach
                        </select>
                    </p>
                </form>
                <div id="danhsachPhong">
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            macdinh();
            $('.select-date').change(function () {
                var _token = $('input[name="_token"]').val();
                var tanglau = $(this).val();
                $('#text-date').text(tanglau);
                $.ajax({
                    url: "{{ url('admin/danh-sach-phong') }}",
                    method: "POST",
                    data: { tanglau: tanglau,_token:_token },
                    success: function (data) {
                        $("#danhsachPhong").html(data);
                    }
                });

            });
            function macdinh() {
                var _token = $('input[name="_token"]').val();
                var tanglau = "Lầu 1";
                $('#text-date').text(tanglau);
                $.ajax({
                    url: "{{ url('admin/danh-sach-phong') }}",
                    method: "POST",
                    data: { tanglau: tanglau,_token:_token },
                    success: function (data) {
                        $("#danhsachPhong").html(data);
                    }
                });
            }
        });
    </script>
</body>



</html>