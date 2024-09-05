<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'khachhang';
    protected $primaryKey = 'MAKH';
    public $incrementing = false;
    protected $fillable = [
        'MAKH',
        'SDTKH',
        'CMNDKH',
        'HOTENKH',
        'LOAIKHACHHANG',
        'TAIKHOAN'
    ];
}
