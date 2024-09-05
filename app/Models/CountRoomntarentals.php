<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountRoomntarentals extends Model
{
    use HasFactory;
    protected $table = 'solanthuephong';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'SOPHONG',
        'SOLAN',
    ];
}
