<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\fg;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;

use Illuminate\Support\Facades\Log;

class FGImport implements ToModel, WithHeadingRow, WithEvents
{
    private $totalRows = 0; // จำนวนแถวทั้งหมด
    private $processedRows = 0; // จำนวนแถวที่ประมวลผลแล้ว
    private $month;
    private $year;

    public function __construct($totalRows, $month, $year)
    {
        $this->totalRows = $totalRows; // รับจำนวนแถวทั้งหมดจากภายนอก
        $this->month = $month;
        $this->year = $year;
    }

    public function model(array $row)
    {
        $this->processedRows++; // เพิ่มจำนวนแถวที่ประมวลผล

        // อัปเดตสถานะการนำเข้าลงใน Cache ทุกๆ 1000 แถว

        if ($this->processedRows % 1000 === 0 || $this->processedRows === $this->totalRows) {
            Cache::store('file')->put(
                'import_progress',
                [
                    'processed' => $this->processedRows,
                    'total' => $this->totalRows,
                ],
                now()->addMinutes(10), // กำหนดเวลาให้ข้อมูลใน Cache หมดอายุ
            );
            // Log::info('Import Progress Updated', ['processed' => $this->processedRows, 'total' => $this->totalRows]);
        }

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
        $grade = $row['grade'] ?? null;
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
        $existingData = fg::Where('box_no', $box_no)->where('month_stock', $this->month)->where('year_stock', $this->year)->first();
        // dd($box_no);

        // ถ้ามีข้อมูลแล้ว ให้ข้ามแถวนี้
        if ($existingData) {
            return null; // ข้ามการบันทึกแถวนี้
        }
        // ส่งข้อมูลที่จะบันทึกไปยังฐานข้อมูล
        return new fg([
            // 'month_stock' => $Month,
            // 'year_stock' => $Year,
            'month_stock' => $this->month,
            'year_stock' => $this->year,
            'pallet' => $pallet,
            'box_no' => $box_no,
            'part' => $part,
            'lot' => $lot,
            'description' => $description,
            'bin' => $bin,
            'grade' => $grade,
            'qty' => $qty,
            'created_by' => $username,
            'created_at' => now(),
            // เพิ่มคอลัมน์อื่น ๆ ที่ต้องการ
        ]);
    }
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                // เคลียร์แคชก่อนเริ่มการนำเข้า
                // Cache::store('file')->forget('import_progress');
                Cache::put('import_progress', ['processed' => 0, 'total' => $this->totalRows], now()->addMinutes(10));
                // Log::debug('Before Import Progress', ['processed' => 0, 'total' => $this->totalRows]);
            },
            AfterImport::class => function (AfterImport $event) {
                // เคลียร์แคชหลังการนำเข้าจบ
                // Cache::store('file')->forget('import_progress');
                Cache::put('import_progress', ['processed' => $this->totalRows, 'total' => $this->totalRows], now()->addMinutes(10));
                // Log::debug('After Import Progress', ['processed' => $this->totalRows, 'total' => $this->totalRows]);
            },
        ];
    }
}
