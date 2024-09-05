<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

function locPhongTrong($ma_loai_phong)
{
    // SELECT COUNT(*) AS PHONGCONLAI
    //FROM LOAIPHONG, PHONG
    //WHERE PHONG.MALOAIPHONG = '$ma_loai_phong' AND PHONG.MAPHONG != 'P008' 
    //AND LOAIPHONG.MALOAIPHONG = PHONG.MALOAIPHONG AND TRANGTHAIPHONG = 0;   
    $data = DB::table('phong')
        ->join('loaiphong','loaiphong.MALOAIPHONG','=','phong.MALOAIPHONG')
        ->where([
            ['phong.MALOAIPHONG','=',$ma_loai_phong],
            ['phong.SOPHONG','!=','tm'],
            ['TRANGTHAIPHONG','=','0'],
        ])->count();
    return $data ? $data : 0;
}

function lay_SLPhong($ma_loai_phong)
{
    include("Connection.php");
    $sql = "SELECT LOAIPHONG.MALOAIPHONG, COUNT(*) AS SOLUONG
            FROM LOAIPHONG, PHONG
            WHERE LOAIPHONG.MALOAIPHONG = '$ma_loai_phong' AND  LOAIPHONG.MALOAIPHONG = PHONG.MALOAIPHONG AND PHONG.MAPHONG != 'P008'
            GROUP BY LOAIPHONG.MALOAIPHONG;";
    $sta = $pdo->prepare($sql);
    $sta->execute();
    $loai_phong = $sta->fetchAll(PDO::FETCH_OBJ);
    if (!empty($loai_phong)) {
        $sl = $loai_phong[0]->SOLUONG;
    } else {
        $sl = 0;
    }
    return $sl;
}

function loc_PhongTheoNgay($ma_loai_phong, $ngay_den, $ngay_di)
{
    include("Connection.php");
    $sql = "SELECT PHIEUDATPHONG.MALOAIPHONG, COUNT(*) AS SOLUONGPHONG
            FROM PHIEUDATPHONG
            WHERE ((PHIEUDATPHONG.NGAYNHANPHONG BETWEEN '$ngay_den' AND '$ngay_di') OR (PHIEUDATPHONG.NGAYTRAPHONG BETWEEN '$ngay_den' AND '$ngay_di')) AND PHIEUDATPHONG.MALOAIPHONG = '$ma_loai_phong'
            GROUP BY PHIEUDATPHONG.MALOAIPHONG;";
    $sta = $pdo->prepare($sql);
    $sta->execute();
    $loai_phong = $sta->fetchAll(PDO::FETCH_OBJ);
    if (!empty($loai_phong)) {
        $sl = $loai_phong[0]->SOLUONGPHONG;
    } else {
        $sl = 0;
    }
    return $sl;
}

function loc_ConLaiTheoNgay($ma_loai_phong, $ngay_den, $ngay_di)
{
    $sl_ConLai = lay_SLPhong($ma_loai_phong) - loc_PhongTheoNgay($ma_loai_phong, $ngay_den, $ngay_di);
    return $sl_ConLai;
}


function tinh_Tien($ma_loai_phong, $ngay_den, $ngay_di)
{
    //SELECT GIANGAYTHUONG FROM LOAIPHONG WHERE MALOAIPHONG = '$ma_loai_phong'
    $data = DB::table('loaiphong')
    ->where('MALOAIPHONG','=',$ma_loai_phong)
    ->first();
    $date1 = Carbon::parse($ngay_den);
    $date2 = Carbon::parse($ngay_di);
    $diffInDays = $date1->diffInDays($date2);
    $tong_Tien = $data->GIANGAYTHUONG * $diffInDays;
    $soTienVND = number_format($tong_Tien, 0, ',', '.') . ' VND';
    return $soTienVND;
}

function doi_Tien($so_tien)
{
    $soTienVND = number_format($so_tien, 0, ',', '.') . ' VND';
    return $soTienVND;
}

