<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaiKhoan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'taikhoan';
    protected $primaryKey = 'TAIKHOAN';
    public $incrementing = false;
    protected $fillable = [
        'TAIKHOAN',
        'MATKHAU',
        'status',
        'MAPQ',
        'google_id'
    ];
}
