<?php

namespace App\Http\Controllers;

use App\Models\Statistical;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Exception;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\Console\Input\Input;

class HomeController extends Controller
{
    public function index(){
        //session()->flush();
        $statistical = DB::table('ThongKe')->get();
        $CountRoomRentals = DB::table('solanthuephong')->get();
        return view('admin.dashboard',['statistical'=>$statistical,'CountRoomRentals'=>$CountRoomRentals]);
    }
    public function filter_by_date(Request $res){
        
        $data = $res->all();
        $subdays7 = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $subdays28 = Carbon::now('Asia/Ho_Chi_Minh')->subDays(28)->toDateString();
        $subdays90 = Carbon::now('Asia/Ho_Chi_Minh')->subDays(90)->toDateString();
        $subdays365 = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        if($data['thoigian'] == '7ngay'){
            $get = Statistical::WhereBetween('ngay',[$subdays7,$now])->orderBy('ngay','ASC')->get();
        }else if($data['thoigian'] == '28ngay'){
            $get = Statistical::WhereBetween('ngay',[$subdays28,$now])->orderBy('ngay','ASC')->get();
        }else if($data['thoigian'] == '90ngay'){
            $get = Statistical::WhereBetween('ngay',[$subdays90,$now])->orderBy('ngay','ASC')->get();
        }else{
            $get = Statistical::WhereBetween('ngay',[$subdays365,$now])->orderBy('ngay','ASC')->get();
        }
        foreach($get as $item){
            $chart_data[] = array(
                'date' => $item->ngay,
                'revenue' => $item->doanhthu,
            );
        }
        //dd($chart_data);
        echo $data = json_encode($chart_data);
    }

    public function xacnhanphong(){
        $phieuDatPhong = DB::table('phieudatphong')->get();
        return view('admin.DSPhieuDatPhong',['phieudatphong'=>$phieuDatPhong]);
    }

    public function editDatPhong(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $id = $res->MAPHIEUDATPHONG;
        $sophong = $res->SOPHONG;
        $tenKH = $res->HOTENKH;
        $taiKhoan = $res->TAIKHOAN;
        $ngaydat = $res->NGAYDATPHONG;
        $ngaytra = $res->NGAYTRAPHONG;
        $ngaynhan = $res->NGAYNHANPHONG;
        $loaiphong = $res->TENLOAIPHONG;

        //UPDATE `phieudatphong` SET `SOPHONG`='$sophong' WHERE `MAPHIEUDATPHONG`='$maphieu'
        $updateDB = DB::table('phieudatphong')
            ->where('MAPHIEUDATPHONG','=',$id)
            ->update([
                'SOPHONG'=>$sophong
            ]);
        //UPDATE `phong` SET `TRANGTHAIPHONG`= 1 WHERE `SOPHONG`='$sophong'
        $updatePhong = DB::table('phong')
        ->where('SOPHONG','=',$sophong)
        ->update([
            'TRANGTHAIPHONG' => 1
        ]);

        if($updateDB > 0 && $updatePhong > 0){
            $mail = new PHPMailer(true);
            try{
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = env('MAIL_HOST');
                $mail->SMTPAuth = true;
                $mail->Username = env('MAIL_USERNAME');
                $mail->Password = env('MAIL_PASSWORD');
                $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                $mail->Port = env('MAIL_PORT');

                $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')); // Địa chỉ email và tên người gửi
                $mail->addAddress($taiKhoan, $tenKH); // Địa chỉ mail và tên người nhận
                //Content
                $mail->isHTML(true); // Set email format to HTML
                //$mail->Subject = 'Xác nhận đơn đặt phòng'; 
                $subject = 'Xác nhận đặt phòng khách sạn TVT';
                $sub = '=?UTF-8?B?'.base64_encode($subject).'?=';
                $mail->Subject = $sub;// Tiêu đề
                $mail->Body = "
                    Kính gửi <b>$tenKH</b>,<br>
                    Chúng tôi rất vui mừng cho kỳ nghỉ sắp tới của bạn tại Khách sạn TVT.
                    Xin nhắc lại, số phòng của bạn là <b>$sophong</b> thời gian nhận phòng là <b>$ngaynhan</b> và trả phòng là <b>$ngaytra</b>.<br>
                    Xin lưu ý rằng Wi-Fi miễn phí được cung cấp cho tất cả các khách hàng và chỗ đỗ xe được cung cấp có tính phí ngay trong khuôn viên.
                    Một số điểm tham quan và nhà hàng gần đó bao gồm Nhà hàng ABC, bãi biển và còn nhiều nơi thú vị khác, .. và khách sạn của chúng tôi cung cấp: <br>
                    - Dịch vụ giặt ủi quần áo.<br>
                    - Dịch vụ xe đưa đón sân bay.<br>
                    - Nhà hàng.<br>
                    - Quầy bar.<br>
                    - Dịch vụ Spa.<br>
                    Nếu bạn có bất kỳ câu hỏi hoặc yêu cầu đặc biệt nào, vui lòng liên hệ với chúng tôi theo số 0912345678.<br>
                    Cảm ơn bạn, và chúng tôi mong sớm gặp lại bạn.<br>
                    Trân trọng, <b>$tenKH</b>.
                "; // Nội dung

                $mail->send();
                $_SESSION['successMessage'] = "Xác nhận phòng thành công";
                return redirect()->route('xacnhanphong');
            } catch (Exception $e) {
                return back()->with('error','Message could not be sent.');
            }
        }else{
            $_SESSION['erorrMessage'] = "Xác nhận phòng thất bại";
            return redirect()->route('xacnhanphong');
        }
    }

