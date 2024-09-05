<?php
//require_once 'essentials.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;

ini_set('memory_limit', '2048M');

// adminLogin();
// session_regenerate_id(true);

// require_once 'ketnoi.php';

$test = array();
$count = 0;
$CountRoomRentals = DB::table('solanthuephong')->get();
foreach ($CountRoomRentals as $key => $value) {
    $test[$count]["indexLabel"] = $value->SOPHONG;
    $test[$count]["y"] = $value->SOLAN;
    $count += 1;

}
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
    <title>Admin - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300;700&family=Poppins:wght@200;400&display=swap"
    rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <link rel="stylesheet" type="text/css" href="css/common.css">
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
                margin: 60px;
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
                <form autocomplete="off">
                    <h3>Thống kê doanh thu theo: <span id="text-date"></span></h3>
                    @csrf
                    <p>
                        <select class="select-date" style="border-radius: 5px;padding: 5px;">
                            <option value="7ngay">Tuần</option>
                            <option value="28ngay">Tháng</option>
                            <option value="90ngay">Quý</option>
                            <option value="365ngay">Năm</option>
                        </select>
                    </p>

                    <div id="chart" style="height: 250px;"></div>
                    <br>
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            thongke();
            var char = new Morris.Area({
                // ID of the element in which to draw the chart.
                element: 'chart',

                xkey: 'date',

                ykeys: ['revenue'],

                labels: ['Tổng doanh thu']
            });

            $('.select-date').change(function () {
                var _token = $('input[name="_token"]').val();
                var thoigian = $(this).val();
                if (thoigian == '7ngay') {
                    var text = 'Tuần';
                } else if (thoigian == '28ngay') {
                    var text = 'Tháng';
                } else if (thoigian == '90ngay') {
                    var text = 'Quý';
                } else if (thoigian == '365ngay') {
                    var text = 'Năm';
                }
                $('#text-date').text(text);
                $.ajax({
                    url: "{{url('admin/filter-by-date')}}",
                    method: "POST",
                    dataType: "JSON",
                    data: { thoigian: thoigian,_token:_token },
                    success: function (data) {
                        char.setData(data);
                        $('#text-date').text(text);
                    }
                });

            });


            function thongke() {
                var _token = $('input[name="_token"]').val();
                var text = 'Tuần';
                var thoigian = "7ngay"
                $('#text-date').text(text);
                $.ajax({
                    url: "{{url('admin/filter-by-date')}}",
                    method: "POST",
                    dataType: "JSON",
                    data: { thoigian: thoigian,_token:_token },
                    success: function (data) {
                        char.setData(data);
                        $('#text-date').text(text);
                    }
                });
            }
        });

    </script>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Thống kê số lược thuê của các phòng"
                },
                axisY: {
                    includeZero: true
                },
                data: [{
                    type: "column", //change type to bar, line, area, pie, etc
                    //indexLabel: "{y}", //Shows y value on all Data Points
                    indexLabelFontColor: "#5A5757",
                    indexLabelPlacement: "outside",
                    dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
</body>
</html>