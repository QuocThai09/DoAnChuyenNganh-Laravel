<?php

namespace App\Http\Controllers;

use App\Models\TaiKhoan;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class ClientController extends Controller
{
    public function index(){

        //SELECT * FROM `loaiphong`
        $DBloai_phong = DB::table('loaiphong')->get();

        //SELECT * FROM `dichvu`
        $DBdich_vu = DB::table('dichvu')->get();

        //SELECT DIEMDANHGIA, NHANXET, khachhang.HOTENKH AS HOTEN FROM `feedback`, phieudatphong, khachhang 
        //WHERE feedback.MAPHIEUDATPHONG = phieudatphong.MAPHIEUDATPHONG AND phieudatphong.MAKH = khachhang.MAKH"
        $DBdanh_gia = DB::table('feedback')
            ->join('phieudatphong','phieudatphong.MAPHIEUDATPHONG','=','feedback.MAPHIEUDATPHONG')
            ->join('khachhang','khachhang.MAKH','=','phieudatphong.MAKH')
            ->select('DIEMDANHGIA','NHANXET','khachhang.HOTENKH AS HOTEN')
            ->get();
        return view('client.TrangChu',['DBloai_phong'=>$DBloai_phong,'DBdich_vu'=>$DBdich_vu,'DBdanh_gia'=>$DBdanh_gia]);
    }

    public function login(Request $res){
        $data = DB::table('taikhoan')
            ->join('khachhang','khachhang.TAIKHOAN','=','taikhoan.TAIKHOAN')
            ->where([
                ['taikhoan.TAIKHOAN','=',$res->email_dn],
                ['MATKHAU','=',$res->pw_dn]
            ])
            ->first();
        if($data && $data->MAPQ == 3){
            if(!isset($_SESSION)) session_start();

            $_SESSION['client'] =  $data;
            //dd($_SESSION['client']);
            $_SESSION['successMessage'] = "Đăng nhập thành công.";
            return redirect('client/');
        }else{
            $_SESSION['errorMessage'] = "Đăng nhập thất bại.";
            return redirect('client/');
        }
    }

    public function logout(){
        session_start();
        unset($_SESSION['client']);
        $_SESSION['successMessage'] = "Đăng xuất thành công.";
        return redirect('client/');
    }

    public function bookRoomDetail(Request $res){
        
        $id = $res->MALOAIPHONG;
        $ngayDen = $res->ngayDen;
        $ngayDi = $res->ngayDi;

        $diemDG = $this->tinhtb_DanhGia($id);

        $data = DB::table('loaiphong')->where('MALOAIPHONG','=',$id)->first();
        return view('client.Phong',['data'=>$data,'ngayDen'=>$ngayDen,'ngayDi'=>$ngayDi,'diemDG'=>$diemDG]);
    }

    public function searchQuanlityRoomDetail(Request $res){
        $ngayDen = $res->ngayDen;
        $ngayDi = $res->ngayDi;
        $maLP = $res->maLP;
        $sl_ConLai = $this->lay_SLPhong($maLP) - $this->loc_PhongTheoNgay($maLP, $ngayDen, $ngayDi);
        $output = 'Số Phòng Còn Trống: '.$sl_ConLai;
        echo $output;
    }

    public function bookRoom(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $id = $res->MALOAIPHONG;
        //Select * from LOAIPHONG where MALOAIPHONG = '$ma_phong'
        $data = DB::table('loaiphong')->where('MALOAIPHONG','=',$id)->first();
        return view('client.DatPhong',['data'=>$data]);
    }

    public function searchQuanlityRoom(Request $res){
        $ngayDen = $res->ngayDen;
        $ngayDi = $res->ngayDi;
        $maLP = $res->maLP;
        $sl_ConLai = $this->lay_SLPhong($maLP) - $this->loc_PhongTheoNgay($maLP, $ngayDen, $ngayDi);
        $tongTien = $this->tinh_Tien($maLP, $ngayDen, $ngayDi);
        $soTienVND = number_format($tongTien, 0, ',', '.') . ' VND';
        $output = '<label class="form-label">Số Phòng Còn Trống :'.$sl_ConLai.'
                    </label>
                    <div class="col-md-12">
                        <label class="form-label">Tổng Tiền : '.$soTienVND.'
                        </label>
                        <input type="hidden" name="total" value="'.$tongTien.'">
                    </div>';
        echo $output;
    }

    public function closeOrderRoom(Request $res){
        session_start();
        $dateNow = Carbon::now()->format('Y-m-d');
        $maKH = $_SESSION['client']->MAKH;
        $maLP = $res->MaLP;
        $ngayDen = $res->NgayDen;
        $ngayDi = $res->NgayDi;
        $total = $res->total;

        // Tạo mã đặt lịch (MAPHIEUDATPHONG) dạng "PDP" kết hợp với số nguyên tăng dần
        //SELECT MAX(CAST(SUBSTRING(MAPHIEUDATPHONG, 4) AS UNSIGNED)) AS max_mapdp FROM PHIEUDATPHONG
        $countMaPDP = DB::table('phieudatphong')
            ->select(DB::raw('MAX(CAST(SUBSTRING(MAPHIEUDATPHONG, 4) AS UNSIGNED)) AS max_mapdp'))
            ->first();
        if($countMaPDP){
            $max_mapdp = $countMaPDP->max_mapdp;
            $new_mapdp = "PDP" . ($max_mapdp + 1);
        }else{
            $new_mapdp = "PDP1";
        }
        
        $createPDP = DB::table('phieudatphong')
            ->insert([
                'MAPHIEUDATPHONG' => $new_mapdp,
                'NGAYDATPHONG' => $dateNow,
                'NGAYNHANPHONG' => $ngayDen,
                'NGAYTRAPHONG' => $ngayDi,
                'MAKH' => $maKH,
                'MALOAIPHONG' => $maLP,
                'TONGTIENPDP' => $total,
                'TRANGTHAI' => 0,
            ]);

        if ($createPDP > 0) {
            $_SESSION['successMessage'] = "Đặt phòng thành công.";
            return redirect()->route('all-lich-dat-phong');
        }else{
            $_SESSION['errorMessage'] = "Đặt phòng thất bại.";
            return redirect()->route('all-lich-dat-phong');
        }
    }

    public function allBookRoom(){
        if(!isset($_SESSION)){
            session_start();
        }
        //SELECT TENLOAIPHONG, PHIEUDATPHONG.* FROM PHIEUDATPHONG, LOAIPHONG 
        //WHERE MAKH = '" . $_SESSION['MAKH'] . "' AND LOAIPHONG.MALOAIPHONG = PHIEUDATPHONG.MALOAIPHONG
        $data = DB::table('phieudatphong')
            ->join('loaiphong','loaiphong.MALOAIPHONG','=','phieudatphong.MALOAIPHONG')
            ->where('MAKH','=',$_SESSION['client']->MAKH)
            ->get();
        return view('client.LichDatPhong',['data'=>$data]);
    }

    public function removeBookRoom(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }
        $ma_pdp = $res->MAPHIEUDATPHONG;
        $ngayNhanPhong = Carbon::parse($res->NGAYNHANPHONG);
        $dateTimeNow = Carbon::parse(Carbon::now()->format('Y-m-d'));
        
        // Tính toán khoảng cách giữa ngày nhận và ngày hiện tại
        $diffInDays = $dateTimeNow->diffInDays($ngayNhanPhong);
        if($diffInDays <= 2){
            $_SESSION['errorMessage'] = "Trước 2 Ngày Không Thể Hủy.";
            return redirect()->route('all-lich-dat-phong');
        }
        
        //DELETE FROM PHIEUDATPHONG WHERE MAPHIEUDATPHONG = '$ma_pdp'
        $deletePDP = DB::table('phieudatphong')
            ->where('MAPHIEUDATPHONG','=',$ma_pdp)
            ->delete();
        if ($deletePDP > 0) {
            $_SESSION['successMessage'] = "Hủy phòng thành công.";
            return redirect()->route('all-lich-dat-phong');
        } else {
            $_SESSION['errorMessage'] = "Hủy phòng thất bại.";
            return redirect()->route('all-lich-dat-phong');
        }
    }

    public function addFeedBack(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $diem = $res->Rating;
        $review = $res->review;
        $dateNow = Carbon::now()->format('Y-m-d');
        $maPDP = $res->maPDP;  

        //SELECT MAX(CAST(SUBSTRING(MAFB, 3) AS UNSIGNED)) AS max_mafb FROM FEEDBACK
        $maFB = DB::table('feedback')->select(DB::raw('MAX(CAST(SUBSTRING(MAFB, 3) AS UNSIGNED)) AS max_mafb'))->first();
        $new_mafb = "FB" . ($maFB->max_mafb + 1);
        //INSERT INTO `feedback` (`MAFB`, `DIEMDANHGIA`, `NHANXET`, `NGAYDANHGIA`, `MAPHIEUDATPHONG`) 
        //VALUES ('$new_mafb', '$Rating', '$review', '$currentDateTime', '$ma_pdp1');";
        $insertDB = DB::table('feedback')->insert([
            'MAFB'=>$new_mafb,
            'DIEMDANHGIA'=>$diem,
            'NHANXET'=>$review,
            'NGAYDANHGIA'=>$dateNow,
            'MAPHIEUDATPHONG'=>$maPDP
        ]);
        if($insertDB > 0){
            $_SESSION['successMessage'] = "Đánh giá thành công";
            return redirect()->route('all-lich-dat-phong');
        }else{
            $_SESSION['erorrMessage'] = "Đánh giá thất bại";
            return redirect()->route('all-lich-dat-phong');
        }
    }

    public function lay_SLPhong($ma_loai_phong){
        //SELECT LOAIPHONG.MALOAIPHONG, COUNT(*) AS SOLUONG
        // FROM LOAIPHONG, PHONG
        // WHERE LOAIPHONG.MALOAIPHONG = '$ma_loai_phong' 
        //AND  LOAIPHONG.MALOAIPHONG = PHONG.MALOAIPHONG AND PHONG.MAPHONG != 'P008'
        // GROUP BY LOAIPHONG.MALOAIPHONG;
        $count = DB::table('phong')
            ->join('loaiphong','loaiphong.MALOAIPHONG','=','phong.MALOAIPHONG')
            ->where('phong.MALOAIPHONG','=',$ma_loai_phong)
            ->count();
        return $count ? $count : 0;
    }

    public function detailRoom(Request $res){
        $id = $res->maLP;
        //Select * from LOAIPHONG where MALOAIPHONG = '$ma_phong'";
        $data = DB::table('loaiphong')
            ->where('MALOAIPHONG','=',$id)
            ->get();
        
        $diemDG = $this->tinhtb_DanhGia($id);

        // SELECT PHIEUDATPHONG.MALOAIPHONG, HOTENKH, FEEDBACK.* 
        //     FROM FEEDBACK, PHIEUDATPHONG, KHACHHANG 
        //     WHERE FEEDBACK.MAPHIEUDATPHONG = PHIEUDATPHONG.MAPHIEUDATPHONG 
        //     AND PHIEUDATPHONG.MAKH = KHACHHANG.MAKH 
        //     AND PHIEUDATPHONG.MALOAIPHONG = '$ma_phong'
        $feedbackDB = DB::table('feedback')
            ->join('phieudatphong','feedback.MAPHIEUDATPHONG','=','phieudatphong.MAPHIEUDATPHONG')
            ->join('khachhang','phieudatphong.MAKH','=','khachhang.MAKH')
            ->where('phieudatphong.MALOAIPHONG','=',$id)
            ->get();

        return view('client.detailRoom',['data'=>$data,'diemDG'=>$diemDG,'feedbackDB'=>$feedbackDB]);
    }



    public function loc_PhongTheoNgay($ma_loai_phong, $ngay_den, $ngay_di){
        // SELECT PHIEUDATPHONG.MALOAIPHONG, COUNT(*) AS SOLUONGPHONG
        //FROM PHIEUDATPHONG
        //WHERE ((PHIEUDATPHONG.NGAYNHANPHONG BETWEEN '$ngay_den' AND '$ngay_di') 
        //OR (PHIEUDATPHONG.NGAYTRAPHONG BETWEEN '$ngay_den' AND '$ngay_di')) 
        //AND PHIEUDATPHONG.MALOAIPHONG = '$ma_loai_phong'
        //GROUP BY PHIEUDATPHONG.MALOAIPHONG;
        $count =  DB::table('phieudatphong')
            ->join('loaiphong','loaiphong.MALOAIPHONG','=','loaiphong.MALOAIPHONG')
            ->where('phieudatphong.MALOAIPHONG','=',$ma_loai_phong)
            ->whereBetween('phieudatphong.NGAYNHANPHONG', [$ngay_den, $ngay_di])
            ->orWhereBetween('phieudatphong.NGAYTRAPHONG', [$ngay_den, $ngay_di])
            ->count();
        return $count ? $count : 0;
    }

    public function tinh_Tien($ma_loai_phong, $ngay_den, $ngay_di){
        //SELECT GIANGAYTHUONG FROM LOAIPHONG WHERE MALOAIPHONG = '$ma_loai_phong'
        $data = DB::table('loaiphong')
            ->where('MALOAIPHONG','=',$ma_loai_phong)
            ->first();
        $date1 = Carbon::parse($ngay_den);
        $date2 = Carbon::parse($ngay_di);
        $diffInDays = $date1->diffInDays($date2);
        $tong_Tien = $data->GIANGAYTHUONG * $diffInDays;
        return $tong_Tien;
    }

    public function tinhtb_DanhGia($ma_loai_phong){
        //SELECT MALOAIPHONG, AVG(DIEMDANHGIA) AS TRUNGBINH
        //FROM FEEDBACK, PHIEUDATPHONG
        //WHERE FEEDBACK.MAPHIEUDATPHONG = PHIEUDATPHONG.MAPHIEUDATPHONG AND MALOAIPHONG = '$ma_phong'
        //GROUP BY MALOAIPHONG;
        $DB_tbDanhGia = DB::table('feedback')
            ->join('phieudatphong','phieudatphong.MAPHIEUDATPHONG','=','feedback.MAPHIEUDATPHONG')
            ->where('MALOAIPHONG','=',$ma_loai_phong)
            ->avg('DIEMDANHGIA');
        return $DB_tbDanhGia ? $DB_tbDanhGia : 0;
    }




}
