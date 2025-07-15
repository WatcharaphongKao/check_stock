<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\fg;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;

class FGImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $username = Session::get('user.username');
        $empno = Session::get('user.empno');
        // dd($empno);

        $Month = $row['month'] ?? null;
        $Year = $row['year'] ?? null;
        $pallet = $row['pallet'] ?? null;
        $box_no = $row['box_no'] ?? null;
        $part = $row['part'] ?? null;
        $lot = $row['lot'] ?? null;
        $description = $row['description'] ?? null;
        $bin = $row['bin'] ?? null;
        $qty = $row['qty'] ?? null;
        // dd($Year);

        // dd($description);
        if (empty($pallet)) {
            // หาก 'pallet' ไม่มีข้อมูล ให้ข้ามแถวนี้
            return null; // ข้ามแถวนี้โดยไม่ทำการบันทึกลงฐานข้อมูล
        }
        // ถ้า 'box_no' ไม่มีข้อมูล ให้กำหนดให้เป็น null
        if (empty($box_no)) {
            $box_no = null;
        }

        // ตรวจสอบว่ามีข้อมูลนี้ในฐานข้อมูลหรือไม่ (ห้ามซ้ำ)
        $existingData = fg::Where('box_no', $box_no)->first();
        // dd($box_no);

        // ถ้ามีข้อมูลแล้ว ให้ข้ามแถวนี้
        if ($existingData) {
            return null; // ข้ามการบันทึกแถวนี้
        }
        // ส่งข้อมูลที่จะบันทึกไปยังฐานข้อมูล
        return new fg([
            'month_stock' => $Month,
            'year_stock' => $Year,
            'pallet' => $pallet,
            'box_no' => $box_no,
            'part' => $part,
            'lot' => $lot,
            'description' => $description,
            'bin' => $bin,
            'qty' => $qty,
            'created_by' => $username,
            'created_at' => now(),
            // เพิ่มคอลัมน์อื่น ๆ ที่ต้องการ
        ]);
    }
}