    public function checkin(){
        $dskh = DB::table('khachhang')->get();

        $dsPDP = DB::table('phieudatphong')
                        ->join('khachhang','phieudatphong.MAKH','=','khachhang.MAKH')
                        ->join('loaiphong','phieudatphong.MALOAIPHONG','=','loaiphong.MALOAIPHONG')
                        ->orderBy('maphieudatphong')
                        ->get();

        return view('admin.checkin',['dskh'=>$dskh,'dsPDP'=>$dsPDP]);
    }


    public function dsCheckIn(Request $res){
       $data = $res->all();
       $nameKH = $data['nameKH'];
       $i = 1;
       $dsPDP = DB::table('phieudatphong')
            ->join('khachhang','phieudatphong.MAKH','=','khachhang.MAKH')
            ->join('loaiphong','phieudatphong.MALOAIPHONG','=','loaiphong.MALOAIPHONG')
            ->where('khachhang.HOTENKH','like','%'.$nameKH.'%')
            ->get();
        
        $output = '<div class="card border-0 shadow-sm mb-4">
                        <div class="card-body" style="height: 500px; overflow-y: scroll;"> 
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light" style="text-align: center">
                                        <th> STT</th>
                                        <th> ID</th>
                                        <th> Booking date</th>
                                        <th> CheckIn</th>
                                        <th> CheckOut</th>
                                        <th> Customer</th>
                                        <th> Kind of room</th>
                                        <th> Room</th>
                                        <th> Deposits</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>';
                                foreach ($dsPDP as $item){
                                    if (isset($item->SOPHONG) && $item->TRANGTHAI == 0){
                                        $output .='
                                        <tr style="text-align: center; line-height: 2;">
                                            <td>'.$i.'</td>
                                            <td>'.$item->MAPHIEUDATPHONG.'</td>
                                            <td>'.$item->NGAYDATPHONG.'</td>
                                            <td>'.$item->NGAYNHANPHONG.'</td>
                                            <td>'.$item->NGAYTRAPHONG.'</td>
                                            <td>'.$item->HOTENKH.'</td>
                                            <td>'.$item->TENLOAIPHONG.'</td>
                                            <td>'.$item->SOPHONG.'</td>
                                            <td>'.number_format($item->TONGTIENPDP,0,',','.').'</td>
                                            <td>
                                                <a href="doi-phong?MAPHIEUDAT='.$item->MAPHIEUDATPHONG.'"
                                                    class="btn btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" ="bi bi-repeat" viewBox="0 0 16 16">
                                                        <path d="M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.34a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192Zm3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z"/>
                                                    </svg>
                                                </a>
                                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop'.$i.'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                                                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop'.$i.'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                    <a href="check-in-room?MAPHIEUDAT='.$item->MAPHIEUDATPHONG.'" class="btn btn-primary">Yes</a>
                                                </div>
                                                </div>
                                            </div>
                                        </div>';
                                        $i++;
                                    }
                                }
                            $output .='</table>
                        </div>
                    </div>';
       echo $output;
    }

    public function changeRoom(Request $res){
        $id = $res->input('MAPHIEUDAT');
        $data = DB::table('phieudatphong')
            ->join('khachhang','phieudatphong.MAKH','=','khachhang.MAKH')
            ->join('loaiphong','phieudatphong.MALOAIPHONG','=','loaiphong.MALOAIPHONG')
            ->where('phieudatphong.MAPHIEUDATPHONG','=',$id)
            ->first();
        //SELECT PD.*, KH.HOTENKH, LP.TENLOAIPHONG FROM PHIEUDATPHONG PD JOIN KHACHHANG KH ON PD.MAKH = KH.MAKH 
        //JOIN LOAIPHONG LP ON PD.MALOAIPHONG = LP.MALOAIPHONG WHERE PD.MAPHIEUDATPHONG = '$maphieudat'
        $dataRoom = DB::table('phong')->where('MALOAIPHONG','=',$data->MALOAIPHONG)->get();
        //SELECT * FROM phong WHERE MALOAIPHONG = '$maloaiphong'
        return view('admin.edit_doiphong',['id'=>$id,'data'=>$data,'dataRoom'=>$dataRoom]);
    }

    public function updateRoom(Request $res){
        $maphieu = $res->input('MAPHIEUDATPHONG');
        $sophongcu =$res->input('SOPHONG');
        $sophongmoi =$res->input('SOPHONGMOI');
        $tenKH =$res->input('HOTENKH');
        $ngaydat =$res->input('NGAYDATPHONG');
        $ngaytra =$res->input('NGAYTRAPHONG');
        $ngaynhan =$res->input('NGAYNHANPHONG');
        $loaiphong =$res->input('TENLOAIPHONG');
        
        //UPDATE `phieudatphong` SET `SOPHONG`='$sophongmoi' WHERE `MAPHIEUDATPHONG`=''
        DB::table('phieudatphong')->where('MAPHIEUDATPHONG','=',$maphieu)->update(['SOPHONG'=>$sophongmoi]);

        //UPDATE `phong` SET `TRANGTHAIPHONG`= 1 WHERE `SOPHONG`='$sophongmoi'
        DB::table('phong')->where('SOPHONG','=',$sophongmoi)->update(['TRANGTHAIPHONG'=> 1]);

        //UPDATE `phong` SET `TRANGTHAIPHONG`= 0 WHERE `SOPHONG`='$sophongcu'
        DB::table('phong')->where('SOPHONG','=',$sophongcu)->update(['TRANGTHAIPHONG'=> 0]);
        return redirect()->route('checkin');
    }

    public function checkInRoom(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }
        $id = $res->input('MAPHIEUDAT');
        
