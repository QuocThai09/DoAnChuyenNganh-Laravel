<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManageController extends Controller
{
    public function account(){
        //SELECT * FROM taikhoan order by TAIKHOAN
        $data = DB::table('taikhoan')
            ->orderBy('TAIKHOAN')->get();
        
        $dataPhanQuyen = DB::table('phanquyen')->get();
        return view('admin.taikhoan',['data'=>$data,'dataPhanQuyen'=>$dataPhanQuyen]);
        
    }
    public function createAccount(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $taikhoan = $res->TAIKHOAN;
        $matkhau = $res->MATKHAU;
        $mapq = $res->MAPQ;

        //INSERT INTO `taikhoan`(`TAIKHOAN`, `MATKHAU`, `MAPQ`) VALUES ('$taikhoan','$matkhau','$mapq')
        $insertData = DB::table('taikhoan')->insert([
            'TAIKHOAN' => $taikhoan,
            'MATKHAU' => $matkhau,
            'status' => 0,
            'MAPQ' => $mapq
        ]);
        if ($insertData > 0) {
            $_SESSION['successMessage'] = "Thêm tài khoản thành công.";
            return redirect()->route('account');
        } else {
            $_SESSION['errorMessage'] = "Thêm tài khoản thất bại.";
            return redirect()->route('account');
        }
    }

    public function deleteAccount(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }
        $data = $res->TAIKHOAN;

        //DELETE FROM `taikhoan` WHERE TAIKHOAN = ?
        $deleteAccount = DB::table('taikhoan')
            ->where('TAIKHOAN','=',$data)
            ->delete();

        if ($deleteAccount > 0) {
            $_SESSION['successMessage'] = "Xóa tài khoản thành công.";
            return redirect()->route('account');
        } else {
            $_SESSION['errorMessage'] = "Xóa tài khoản thất bại.";
            return redirect()->route('account');
        }
    }

    public function updateAccount(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }
        $taikhoan = $res->TAIKHOAN;
        $mapq = $res->MAPQ;

        $updateData = DB::table('taikhoan')
            ->where('TAIKHOAN','=',$taikhoan)
            ->update([
            'MAPQ' => $mapq
        ]);

        if ($updateData > 0) {
            $_SESSION['successMessage'] = "Update tài khoản thành công.";
            return redirect()->route('account');
        } else {
            $_SESSION['errorMessage'] = "Update tài khoản thất bại.";
            return redirect()->route('account');
        }
    }

    public function nhanVien(Request $res){
        //SELECT * FROM NHANVIEN order by MANV
        $id = $res->TAIKHOAN;
        $data = DB::table('nhanvien')
            ->orderBy('MANV')->get();
        return view('admin.nhanVien',['id'=>$id,'data'=>$data]);
        
    }

    public function createNhanVien(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        echo $manv = $res->MANV;
        echo $hotennv = $res->HOTENNV;
        echo $chucvu = $res->CHUCVU;
        echo $namsinh = $res->NAMSINH;
        echo $gioitinh = $res->GIOITINH;
        echo $diachi = $res->DIACHI;
        echo $sdtnv = $res->SDTNV;

        // SELECT COUNT(*) FROM `nhanvien` WHERE `MANV`='$manv'
        $selectNV = DB::table('nhanvien')
            ->where('MANV','=',$manv)
            ->first();
        if ($selectNV != null) {
            $_SESSION['errorMessage'] = "Lỗi: Mã nhân viên đã tồn tại.";
            return redirect()->route('nhanVien');
        }

        if ($chucvu == 0) {
            $_SESSION['errorMessage'] = "Lỗi: Hãy chọn chức vụ.";
            return redirect()->route('nhanVien');
        }

        //INSERT INTO `nhanvien`(`MANV`, `HOTENNV`, `CHUCVU`, `NAMSINH`, `GIOITINH`, `DIACHI`, `SDTNV`) 
        //VALUES ('$manv','$hotennv','$chucvu','$namsinh','$gioitinh','$diachi','$sdtnv')
        $insertData = DB::table('nhanvien')->insert([
            'MANV' => $manv,
            'HOTENNV' => $hotennv,
            'CHUCVU' => $chucvu,
            'NAMSINH' => $namsinh,
            'GIOITINH' => $gioitinh,
            'DIACHI' => $diachi,
            'SDTNV' => $sdtnv
        ]);
        if ($insertData > 0) {
            $_SESSION['successMessage'] = "Thêm nhân viên thành công.";
            return redirect()->route('nhanVien');
        } else {
            $_SESSION['errorMessage'] = "Thêm nhân viên thất bại.";
            return redirect()->route('nhanVien');
        }
    }

    public function showNhanVien(Request $res){
        $id  = $res->MANV;
        //SELECT * FROM nhanvien WHERE MANV='$manv'
        $data = DB::table('nhanvien')
            ->where('MANV','=',$id)
            ->first();

        //select account status =  0
        $dataAccount = DB::table('taikhoan')
            ->where('status','=',0)
            ->whereIn('MAPQ',[1,2])
            ->get();
        return view('admin.edit_nhanvien',['id'=>$id,'data'=>$data,'dataAccount'=>$dataAccount]);
        
    }

    public function updateNhanVien(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $manv = $res->MANV;
        $hotennv = $res->HOTENNV;
        $chucvu = $res->CHUCVU;
        $namsinh = $res->NAMSINH;
        $gioitinh = $res->GIOITINH;
        $diachi = $res->DIACHI;
        $sdtnv = $res->SDTNV;
        $taikhoan = $res->TAIKHOAN;

        //UPDATE `nhanvien` SET `HOTENNV`='$hotennv',`CHUCVU`='$chucvu',`NAMSINH`='$namsinh',`GIOITINH`='$gioitinh',
        //`DIACHI`='$diachi',`SDTNV`='$sdtnv',`TAIKHOAN`='$taikhoan' WHERE `MANV`='$manv'
        if($taikhoan == 0){
            $updateData = DB::table('nhanvien')
                ->where('MANV','=',$manv)
                ->update([
                    'HOTENNV' => $hotennv,
                    'CHUCVU' => $chucvu,
                    'NAMSINH' => $namsinh,
                    'GIOITINH' => $gioitinh,
                    'DIACHI' => $diachi,
                    'SDTNV' => $sdtnv,
            ]);
        }else{
            $updateData = DB::table('nhanvien')
                ->where('MANV','=',$manv)
                ->update([
                    'HOTENNV' => $hotennv,
                    'CHUCVU' => $chucvu,
                    'NAMSINH' => $namsinh,
                    'GIOITINH' => $gioitinh,
                    'DIACHI' => $diachi,
                    'SDTNV' => $sdtnv,
                    'TAIKHOAN' => $taikhoan
            ]);
            DB::table('taikhoan')->where('TAIKHOAN','=',$taikhoan)->update(['status'=>1]);
        }
        if ($updateData  > 0) {
            $_SESSION['successMessage'] = "Cập nhật nhân viên thành công";
            return redirect()->route('nhanVien');
        } else {
            $_SESSION['errorMessage'] = "Lỗi: Cập nhật nhân viên thất bại";
            return redirect()->route('nhanVien');
        }
    }

    public function deleteNhanVien(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }
        echo $id = $res->MANV;
        echo $taikhoan = $res->TAIKHOAN;

        $deleteAccount =  DB::table('nhanvien')
        ->where('MANV','=',$id)
        ->delete();

        if($taikhoan != ""){
            DB::table('taikhoan')->where('TAIKHOAN','=',$taikhoan)->update([
                'status' => 0
            ]);
        }    
        if ($deleteAccount > 0) {
            $_SESSION['successMessage'] = "Xóa nhân viên thành công.";
            return redirect()->route('nhanVien');
        } else {
            $_SESSION['errorMessage'] = "Xóa nhân viên thất bại.";
            return redirect()->route('nhanVien');
        }
    }

    public function customer(Request $res){
        echo $id = $res->TAIKHOAN;
        $data = DB::table('khachhang')
            ->orderBy('MAKH')
            ->get();
        return view('admin.danhsachKH',['id'=>$id,'data'=>$data]);
    }

    public function createCustomer(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $makh = $res->MAKH;
        $tenkh = $res->HOTENKH;
        $sdt = $res->SDTKH;
        $cmnd = $res->CMNDKH;
        $loaikh = $res->LOAIKHACHHANG;
        $taikhoan = null;


        $insertData = DB::table('khachhang')->insert([
            'MAKH' => $makh,
            'HOTENKH' => $tenkh,
            'SDTKH' => $sdt,
            'CMNDKH' => $cmnd,
            'LOAIKHACHHANG' => intval($loaikh)
        ]);
        if ($insertData > 0) {
            $_SESSION['successMessage'] = "Thêm khách hàng thành công.";
            return redirect()->route('customer');
        } else {
            $_SESSION['errorMessage'] = "Thêm khách hàng thất bại.";
            return redirect()->route('customer');
        }

    }

    public function showCustomer(Request $res){
        $id  = $res->MAKH;

        $data = DB::table('khachhang')
            ->where('MAKH','=',$id)
            ->first();
        return view('admin.editKH',['id'=>$id,'data'=>$data]);
        
    }

    public function updateCustomer(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $makh = $res->MAKH;
        $tenkh = $res->HOTENKH;
        $sdt = $res->SDTKH;
        $cmnd = $res->CMNDKH;
        $loaikh = $res->LOAIKHACHHANG;
        $taikhoan = $res->TAIKHOAN;

        //UPDATE `khachhang` SET `SDTKH`='$sdt', `CMNDKH`='$cmnd', `HOTENKH`='$tenkh', `LOAIKHACHHANG`='$loaikh' 
        //,`TAIKHOAN` = '$taikhoan' WHERE `MAKH`='$makh'";
        $updateData = DB::table('khachhang')
            ->where('MAKH','=',$makh)
            ->update([
                'SDTKH' => $sdt,
                'CMNDKH' => $cmnd,
                'HOTENKH' => $tenkh,
                'LOAIKHACHHANG' => intval($loaikh),
                'TAIKHOAN' => $taikhoan
        ]);
        if ($updateData  > 0) {
            $_SESSION['successMessage'] = "Cập nhật thông tin khách hàng thành công.";
            return redirect()->route('customer');
        } else {
            $_SESSION['errorMessage'] = "Lỗi: Cập nhật thông tin khách hàng thất bại.";
            return redirect()->route('customer');
        }

    }

    public function room(){
        $data = DB::table('phong')
            ->join('loaiphong','phong.MALOAIPHONG','=','loaiphong.MALOAIPHONG')
            ->join('tanglau','phong.MATANGLAU','=','tanglau.MATANGLAU')
            ->orderBy('MAPHONG')
            ->get();
        
        $dataLoaiPhong = DB::table('loaiphong')
            ->get();

        $dataTang = DB::table('tanglau')
            ->get();
        return view('admin.phong',['data'=>$data,'dataLoaiPhong'=>$dataLoaiPhong,'dataTang'=>$dataTang]);
        
    }

    public function createRoom(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $maphong = $res->MAPHONG;
        $sophong = $res->SOPHONG;
        $ghichu = trim($res->GHICHU);
        $matanglau = $res->MATANGLAU;
        $maloaiphong = $res->MALOAIPHONG;

        // Kiểm tra xem MAPHONG đã tồn tại hay chưa
        //SELECT COUNT(*) FROM `phong` WHERE `MAPHONG`='$maphong'";
        $kiemtraID = DB::table('phong')->where('MAPHONG','=',$maphong)->first();

        if ($kiemtraID != null) {
            $_SESSION['errorMessage'] = "Lỗi: Mã phòng đã tồn tại.";
            return redirect()->route('room');
        }

        //INSERT INTO `phong`(`MAPHONG`, `SOPHONG`, `GHICHU`, `TRANGTHAIPHONG`, `MALOAIPHONG`, `MATANGLAU`) 
        //VALUES ('$maphong','$sophong','$ghichu','$trangthaiphong','$maloaiphong','$matanglau')";
        $insertData = DB::table('phong')->insert([
            'MAPHONG' => $maphong,
            'SOPHONG' => $sophong,
            'GHICHU' => $ghichu,
            'TRANGTHAIPHONG' => 0,
            'MALOAIPHONG' => $maloaiphong,
            'MATANGLAU' => $matanglau
        ]);
        if ($insertData > 0) {
            $_SESSION['successMessage'] = "Thêm phòng thành công.";
            return redirect()->route('room');
        } else {
            $_SESSION['errorMessage'] = "Thêm phòng thất bại.";
            return redirect()->route('room');
        }
    }

    public function showRoom(Request $res){
        $id = $res->MAPHONG;
        $data = DB::table('phong')
            ->join('loaiphong','phong.MALOAIPHONG','=','loaiphong.MALOAIPHONG')
            ->join('tanglau','phong.MATANGLAU','=','tanglau.MATANGLAU')
            ->where('MAPHONG','=',$id)
            ->first();

        $dataLoaiPhong = DB::table('loaiphong')
            ->get();

        $dataTang = DB::table('tanglau')
            ->get();
        return view('admin.edit_phong',['data'=>$data,'id'=>$id,'dataLoaiPhong'=>$dataLoaiPhong,'dataTang'=>$dataTang]);
        
    }

    public function updateManageRoom(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $maphong = $res->MAPHONG;
        $sophong = $res->SOPHONG;
        $ghichu = $res->GHICHU;
        $trangthaiphong = $res->TRANGTHAIPHONG;
        $matanglau = $res->MATANGLAU;
        $maloaiphong = $res->MALOAIPHONG;

        //UPDATE `phong` SET `SOPHONG`='$sophong',`GHICHU`='$ghichu',`TRANGTHAIPHONG`='$trangthaiphong',
        //`MALOAIPHONG`='$maloaiphong ',`MATANGLAU`='$matanglau' WHERE `MAPHONG`='$maphong'"
        $updateData = DB::table('phong')
            ->where('MAPHONG','=',$maphong)
            ->update([
                'SOPHONG' => $sophong,
                'GHICHU' => $ghichu,
                'MALOAIPHONG' => $maloaiphong,
                'MATANGLAU' => $matanglau
        ]);
        if ($updateData  > 0) {
            $_SESSION['successMessage'] = "Cập nhật thông tin phòng thành công.";
            return redirect()->route('room');
        } else {
            $_SESSION['errorMessage'] = "Lỗi: Cập nhật thông tin phòng thất bại.";
            return redirect()->route('room');
        }

    }

    public function deleteRoom(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $id = $res->MAPHONG;

        $deleteRoom = DB::table('phong')
            ->where('MAPHONG','=',$id)
            ->delete();

        if ($deleteRoom > 0) {
            $_SESSION['successMessage'] = "Xóa phòng thành công.";
            return redirect()->route('room');
        } else {
            $_SESSION['errorMessage'] = "Xóa phòng thất bại.";
            return redirect()->route('room');
        }
    }

    public function diagramRoom(){

        //SELECT * FROM TANGLAU order by MATANGLAU
        $data = DB::table('tanglau')
            ->orderBy('MATANGLAU')
            ->get();
        return view('admin.soDoPhong',['data'=>$data]);
        
    }

    public function mapRoom(Request $res){
        $tenTangLau = $res->tanglau;
        
        $dataTangLau = DB::table('tanglau')->where('TENTANGLAU','=',$tenTangLau)->first();

        //SELECT * FROM phong where MATANGLAU = '$maTang'
        $dataRoom = DB::table('phong')->where('MATANGLAU','=',$dataTangLau->MATANGLAU)->orderBy('MAPHONG')->get();

        $countRoom = $dataRoom->count();
        $table  = "<table>";
        $count = 0;
        $table .= "<tr>";
        foreach($dataRoom as $val){
            if($count < 5){
                if($val->SOPHONG == "tm"){
                    $table .= '<td>
                                    <div class="card" style="margin: 10px;width: 200px; background-color: #33CC66;">
                                        <div class="card-header"></div>
                                        <div class="card-body" >
                                            <blockquote class="blockquote mb-0">
                                                <p >'.$val->GHICHU.'</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                </td>';
                }else if($val->TRANGTHAIPHONG == 0){
                    $table .= '<td> 
                                    <div class="card" style="margin: 10px;width: 200px;">
                                        <div class="card-header">
                                            '.$val->SOPHONG.'
                                        </div>
                                        <div class="card-body" >
                                            <blockquote class="blockquote mb-0">
                                                <p >'.$val->GHICHU.'</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                </td>';
                }else{
                    $table .= '<td>
                                    <div class="card" style="margin: 10px;width: 200px;background-color: #66CCFF;">
                                        <div class="card-header">
                                            '.$val->SOPHONG.'
                                        </div>
                                        <div class="card-body" >
                                            <blockquote class="blockquote mb-0">
                                                <p >'.$val->GHICHU.'</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                </td>';
                }
                
                $count ++;
            }else{
                $table .= "</tr>";
                $count =  0;
                $table .= "<tr>";
                if($val->SOPHONG == "tm"){
                    $table .= '<td>
                                    <div class="card" style="margin: 10px;width: 200px; background-color: #33CC66;">
                                        <div class="card-header"></div>
                                        <div class="card-body" >
                                            <blockquote class="blockquote mb-0">
                                                <p >'.$val->GHICHU.'</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                </td>';
                }else if($val->TRANGTHAIPHONG == 0){
                    $table .= '<td> 
                                    <div class="card" style="margin: 10px;width: 200px;">
                                        <div class="card-header">
                                            '.$val->SOPHONG.'
                                        </div>
                                        <div class="card-body" >
                                            <blockquote class="blockquote mb-0">
                                                <p >'.$val->GHICHU.'</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                </td>';
                }else{
                    $table .= '<td>
                                    <div class="card" style="margin: 10px;width: 200px;background-color: #66CCFF;">
                                        <div class="card-header">
                                            '.$val->SOPHONG.'
                                        </div>
                                        <div class="card-body" >
                                            <blockquote class="blockquote mb-0">
                                                <p >'.$val->GHICHU.'</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                </td>';
                }
            }
        }
        $table .= "</tr>";
        $table  .= "</table>";
        echo $table;
    }
    
    public function service(){
        $data = DB::table('dichvu')
            ->orderBy('MADICHVU')
            ->get();
        
        return view('admin.danhSachDichVu',['data'=>$data]);
        
    }

    public function createService(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $madv = trim($res->MADICHVU);
        $tendv = trim($res->TENDICHVU);
        $dongia = $res->DONGIADV;
        $dvt = $res->DVT;
        $trangthai = $res->TRANGTHAIDICHVU;
        $gioithieu = trim($res->GIOITHIEUDV);
        $image = $res->image;
        $imageName = $image->getClientOriginalName();

        //SELECT COUNT(*) FROM `dichvu` WHERE `MADICHVU`='$madv'
        $selectDV = DB::table('dichvu')->where('MADICHVU','=',$madv)->first();
        if ($selectDV) {
            $_SESSION['errorMessage'] = "Lỗi: Mã dịch vụ đã tồn tại.";
            return redirect()->route('service');
        }

        //INSERT INTO `dichvu` (`MADICHVU`, `TENDICHVU`, `DONGIADV`, `DVT`, `TRANGTHAIDICHVU`) VALUES (?, ?, ?, ?, ?)
        $createDV = DB::table('dichvu')
            ->insert([
                'MADICHVU' => $madv,
                'TENDICHVU' => $tendv,
                'DONGIADV' => $dongia,
                'DVT' => $dvt,
                'TRANGTHAIDICHVU' => intval($trangthai),
                'GIOITHIEUDV' => $gioithieu,
                'HINHDV' => $imageName
            ]);
        if ($createDV > 0) {
            //Storage::disk('local')->put('images/service', $image);
            $image->move('images/service',$imageName);
            $_SESSION['successMessage'] = "Thêm dịch vụ thành công.";
            return redirect()->route('service');
        } else {
            $_SESSION['errorMessage'] = "Lỗi: Thêm dịch vụ thất bại.";
            return redirect()->route('service');
        }
    }

    public function updateService(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $madv = trim($res->MADICHVU);
        $tendv = trim($res->TENDICHVU);
        $dongia = $res->DONGIADV;
        $dvt = $res->DVT;
        $trangthai = $res->TRANGTHAIDICHVU;
        $gioithieu = trim($res->GIOITHIEUDV);
        $image = $res->image;

        $imageName = $image->getClientOriginalName();

        //UPDATE `dichvu` SET `TENDICHVU`='$tendv',`DONGIADV`='$dongia',`DVT`='$dvt',`TRANGTHAIDICHVU`='$trangthai' 
        //WHERE `MADICHVU`='$madv'";
        $createDV = DB::table('dichvu')
            ->where('MADICHVU','=',$madv)
            ->update([
                'TENDICHVU' => $tendv,
                'DONGIADV' => $dongia,
                'DVT' => $dvt,
                'TRANGTHAIDICHVU' => intval($trangthai),
                'GIOITHIEUDV' => $gioithieu,
                'HINHDV' => $imageName
            ]);
        if ($createDV > 0) {
            $imagePath = 'public/images/service/'.$imageName;
            if(Storage::exists($imagePath)){
                $_SESSION['successMessage'] = "Cập nhật dịch vụ thành công.";
                return redirect()->route('service');
            }else{
                $image->move('images/service',$imageName);
                $_SESSION['successMessage'] = "Cập nhật dịch vụ thành công.";
                return redirect()->route('service');
            }
        } else {
            $_SESSION['errorMessage'] = "Lỗi: Thêm dịch vụ thất bại.";
            return redirect()->route('service');
        }
    }

    public function deleteService(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $id = $res->MADICHVU;

        //DELETE FROM dichvu WHERE MADICHVU='$madv'
        $deleteRoom = DB::table('dichvu')
            ->where('MADICHVU','=',$id)
            ->delete();

        if ($deleteRoom > 0) {
            $_SESSION['successMessage'] = "Xóa dịch vụ thành công.";
            return redirect()->route('service');
        } else {
            $_SESSION['errorMessage'] = "Xóa dịch vụ thất bại.";
            return redirect()->route('service');
        }
    }

    public function typeRoom(){
        $data = DB::table('loaiphong')
            ->orderBy('MALOAIPHONG')
            ->get();
        
        return view('admin.loaiPhong',['data'=>$data]);
        
    }

    public function createTypeRoom(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $maloaiphong = $res->MALOAIPHONG;
        $tenloaiphong = $res->TENLOAIPHONG;
        $giangaythuong = $res->GIANGAYTHUONG;
        $giangayle = $res->GIANGAYLE;
        $loaigiuong = $res->LOAIGIUONG;
        $slgiuong = $res->SLGIUONG;
        $gioithieulp = $res->GIOITHIEULP;
        $khuyenmailp = $res->KHUYENMAILP;
        $image = $res->HINHLP;
        $imageName = $image->getClientOriginalName();

        $selectLP = DB::table('loaiphong')->where('MALOAIPHONG','=',$maloaiphong)->first();
        if ($selectLP) {
            $_SESSION['errorMessage'] = "Lỗi: Mã loại phòng đã tồn tại.";
            return redirect()->route('typeRoom');
        }

        $createDV = DB::table('loaiphong')
            ->insert([
                'MALOAIPHONG' => $maloaiphong,
                'TENLOAIPHONG' => $tenloaiphong,
                'GIANGAYTHUONG' => $giangaythuong,
                'GIANGAYLE' => $giangayle,
                'LOAIGIUONG' => $loaigiuong,
                'SLGIUONG' => $slgiuong,
                'GIOITHIEULP' => trim($gioithieulp),
                'KHUYENMAILP' => $khuyenmailp,
                'HINHLP' => $imageName
            ]);
        if ($createDV > 0) {
            //Storage::disk('local')->put('images/service', $image);
            $image->move('images/typeRoom',$imageName);
            $_SESSION['successMessage'] = "Thêm loại phòng thành công.";
            return redirect()->route('typeRoom');
        } else {
            $_SESSION['errorMessage'] = "Lỗi: Thêm loại phòng thất bại.";
            return redirect()->route('typeRoom');
        }
    }

    public function updateTypeRoom(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $maloaiphong = $res->MALOAIPHONG;
        $tenloaiphong = $res->TENLOAIPHONG;
        $giangaythuong = $res->GIANGAYTHUONG;
        $giangayle = $res->GIANGAYLE;
        $loaigiuong = $res->LOAIGIUONG;
        $slgiuong = $res->SLGIUONG;
        $gioithieulp = $res->GIOITHIEULP;
        $khuyenmailp = $res->KHUYENMAILP;
        $image = $res->HINHLP;
        $imageName = $image->getClientOriginalName();

        $updateLP = DB::table('loaiphong')
            ->where('MALOAIPHONG','=',$maloaiphong)
            ->update([
                'TENLOAIPHONG' => $tenloaiphong,
                'GIANGAYTHUONG' => $giangaythuong,
                'GIANGAYLE' => $giangayle,
                'LOAIGIUONG' => $loaigiuong,
                'SLGIUONG' => $slgiuong,
                'GIOITHIEULP' => trim($gioithieulp),
                'KHUYENMAILP' => $khuyenmailp,
                'HINHLP' => $imageName
            ]);
        if ($updateLP > 0) {
            $imagePath = 'public/images/typeRoom/'.$imageName;
            //kiểm tra ảnh đã có tồn tại hay chưa
            if(Storage::exists($imagePath)){
                $_SESSION['successMessage'] = "Cập nhật loại phòng thành công.";
                return redirect()->route('typeRoom');
            }else{
                $image->move('images/typeRoom',$imageName);
                $_SESSION['successMessage'] = "Cập nhật loại phòng thành công.";
                return redirect()->route('typeRoom');
            }
        } else {
            $_SESSION['errorMessage'] = "Lỗi: Cập nhật loại phòng thất bại.";
            return redirect()->route('typeRoom');
        }
    }

    public function deleteTypeRoom(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $id = $res->MALOAIPHONG;

        $deleteRoom = DB::table('loaiphong')
            ->where('MALOAIPHONG','=',$id)
            ->delete();

        if ($deleteRoom > 0) {
            $_SESSION['successMessage'] = "Xóa loại phòng thành công.";
            return redirect()->route('typeRoom');
        } else {
            $_SESSION['errorMessage'] = "Xóa loại phòng thất bại.";
            return redirect()->route('typeRoom');
        }
    }

    public function discount(){
        //SELECT * FROM khuyenmai order by MAKHUYENMAI
        $data = DB::table('khuyenmai')
            ->orderBy('MAKHUYENMAI')
            ->get();
        
        return view('admin.danhSachKM',['data'=>$data]);
        
    }

    public function createDiscount(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        
        $makm = $res->MAKHUYENMAI;
        $tenkm = $res->TENKHUYENMAI;
        $discount = $res->DISCOUNT;
        $trangthai = $res->TRANGTHAIKHUYENMAI;

        $selectLP = DB::table('khuyenmai')->where('MAKHUYENMAI','=',$makm)->first();
        if ($selectLP) {
            $_SESSION['errorMessage'] = "Lỗi: Mã khuyến mãi đã tồn tại.";
            return redirect()->route('Discount');
        }

        //INSERT INTO `khuyenmai` (`MAKHUYENMAI`, `TENKHUYENMAI`, `DISCOUNT`, `TRANGTHAIKHUYENMAI`) VALUES (?, ?, ?, ?)
        $createKM = DB::table('khuyenmai')
            ->insert([
                'MAKHUYENMAI' => $makm,
                'TENKHUYENMAI' => $tenkm,
                'DISCOUNT' => $discount,
                'TRANGTHAIKHUYENMAI' => intval($trangthai)
            ]);
        if ($createKM > 0) {
            $_SESSION['successMessage'] = "Thêm khuyến mãi thành công.";
            return redirect()->route('discount');
        } else {
            $_SESSION['errorMessage'] = "Lỗi: Thêm khuyến mãi thất bại.";
            return redirect()->route('discount');
        }
    }

    public function updateDiscount(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $makm = $res->MAKHUYENMAI;
        $tenkm = $res->TENKHUYENMAI;
        $discount = $res->DISCOUNT;
        $trangthai = $res->TRANGTHAIKHUYENMAI;

        $updateLP = DB::table('khuyenmai')
            ->where('MAKHUYENMAI','=',$makm)
            ->update([
                'TENKHUYENMAI' => $tenkm,
                'DISCOUNT' => $discount,
                'TRANGTHAIKHUYENMAI' => intval($trangthai)
            ]);
        if ($updateLP > 0) {
            $_SESSION['successMessage'] = "Cập nhật khuyến mãi thành công.";
            return redirect()->route('discount');
        } else {
            $_SESSION['errorMessage'] = "Lỗi: Cập nhật khuyến mãi thất bại.";
            return redirect()->route('discount');
        }
    }

    public function deleteDiscount(Request $res){
        if(!isset($_SESSION)){
            session_start();
        }

        $id = $res->MAKHUYENMAI;

        $deleteRoom = DB::table('khuyenmai')
            ->where('MAKHUYENMAI','=',$id)
            ->delete();

        if ($deleteRoom > 0) {
            $_SESSION['successMessage'] = "Xóa khuyến mãi thành công.";
            return redirect()->route('discount');
        } else {
            $_SESSION['errorMessage'] = "Xóa khuyến mãi thất bại.";
            return redirect()->route('discount');
        }
    }
}
