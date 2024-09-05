<?php
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonInterval;

if (isset($_POST['thoigian'])) {
    $thoigian = $_POST['thoigian'];
} else {
    $thoigian = '';
    $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
}

if ($thoigian == '7ngay') {
    $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
} else if ($thoigian == '28ngay') {
    $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(28)->toDateString();
} else if ($thoigian == '90ngay') {
    $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(90)->toDateString();
} else if ($thoigian == '365ngay') {
    $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
}



$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

// $sql = "SELECT * FROM thongke  WHERE ngay BETWEEN '$subdays' AND '$now' ORDER BY ngay ASC";
// $sql_query = mysqli_query($conn, $sql);

// while ($val = mysqli_fetch_array($sql_query)) {
//     $chart_data[] = array(
//         'date' => $val['ngay'],
//         'revenue' => $val['doanhthu']
//     );
// }

$statistical =DB::table('ThongKe')
    ->whereBetween('ngay',[$subdays,$now])
    ->orderBy('ngay', 'ASC')
    ->get();
foreach($statistical as $item){
    $chart_data[] = array(
        'date' => $val[$item->ngay],
        'revenue' => $val[$item->doanhthu]
    );
}

//echo $data = json_encode($chart_data);
echo $data = "123";

?>