function loc_DanhGia($ma_pdp)
{
    //SELECT * FROM FEEDBACK WHERE MAPHIEUDATPHONG = '$ma_pdp';
    $data = DB::table('feedback')->where('MAPHIEUDATPHONG','=',$ma_pdp)->first();
    return $data ? true : false;
}

function loc_Phong_Da_Dat_Truoc($ma_loai_phong, $ngay_den, $ngay_di)
{
    include("Connection.php");
    $sql = "SELECT PHIEUDATPHONG.SOPHONG
            FROM PHIEUDATPHONG
            WHERE ((PHIEUDATPHONG.NGAYNHANPHONG BETWEEN '$ngay_den' AND '$ngay_di') OR (PHIEUDATPHONG.NGAYTRAPHONG BETWEEN '$ngay_den' AND '$ngay_di')) AND PHIEUDATPHONG.MALOAIPHONG = '$ma_loai_phong'
            GROUP BY PHIEUDATPHONG.SOPHONG;";
    $sta = $pdo->prepare($sql);
    $sta->execute();
    $loai_phong = $sta->fetchAll(PDO::FETCH_OBJ);
    if (!empty($loai_phong)) {
        $available_rooms = ['tm'];
        foreach ($loai_phong as $phong) {
            $available_rooms[] = $phong->SOPHONG;
        }
        return $available_rooms;
    } else {
        $available_rooms = ['tm'];
        return $available_rooms;
    }

}

function loc_PhongTrong($ma_loai_phong, $ngay_den, $ngay_di)
{
    $available_rooms = loc_Phong_Da_Dat_Truoc($ma_loai_phong, $ngay_den, $ngay_di);
    include("Connection.php");
    $sql = "SELECT SOPHONG FROM PHONG WHERE MALOAIPHONG = '$ma_loai_phong' AND SOPHONG NOT IN ('" . implode("','", $available_rooms) . "')";
    $sta = $pdo->prepare($sql);
    $sta->execute();
    $phong = $sta->fetchAll(PDO::FETCH_OBJ);
    if ($sta->rowCount() > 0) {
        $so_phong = [];
        foreach ($phong as $key) {
            $so_phong[] = $key->SOPHONG;
        }
        return $so_phong;
    }

}

function tinh_TienThanhToan($ma_loai_phong, $ngay_den, $ngay_di)
{
    include("Connection.php");
    $sql = "SELECT GIANGAYTHUONG FROM LOAIPHONG WHERE MALOAIPHONG = '$ma_loai_phong'";
    $sta = $pdo->prepare($sql);
    $sta->execute();
    $loai_phong = $sta->fetchAll(PDO::FETCH_OBJ);
    $date1 = new DateTime($ngay_den);
    $date2 = new DateTime($ngay_di);
    $interval = $date1->diff($date2);
    $diffDays = $interval->days;
    $tong_Tien = $loai_phong[0]->GIANGAYTHUONG * $diffDays;
    $soTienVND = number_format($tong_Tien, 0, ',', '.') . ' VND';

    return $tong_Tien;
}
function cocnuatien($ma_loai_phong, $ngay_den, $ngay_di)
{
    include("Connection.php");

    $sql = "SELECT GIANGAYTHUONG FROM LOAIPHONG WHERE MALOAIPHONG = '$ma_loai_phong'";
    $sta = $pdo->prepare($sql);
    $sta->execute();
    $loai_phong = $sta->fetchAll(PDO::FETCH_OBJ);

    $date1 = new DateTime($ngay_den);
    $date2 = new DateTime($ngay_di);
    $interval = $date1->diff($date2);
    $diffDays = $interval->days;
    $tong_Tien = $loai_phong[0]->GIANGAYTHUONG * $diffDays;

    // Apply a discount of 5%
    $phanTramGiamGia = 0.5;
    $giamGia = $tong_Tien * $phanTramGiamGia;
    $tong_Tien -= $giamGia;

    // Format the result
    $soTienVND = number_format($tong_Tien, 0, ',', '.') . ' VND';

    return $tong_Tien;
}
?>