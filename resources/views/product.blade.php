<h1 style="text-align: center">Xin chao</h1>
<?php 
    use Carbon\Carbon;
    $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
    $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
    $DB_User = DB::table('ThongKe')
    ->whereBetween('ngay',[$subdays,$now])
    ->orderBy('ngay', 'ASC')
    ->get();

    foreach($DB_User as $item){
        echo $item->ngay;
        echo  $item->doanhthu;
    }
    echo"123";
?>