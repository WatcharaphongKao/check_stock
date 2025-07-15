<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FG extends Model
{
    //
    public $timestamps = false;
    protected $table = 'FG';
    protected $fillable = [
        'id', // เพิ่ม 'id' ให้กับ fillable
        'month_stock', // ฟิลด์อื่นๆ ที่คุณต้องการอนุญาต
        'year_stock', // ฟิลด์อื่นๆ ที่คุณต้องการอนุญาต
        'pallet', // ฟิลด์อื่นๆ ที่คุณต้องการอนุญาต
        'box_no',
        'part',
        'lot',
        'description',
        'bin',
        'grade',
        'qty',
        'checked',
        'date',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