        //UPDATE `phieudatphong` SET `TRANGTHAI`= 1 WHERE `MAPHIEUDATPHONG`='$maPDP'
        $check = DB::table('phieudatphong')->where('MAPHIEUDATPHONG','=',$id)->update(['TRANGTHAI'=> 1]);
        if($check > 0){
            $_SESSION['successMessage'] = "Checkin thành công!!";
        }else{
            $_SESSION['errorMessage'] = "CheckIn thất bại!!";
        }
        return redirect()->route('checkin');
    }

    public function checkOut(){
        $dskh = DB::table('khachhang')->get();

        $dsPDP = DB::table('phieudatphong')
                         ->join('khachhang','phieudatphong.MAKH','=','khachhang.MAKH')
                         ->orderBy('maphieudatphong')
                         ->get();
        return view('admin.checkout',['dskh'=>$dskh,'dsPDP'=>$dsPDP]);
    }

    public function dsCheckOut(Request $res){
        $data = $res->all();
        $nameKH = $data['nameKH'];
        $i = 1;
        $dsPDP = DB::table('phieudatphong')
                             ->join('khachhang','phieudatphong.MAKH','=','khachhang.MAKH')
                             ->join('loaiphong','phieudatphong.MALOAIPHONG','=','loaiphong.MALOAIPHONG')
                             ->where('khachhang.HOTENKH','like','%'.$nameKH.'%')
                             ->get();
        $output = 
            '<div class="card border-0 shadow-sm mb-4">
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
                        </thead>';
                         foreach($dsPDP as $item){
                             //Nếu trạng thái = 1 => khách hàng đã đến nhận phòng
                             if ($item->TRANGTHAI == 1){
                                 $output .='<tr style="text-align: center; line-height: 2;">
                                        <td>'.$i.'</td>
                                        <td>'.$item->MAPHIEUDATPHONG.'</td>
                                        <td>'.$item->NGAYNHANPHONG.'</td>
                                        <td>'.$item->NGAYTRAPHONG.'</td>
                                        <td>'.$item->HOTENKH.'</td>
                                        <td>'.$item->SOPHONG.'</td>
                                        <td>'.number_format($item->TONGTIENPDP,0,',','.').'</td>
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
                                    </tr>';
                             }
                             $i++;
                         }
                     $output.='</div>
                     </table>
                 </div>
             </div>';
        echo $output;
         
    }

    public function useService(Request $res){
        $id = $res->input('MAPHIEUDAT');
        //SELECT ch.*, dv.TENDICHVU, dv.DVT, dv.DONGIADV
        //FROM chitietPDP ch
        //JOIN dichvu dv ON ch.MADICHVU = dv.MADICHVU
        //WHERE ch.MAPHIEUDATPHONG = '$MAPHIEUDATPHONG'
        $ctPDP = DB::table('chitietPDP')
            ->join('dichvu','chitietPDP.MADICHVU','=','dichvu.MADICHVU')
            ->where('MAPHIEUDATPHONG','=',$id)
            ->get();

        //SELECT * FROM dichvu order by MADICHVU
        $dv = DB::table('dichvu')->whereNot('DONGIADV','=',0)->get();

        //select khach hang
        $kh = DB::table('phieudatphong')
            ->join('khachhang','phieudatphong.MAKH','=','khachhang.MAKH')
            ->where('MAPHIEUDATPHONG','=',$id)
            ->first();
        return  view('admin.suDung_DV',['id'=>$id,'ctPDP'=>$ctPDP,'dv'=>$dv,'kh'=>$kh]);
    }

    public function addServiceToHD(Request $res){

        if(!isset($_SESSION)){
            session_start();
        }

        $idDV = $res->input('MADICHVU');
        $idPDP = $res->input('MAPHIEUDATPHONG');
        $donGia = $res->input('DONGIADV');
        $SL = $res->input('SOLUONG');

        $tongTien = $SL * $donGia;
        //SELECT `TONGTIENPDP` FROM `phieudatphong` WHERE `MAPHIEUDATPHONG` = '$MAPHIEUDATPHONG'
        $ttPDP = DB::table('phieudatphong')
            ->where('MAPHIEUDATPHONG','=',$idPDP,)
            ->first();
        $tongTienPDP = $ttPDP->TONGTIENPDP;
        //SELECT * FROM `chitietpdp` WHERE `MAPHIEUDATPHONG`= '$MAPHIEUDATPHONG' AND `MADICHVU` = '$madv'

        $valCTPDP = DB::table('chitietpdp')
            ->where([
                ['MAPHIEUDATPHONG','=',$idPDP],
                ['MADICHVU','=',$idDV],
            ])->first();

        if($valCTPDP == null){
            //INSERT INTO `chitietpdp`(`MAPHIEUDATPHONG`, `MADICHVU`, `SOLANSD`, `TONGTIEN`) VALUES ('$MAPHIEUDATPHONG','$madv',$soluong,$tongTien)
            $checkInsert = DB::table('chitietpdp')->insert([
                'MAPHIEUDATPHONG' => $idPDP,
                'MADICHVU' => $idDV,
                'SOLANSD' => $SL,
                'TONGTIEN' => $tongTien,
            ]);
            if($checkInsert > 0) {
                $t = $tongTienPDP + $tongTien;
                //"UPDATE `phieudatphong` SET `TONGTIENPDP`='$t' WHERE `MAPHIEUDATPHONG`='$MAPHIEUDATPHONG'"
                $checkUpdate = DB::table('phieudatphong')
                    ->where('MAPHIEUDATPHONG','=',$idPDP)
                    ->update(['TONGTIENPDP' => $t]);
                if($checkUpdate >  0){
                    $_SESSION['successMessage'] = "Thêm dịch vụ thành công!!!";
                    return redirect('admin/su-dung-dich-vu?MAPHIEUDAT='.$idPDP);
                }
                
            } else {
                $_SESSION['errorMessage'] = "Thêm dịch vụ thất bại!!!";
                return redirect('admin/su-dung-dich-vu?MAPHIEUDAT='.$idPDP);
            }
        }else{
            $soLuongCu =  $valCTPDP->SOLANSD;
            $tienCu = $valCTPDP->TONGTIEN;

            $sl = $soLuongCu + $SL;
            $tongTienMoi = $tienCu + $tongTien;

            //UPDATE `chitietpdp` SET `SOLANSD`=  $sl,`TONGTIEN`=$tongTienMoi WHERE `MAPHIEUDATPHONG`='$MAPHIEUDATPHONG' AND `MADICHVU`='$madv'";
            $checkUpdate = DB::table('chitietpdp')
                ->where([
                    ['MAPHIEUDATPHONG','=',$idPDP],
                    ['MADICHVU','=',$idDV],
                ])
                ->update([
                'SOLANSD' => $sl,
                'TONGTIEN' => $tongTienMoi,
            ]);
            if($checkUpdate > 0) {
                $t = $tongTienPDP + $tongTien;
                //$updateTongTien = "UPDATE `phieudatphong` SET `TONGTIENPDP`='$t' WHERE `MAPHIEUDATPHONG`='$MAPHIEUDATPHONG'";
                $checkUpdateTongTien = DB::table('phieudatphong')
                    ->where('MAPHIEUDATPHONG','=',$idPDP)
                    ->update(['TONGTIENPDP' => $t]);

                $_SESSION['successMessage'] = "Cập nhật dịch vụ thành công!!!";
                return redirect('admin/su-dung-dich-vu?MAPHIEUDAT='.$idPDP);
            } else {
                $_SESSION['errorMessage'] = "Cập nhật dịch vụ thất  bại!!!";
                return redirect('admin/su-dung-dich-vu?MAPHIEUDAT='.$idPDP);
            }
        }
    }

    public function customerCheckOut(Request $res){
        $id = $res->input('MAPHIEUDAT');

        //SELECT PD.*, KH.HOTENKH, LP.TENLOAIPHONG FROM PHIEUDATPHONG PD JOIN KHACHHANG KH ON PD.MAKH = KH.MAKH 
        //JOIN LOAIPHONG LP ON PD.MALOAIPHONG = LP.MALOAIPHONG WHERE PD.MAPHIEUDATPHONG = '$maphieudat'
        $data = DB::table('phieudatphong')
            ->join('khachhang','phieudatphong.MAKH','=','khachhang.MAKH')
            ->join('loaiphong','phieudatphong.MALOAIPHONG','=','loaiphong.MALOAIPHONG')
            ->join('phong','phieudatphong.SOPHONG','=','phong.SOPHONG')
            ->where('phieudatphong.MAPHIEUDATPHONG','=',$id)
            ->first();

        $vatdung = DB::table('vatdung')
            ->where('MALOAIPHONG','=',$data->MALOAIPHONG)
            ->get();

        //SELECT ch.*, dv.TENDICHVU, dv.DVT, dv.DONGIADV
        //FROM chitietPDP ch
        //JOIN dichvu dv ON ch.MADICHVU = dv.MADICHVU
        //WHERE ch.MAPHIEUDATPHONG = '$MAPHIEUDATPHONG'
        $ctPDP = DB::table('chitietPDP')
            ->join('dichvu','chitietPDP.MADICHVU','=','dichvu.MADICHVU')
            ->where('chitietPDP.MAPHIEUDATPHONG','=',$id)
            ->get();

        //SELECT *  FROM `khuyenmai` WHERE `TRANGTHAIKHUYENMAI` = 1
        $km = DB::table('khuyenmai')
            ->where('TRANGTHAIKHUYENMAI','=',1)
            ->get();
        return view('admin.edit_checkout',['id'=>$id,'data'=>$data,'vatdung'=>$vatdung,'ctPDP'=>$ctPDP,'km'=>$km]);
    }

    public function createHD(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $maphieudat = $res->input('MAPHIEUDATPHONG');
        $maKH = $res->input('MAKH');
        $maphong = $res->input('MAPHONG');
        $soPhong = $res->input('SOPHONG');
        $ngayNhanPhong = $res->input('NGAYNHANPHONG');
        $ngayTraPhong = $res->input('NGAYTHUCTE');
        $soNgayThue = $res->input('SONGAYTHUE');
        $maLoaiPhong = $res->input('MALOAIPHONG');
        $MaKhuyenMai = $res->input('KHUYENMAI');

         //lấy ID NV
        if(isset($_SESSION['user'])){
            $nameNV = $_SESSION['user']->HOTENNV;
            $idNV = $_SESSION['user']->MANV;
        }else{
            $nameNV = "";
            $idNV = "";
        }

        //SELECT MAX(CAST(SUBSTRING(MAHOADON, 3) AS UNSIGNED)) AS max_mahd FROM HOADON
        //Lấy sô lớn nhất của mã hóa đơn VD:HD10 ->kq:10
        $data_max_hd = DB::table('hoadon')
            ->select(DB::raw('MAX(CAST(SUBSTRING(MAHOADON, 3) AS UNSIGNED)) AS max_mahd'))
            ->first();
        if($data_max_hd){
            $max_hd =  $data_max_hd->max_mahd;
            $new_mahd = "HD" . ($max_hd) + 1;
        }else{
            $max_hd =  null;
        }

        //Cập nhật hư hao
        $huhao = $res->input('myCheckbox'); 
        $tongTienHuHao = 0;
        if($huhao == null){
            $huhao = 0;
        }else{
            $slHH = $res->input('SOLUONGHUHAO');
            $viTriDV = $res->input('vitriDV');
            if($viTriDV == null){
                $_SESSION['errorMessage'] = "Vui  lòng chọn mục xác nhận vật dụng hư hao";
                return redirect('khach-tra-phong?MAPHIEUDAT='.$maphieudat);
            }else{
                $check = 0;
                for($i = 0;$i < count($huhao);$i++){
                    for($vt = $check; $vt < count($viTriDV); $vt ++){
                        for($j = $viTriDV[$vt];$j < count($slHH); $j++){
                            //SELECT `GIAVD` FROM `vatdung` WHERE `MAVATDUNG` = '$huhao[$i]' AND `MALOAIPHONG`= '$maLoaiPhong'
                            $dataDV = DB::table('vatdung')
                                ->where([
                                    ['MAVATDUNG','=',$huhao[$i]],
                                    ['MALOAIPHONG','=',$maLoaiPhong]
                                ])->first();
                            if($slHH[$j] == 1){
                                $sl = (int)$slHH[$j];
                                $price = $dataDV->GIAVD;
                                $tongTienHuHao += $price;
                                $tienHuHao = $price * $sl;
                            }else{
                                $sl = (int)$slHH[$j];
                                $price = $dataDV->GIAVD;
                                $tongTienHuHao += $price * $sl;
                                $tienHuHao = $price * $sl;
                            }
                            //INSERT INTO `huhao`(`MAPHIEUDATPHONG`, `MAVATDUNG`,`SOLUONG`, `TONGTIENHH`) VALUES ('$maphieudat','$huhao[$i]',$sl,$tienHuHao)";
                            DB::table('huhao')->insert([
                                'MAPHIEUDATPHONG' => $maphieudat,
                                'MAVATDUNG' => $huhao[$i],
                                'SOLUONG' => $sl,
                                'TONGTIENHH' => $tienHuHao
                            ]);
                            break;
                        }
                        $check ++;
                        break;
                    }
                }
            }
        }

        // Tìm discount của khuyến mãi
        if($MaKhuyenMai == 0){
            $tenKM = "Not values";
            $discount = 0;
        }else{
            //SELECT * FROM `khuyenmai` WHERE `MAKHUYENMAI` ='$MaKhuyenMai'
            $dataKM = DB::table('khuyenmai')->where('MAKHUYENMAI','=',$MaKhuyenMai)->first();
            $discount =  $dataKM->DISCOUNT;
            $tenKM =  $dataKM->TENKHUYENMAI;
        }

        // cập nhật tổng tiền trong phiếu đặt phòng
        //SELECT `TONGTIENPDP` FROM `phieudatphong` WHERE `MAPHIEUDATPHONG` = '$maphieudat'
        $dataPDP = DB::table('phieudatphong')->where('MAPHIEUDATPHONG','=',$maphieudat)->first();
        $tongTienPDP = $dataPDP->TONGTIENPDP;

        $tongTien = $tongTienPDP + $tongTienHuHao;
        $tienKM = $tongTien * $discount;
        $t = $tongTien - $tienKM;
        
        //UPDATE `phieudatphong` SET `TONGTIENPDP`='$t' WHERE `MAPHIEUDATPHONG`='$maphieudat'
        DB::table('phieudatphong')->update([
            'TONGTIENPDP' => $t
        ]);

        // Tìm hóa đơn của khách hàng đó 
        //SELECT * FROM `hoadon` WHERE `MAKH` = '$maKH' AND `NGAYTRAPHONG` = '$ngayTraPhong'
        $dataHD = DB::table('hoadon')
            ->where('MAKH','=',$maKH)
            ->where('NGAYTRAPHONG','=',$ngayTraPhong)
            ->first();
        if($dataHD){
            if($dataHD->TRANGTHAI == 1){
                //Tạo hóa đơn mới
                $km = $tenKM.'-'.$soPhong;
                $danhSachKMMoi = $km;
                //INSERT INTO `hoadon`(`MAHOADON`, `NGAYNHANPHONG`, `NGAYTRAPHONG`,
                // `SONGAYTHUE`,`THANHTIEN`,`MANV`, `MAKH`,`DANHSACHPHONG`,`ThongTinKM`,`TRANGTHAI`)
                //VALUES ('$new_mahd','$ngayNhanPhong','$ngayTraPhong',$soNgayThue,$t,'$maNV','$maKH','$soPhong','$danhSachKMMoi',0)";
                $createHD = DB::table('hoadon')->insert([
                    'MAHOADON' => $new_mahd,
                    'NGAYNHANPHONG' => $ngayNhanPhong,
                    'NGAYTRAPHONG' => $ngayTraPhong,
                    'SONGAYTHUE' => $soNgayThue,
                    'THANHTIEN' => $t,
                    'MANV' => $idNV,
                    'MAKH' => $maKH,
                    'DANHSACHPHONG' => $soPhong,
                    'ThongTinKM' => $danhSachKMMoi,
                    'TRANGTHAI' => 0
                ]);

                if ($createHD > 0) {
                    //UPDATE `phieudatphong` SET `TRANGTHAI`= 2 WHERE MAPHIEUDATPHONG = '$maphieudat'
                    DB::table('phieudatphong')
                        ->where('MAPHIEUDATPHONG','=',$maphieudat)
                        ->update([
                        'TRANGTHAI' => 2
                    ]);
                
                    // Tạo chi tiết hóa đơn
                    //INSERT INTO `cthd`(`MAHOADON`, `MAPHIEUDATPHONG`, `TONGTIEN`) VALUES ('$new_mahd','$maphieudat','$t')
                    DB::table('cthd')
                        ->insert([
                            'MAHOADON' => $new_mahd,
                            'MAPHIEUDATPHONG' => $maphieudat,
                            'TONGTIEN' => $t
                        ]);
                    
                    //cập nhật số lần thuê phòng
                    //SELECT * FROM `solanthuephong` WHERE `SOPHONG` = '$soPhong'
                    $dataSLTP = DB::table('solanthuephong')->where('SOPHONG','=',$soPhong)->first();
                    if($dataSLTP){
                        //UPDATE SỐ LƯỢNG 
                        $slCu = $dataSLTP->SOLAN;
                        $sl = $slCu + 1;
                        //UPDATE `solanthuephong` SET `SOLAN`='$sl' WHERE `SOPHONG`='$soPhong'
                        $updateSoLanThue = DB::table('phieudatphong')
                            ->where('SOPHONG','=',$soPhong)
                            ->update([
                            'SOLAN' => $sl
                        ]);
                        if($updateSoLanThue > 0){
                            $_SESSION['successMessage'] = "Check out thành công.";
                            return redirect()->route('checkout');
                        }else{
                            $_SESSION['errorMessage'] = "Check out thất bại.";
                            return redirect()->route('checkout');
                        }
                    }else{
                        //insert số lần sd phòng
                        //INSERT INTO `solanthuephong`(`SOPHONG`, `SOLAN`) VALUES ('$soPhong',1)"
                        $createSoLanThue = DB::table('solanthuephong')
                            ->insert([
                                'SOPHONG' => $soPhong,
                                'SOLAN' => 1
                            ]);
                        if($createSoLanThue > 0){
                            $_SESSION['successMessage'] = "Check out thành công.";
                            return redirect()->route('checkout');
                        }else{
                            $_SESSION['errorMessage'] = "Check out thất bại.";
                            return redirect()->route('checkout');
                        }
                    }
                }
            }else{
                $maHD = $dataHD->MAHOADON;
                // Tạo chi tiết hóa đơn
                //INSERT INTO `cthd`(`MAHOADON`, `MAPHIEUDATPHONG`, `TONGTIEN`) VALUES ('$maHD','$maphieudat',$t)
                DB::table('cthd')
                    ->insert([
                        'MAHOADON' => $maHD,
                        'MAPHIEUDATPHONG' => $maphieudat,
                        'TONGTIEN' => $t
                    ]);
        
                // Cập nhật danh sách phòng và tổng tiền cho hóa đơn
                $danhSachPhongCu =$dataHD->DANHSACHPHONG;
                $danhSachPhongMoi = $danhSachPhongCu.'-'.$soPhong;
                
                $km = $tenKM.'-'.$soPhong;
                if(!isset($dataHD->ThongTinKM)){
                    $danhSachKMMoi = $km;
                }else{
                    $danhSachKMCu = $dataHD->ThongTinKM;
                    $danhSachKMMoi = $danhSachKMCu.';'.$km;
                }
            
                $thanhTienCu = $dataHD->THANHTIEN;
                $tongThanhTien = $thanhTienCu + $t;
                //UPDATE `hoadon` SET `THANHTIEN`=$tongThanhTien,`DANHSACHPHONG`='$danhSachPhongMoi',`ThongTinKM`='$danhSachKMMoi' 
                //WHERE `NGAYTRAPHONG`='$ngayTraPhong' AND `MAKH`='$maKH'
                $updateHD = DB::table('hoadon')
                    ->where([
                        ['NGAYTRAPHONG','=',$ngayTraPhong],
                        ['MAKH','=',$maKH]
                    ])
                    ->update([
                    'THANHTIEN' => $tongThanhTien,
                    'DANHSACHPHONG' => $danhSachPhongMoi,
                    'ThongTinKM' => $danhSachKMMoi
                ]);
                if( $updateHD > 0){
                    //UPDATE `phieudatphong` SET `TRANGTHAI`= 2 WHERE MAPHIEUDATPHONG = '$maphieudat'
                    DB::table('phieudatphong')
                        ->where('MAPHIEUDATPHONG','=',$maphieudat)
                        ->update([
                        'TRANGTHAI' => 2
                    ]);
                    
                    //cập nhật số lần thuê phòng
                    //SELECT * FROM `solanthuephong` WHERE `SOPHONG` = '$soPhong'
                    $selectSL = DB::table('solanthuephong')->where('SOPHONG','=',$soPhong)->first();
                    if($selectSL){
                        //UPDATE SỐ LƯỢNG 
                        $slCu = $selectSL->SOLAN;
                        $sl = $slCu + 1;
                        //UPDATE `solanthuephong` SET `SOLAN`='$sl' WHERE `SOPHONG`='$soPhong'
                        $update = DB::table('solanthuephong')->where('SOPHONG','=',$soPhong)->update([
                            'SOLAN' => $sl
                        ]);
                        if($update > 0){
                            $_SESSION['successMessage'] = "Check out thành công.";
                            return redirect()->route('checkout');
                        }else{
                            $_SESSION['errorMessage'] = "Check out thất bại.";
                            return redirect()->route('checkout');
                        }
                    }else 
                    {
                        //insert số lần sd phòng
                        //INSERT INTO `solanthuephong`(`SOPHONG`, `SOLAN`) VALUES ('$soPhong',1)
                        $insert = db::table('solanthuephong')->insert([
                            'SOPHONG' => $soPhong,
                            'SOLAN' => 1
                        ]);
                        if($insert > 0){
                            $_SESSION['successMessage'] = "Check out thành công.";
                            return redirect()->route('checkout');
                        }else{
                            $_SESSION['errorMessage'] = "Check out thất bại.";
                            return redirect()->route('checkout');
                        } 
                    }
                }
            }
        }else{
            //Tạo hóa đơn 
            $km = $tenKM.'-'.$soPhong;
            $danhSachKMMoi = $km;
            //INSERT INTO `hoadon`(`MAHOADON`, `NGAYNHANPHONG`, `NGAYTRAPHONG`, `SONGAYTHUE`,`THANHTIEN`,`MANV`, `MAKH`,
            //`DANHSACHPHONG`,`ThongTinKM`,`TRANGTHAI`)
            //VALUES ('$new_mahd','$ngayNhanPhong','$ngayTraPhong',$soNgayThue,$t,'$maNV','$maKH','$soPhong','$danhSachKMMoi',0)

            $createHD = DB::table('hoadon')
                ->insert([
                    'MAHOADON' => $new_mahd,
                    'NGAYNHANPHONG' => $ngayNhanPhong,
                    'NGAYTRAPHONG' => $ngayTraPhong,
                    'SONGAYTHUE' => $soNgayThue,
                    'THANHTIEN' => $t,
                    'MANV' => $idNV,
                    'MAKH' => $maKH,
                    'DANHSACHPHONG' => $soPhong,
                    'ThongTinKM' => $danhSachKMMoi,
                    'TRANGTHAI' => 0
                ]);
            if ($createHD > 0) {
                //UPDATE `phieudatphong` SET `TRANGTHAI`= 2 WHERE MAPHIEUDATPHONG = '$maphieudat'
                $updatePhieuDatPhong = DB::table('phieudatphong')
                    ->where('MAPHIEUDATPHONG','=',$maphieudat)
                    ->update([
                        'TRANGTHAI' => 2
                    ]);

                // Tạo chi tiết hóa đơn
                //INSERT INTO `cthd`(`MAHOADON`, `MAPHIEUDATPHONG`, `TONGTIEN`) VALUES ('$new_mahd','$maphieudat','$t')
                DB::table('cthd')
                    ->insert([
                        'MAHOADON' => $new_mahd,
                        'MAPHIEUDATPHONG' => $maphieudat,
                        'TONGTIEN' => $t
                    ]);

                //cập nhật số lần thuê phòng
                //SELECT * FROM `solanthuephong` WHERE `SOPHONG` = '$soPhong'
                $dataSL = DB::table('solanthuephong')->where('SOPHONG','=',$soPhong)->first();
                if($dataSL){
                    //UPDATE SỐ LƯỢNG 
                    $slCu = $dataSL->SOLAN;
                    $sl = $slCu + 1;

                    //UPDATE `solanthuephong` SET `SOLAN`='$sl' WHERE `SOPHONG`='$soPhong'
                    $update = DB::table('solanthuephong')
                        ->where('SOPHONG','=',$soPhong)
                        ->update([
                            'SOLAN' => $sl
                    ]);
                    if($update > 0){
                        $_SESSION['successMessage'] = "Check out thành công.";
                        return redirect()->route('checkout');
                    }else{
                        $_SESSION['errorMessage'] = "Check out thất bại.";
                        return redirect()->route('checkout');
                    }
                }else
                {
                    //insert số lần sd phòng
                    //INSERT INTO `solanthuephong`(`SOPHONG`, `SOLAN`) VALUES ('$soPhong',1)
                    $insertSL = DB::table('solanthuephong')
                        ->insert([
                            'SOPHONG' => $soPhong,
                            'SOLAN' => 1
                    ]);
                    if($insertSL > 0){
                        $_SESSION['successMessage'] = "Check out thành công.";
                        return redirect()->route('checkout');
                    }else{
                        $_SESSION['errorMessage'] = "Check out thất bại.";
                        return redirect()->route('checkout');
                    }
                }
            }
        }
    }

    public function customerHD(){
        //SELECT * FROM khachhang order by MAKH
        $dskh = DB::table('khachhang')->orderBy('MAKH')->get();

        $dsHoaDon = DB::table('hoadon')
                            ->join('khachhang','hoadon.MAKH','=','khachhang.MAKH')
                            ->join('nhanvien','hoadon.MANV','=','nhanvien.MANV')
                            ->orderBy('hoadon.MAHOADON')
                            ->get();
        return view('admin.hoadonKH',['dskh'=>$dskh,'dsHoaDon'=>$dsHoaDon]);
    }

    public function dsCustomerHD(Request $res){
        $nameKH = $res->input('nameKH');
        $dataHoaDon = DB::table('hoadon')
                            ->join('khachhang','hoadon.MAKH','=','khachhang.MAKH')
                            ->join('nhanvien','hoadon.MANV','=','nhanvien.MANV')
                            ->where('khachhang.HOTENKH','like','%'.$nameKH.'%')
                            ->get();
        $output = '
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body" style="height: 500px; overflow-y: scroll;">
                    <table class="table table-striped table-hover">
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
                        </thead> ';
                        $i = 1;
                        foreach($dataHoaDon as $item){
                            $tien = number_format($item->THANHTIEN, 0, ',', '.');
                            if ($item->TRANGTHAI == 1){
                                $output .='
                                    <tr style="text-align: center; line-height: 2;">
                                        <td>'.$i.'</td>
                                        <td>'.$item->MAHOADON.'</td>
                                        <td>'.$item->NGAYNHANPHONG.'</td>
                                        <td>'.$item->NGAYTRAPHONG.'</td>
                                        <td>'.$item->HOTENNV.'</td>
                                        <td>'.$item->HOTENKH.'</td>
                                        <td>'.$item->DANHSACHPHONG.'</td>
                                        <td>'.number_format($item->THANHTIEN,0,',','.').'</td>
                                        <td>
                                            <a href="xem-chi-tiet-hoa-don?MAHOADON='.$item->MAHOADON.'"
                                                class="btn btn-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>';
                            }else if($item->TRANGTHAI == 0){
                                $output .='
                                    <tr style="text-align: center; line-height: 2;">
                                        <td>'.$i.'</td>
                                        <td>'.$item->MAHOADON.'</td>
                                        <td>'.$item->NGAYNHANPHONG.'</td>
                                        <td>'.$item->NGAYTRAPHONG.'</td>
                                        <td>'.$item->HOTENNV.'</td>
                                        <td>'.$item->HOTENKH.'</td>
                                        <td>'.$item->DANHSACHPHONG.'</td>
                                        <td>'.number_format($item->THANHTIEN,0,',','.').'</td>
                                        <td>
                                            <a href="xem-chi-tiet-hoa-don?MAHOADON='.$item->MAHOADON.'"
                                                class="btn btn-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                                </svg>
                                            </a>
                                            <a  href="thanh-toan-hoa-don?MAHOADON='.$item->MAHOADON.'"
                                                class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                                                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>';
                            }
                            $i++;
                        }
                      $output .='
                    </table>s
                </div>
            </div>';
        echo $output;
    }

    public function detailsHD(Request $res){
        $id = $res->input('MAHOADON');
        //SELECT HD.*, KH.HOTENKH, NV.HOTENNV
        // FROM HOADON HD
        // JOIN KHACHHANG KH ON HD.MAKH = KH.MAKH
        // JOIN NHANVIEN NV ON HD.MANV = NV.MANV
        // WHERE HD.MAHOADON ='$maHD'
        $data = DB::table('hoadon')
            ->join('khachhang','hoadon.MAKH','=','khachhang.MAKH')
            ->join('nhanvien','hoadon.MANV','=','nhanvien.MANV')
            ->where('hoadon.MAHOADON','=',$id)
            ->first();

        //SELECT `MAPHIEUDATPHONG`, `TONGTIEN` FROM `cthd` WHERE `MAHOADON` ='$maHD'
        $dataCTHD = DB::table('cthd')
            ->where('MAHOADON','=',$id)
            ->get();
        return view('admin.xemChiTietHD',['id'=>$id,'data'=>$data,'dataCTHD'=>$dataCTHD]);
    }

    public function showPayHD(Request $res){
        $id = $res->input('MAHOADON');

        // SELECT HD.*, KH.HOTENKH, NV.HOTENNV
        // FROM HOADON HD
        // JOIN KHACHHANG KH ON HD.MAKH = KH.MAKH
        // JOIN NHANVIEN NV ON HD.MANV = NV.MANV
        // WHERE HD.MAHOADON ='$maHD'   
        $data = DB::table('hoadon')
            ->join('khachhang','hoadon.MAKH','=','khachhang.MAKH')
            ->join('nhanvien','hoadon.MANV','=','nhanvien.MANV')
            ->where('hoadon.MAHOADON','=',$id)
            ->first();                                                           

        
        $dataCTHD = DB::table('cthd')
        ->where('MAHOADON','=',$id)
        ->get();
    return view('admin.thanhToanHD',['id'=>$id,'data'=>$data,'dataCTHD'=>$dataCTHD]);
    }

    public function payHD(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }
        $id = $res->input('MAHOADON');
        $ngayTra = $res->input('NGAYTRAPHONG');
        $tongtien = $res->input('THANHTIEN');

        //"UPDATE `hoadon` SET `TRANGTHAI`=1 WHERE `MAHOADON`='$maHD'";
        $updateHD = DB::table('hoadon')->where('MAHOADON','=',$id)->update(['TRANGTHAI'=>1]);
        if($updateHD > 0){
            //SELECT * FROM `thongke` WHERE `ngay` = '$ngayTra'";
            $dataThongKe = DB::table('thongke')->where('ngay','=',$ngayTra)->first();
            if($dataThongKe){
                //Cập nhật doanh thu
                $doanhThuCu = $dataThongKe->doanhthu;
                $moi =  $doanhThuCu + $tongtien;
                //UPDATE `thongke` SET `doanhthu`= $moi WHERE `ngay`='$ngayTra'";
                $updateDoanhThu = DB::table('thongke')->where('ngay','=',$ngayTra)->update(['doanhthu'=>$moi]);
                if($updateDoanhThu > 0){
                    $_SESSION['successMessage'] = "Thanh toán thành công.";
                    return redirect()->route('customerHD');
                }else{
                    $_SESSION['errorMessage'] = "Thanh toán thất bại.";
                    return redirect()->route('customerHD');
                }                    
            }else{
                //tạo doanh thu mới
                //INSERT INTO `thongke`(`ngay`, `doanhthu`) VALUES ('$ngayTra','$tongtien')
                $insertDoanhThu =  DB::table('thongke')->insert([
                    'ngay'=>$ngayTra,
                    'doanhthu'=>$tongtien
                ]);
                if($insertDoanhThu > 0){
                    $_SESSION['successMessage'] = "Thanh toán thành công.";
                    return redirect()->route('customerHD');
                }else{
                    $_SESSION['errorMessage'] = "Thanh toán thất bại.";
                    return redirect()->route('customerHD');
                }    
            }
        }
    }
}
