<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use App\Imports\FGImport;
use DB;
use DataTables;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'month_import' => 'required',
            'year_import' => 'required',
        ]);
        $month = $request->input('month_import');
        $year = $request->input('year_import');
        // dd($year.'<hr>'.$month);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $message = 'Users imported successfully.';
            if ($file->isValid()) {
                $storedFile = $file->store('temp', 'local');
                $filePath = Storage::path($storedFile);

                // นับจำนวนแถวทั้งหมดในไฟล์
                $totalRows = Excel::toArray(null, $filePath)[0] ?? [];
                $rowCount = count($totalRows) - 1; // ลบ 1 เพื่อไม่รวม Header

                Excel::import(new FGImport(totalRows: $rowCount, month: $month, year: $year), $filePath);
                // เคลียร์แคชก่อนที่จะดึงข้อมูลใหม่
                Cache::store('file')->forget('import_progress');

                // ลบไฟล์หลังจากการนำเข้าเสร็จ
                Storage::delete($storedFile);

                return response()->json(['success' => true, 'message' => $message]);
            } else {
                return response()->json(['success' => false, 'message' => 'File upload failed or invalid file.']);
            }
        }
        return response()->json(['error' => 'File upload failed or invalid file.'], 400);
    }

    public function getImportProgress(Request $request)
    {
        $data = $request->input('data');
        // dd($data);
        if ($data == 'transfer') {
            $data_progress = 'transfer_progress';
        } else {
            $data_progress = 'import_progress';
        }

        // ดึงข้อมูลแคช (ถ้ามีข้อมูลหรือยังไม่หมดอายุ)
        $progress = Cache::store('file')->get($data_progress, null);

        // ถ้าไม่มีข้อมูลในแคชหรือแคชหมดอายุ
        if (!$progress) {
            // ถ้าไม่มีแคช ให้ตั้งค่าแคชใหม่ (ซึ่งจะเกิดเมื่อการนำเข้าเริ่มต้น)
            $progress = ['processed' => 0, 'total' => 1]; // หรือค่าพื้นฐานที่คุณต้องการ
        }

        // ส่งค่าผลลัพธ์เป็น JSON
        return response()->json($progress);
    }

    public function transfer_past(Request $request)
    {
        DB::beginTransaction();

        try {
            $month = $request->input('month');
            $year = $request->input('year');
            $Selectdata = $request->input('Selectdata');

            if (!$month && !$year && !$Selectdata) {
                return response()->json(['success' => false, 'message' => 'กรูณาเลือก เดือน ปี และข้อมูลก่อน.']);
            }
            if ($Selectdata == 'current') {
                $table1 = 'fg';
                $table2 = 'fg_past';
            } else {
                $table1 = 'fg_past';
                $table2 = 'fg';
            }

            // check checked = 0
            // $uncheckedData = DB::table($table1)->where('month_stock', $month)->where('year_stock', $year)->where('checked', '0')->get();
            // if ($uncheckedData->isNotEmpty()) {
            //     return response()->json(['success' => false, 'message' => 'ยังแสกน Box No. ไม่ครบ']);
            // }

            // ตรวจสอบข้อมูลที่ตรวจสอบแล้ว (checked = 1)
            // $table1Data = DB::table($table1)->where('month_stock', $month)->where('year_stock', $year)->where('checked', 1)->get();
            $table1Data = DB::table($table1)->where('month_stock', $month)->where('year_stock', $year)->get();
            // ตรวจสอบว่ามีข้อมูลใน Table 1 หรือไม่
            if ($table1Data->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No data to transfer_past in Table fg.']);
            }
            // เตรียมข้อมูลสำหรับ Insert หลายแถว
            $insertData = $table1Data
                ->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'pallet' => $data->pallet,
                        'box_no' => $data->box_no,
                        'part' => $data->part,
                        'lot' => $data->lot,
                        'description' => $data->description,
                        'bin' => $data->bin,
                        'grade' => $data->grade,
                        'qty' => $data->qty,
                        'checked' => $data->checked,
                        'month_stock' => $data->month_stock,
                        'year_stock' => $data->year_stock,
                        'date_checked' => $data->date_checked,
                        'created_by' => $data->created_by,
                        'updated_by' => $data->updated_by,
                        'created_at' => $data->created_at,
                        'updated_at' => $data->updated_at,
                    ];
                })
                ->toArray();

            // Insert ข้อมูลทั้งหมดไปยัง Table 2 ในชุดย่อย (batch)
            $chunks = array_chunk($insertData, 500); // แบ่งข้อมูลเป็นชุดละ 500 รายการ
            foreach ($chunks as $index => $chunk) {
                $insertResult = DB::table($table2)->insert($chunk);

                // Update progress in Cache
                Cache::store('file')->put(
                    'transfer_progress',
                    [
                        'processed' => ($index + 1) * count($chunk),
                        'total' => count($insertData),
                    ],
                    now()->addMinutes(10),
                );

                // Check if insert was successful
                if (!$insertResult) {
                    DB::rollback();
                    return response()->json(['success' => false, 'message' => 'Data insert failed.']);
                }
            }

            // ลบข้อมูลใน Table 1
            // DB::table('fg')->delete();
            DB::table($table1)
                ->where('month_stock', $month)
                ->where('year_stock', $year)
                // ->where('checked', 1) // ลบเฉพาะข้อมูลที่ถูกย้ายไป
                ->delete();

            // Commit การทำงาน
            DB::commit();

            Cache::store('file')->forget('transfer_progress');

            return response()->json(['success' => true, 'message' => 'Data transferred successfully and deleted from Table fg.']);
        } catch (\Exception $e) {
            // Rollback หากเกิดข้อผิดพลาด
            DB::rollback();

            Cache::store('file')->forget('transfer_progress');

            return response()->json(['success' => false, 'message' => 'Something went wrong: ' . $e->getMessage(), 'error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    public function index(Request $request)
    {
        $group_bin = $request->input('group_bin');
        $checked = $request->input('checked');
        $month = $request->input('month');
        $year = $request->input('year');
        $data = $request->input('data');
        $grade = $request->input('grade');

        if ($data == 'current') {
            $table = 'fg';
        } else {
            $table = 'fg_past';
        }

        // dd($checked);

        $fg = DB::table($table);
        if ($group_bin) {
            $fg->where('bin', [$group_bin]);
        }
        if ($grade) {
            $fg->where('grade', [$grade]);
        }
        if ($checked !== null) {
            $fg->where('checked', [$checked]);
        }
        if ($month) {
            $fg->where('month_stock', [$month]);
        }
        if ($year) {
            $fg->where('year_stock', [$year]);
        }
        $fg->orderBy('box_no', 'ASC');
        return DataTables::query($fg)->addIndexColumn()->toJson();
    }

    public function group_bin(Request $request)
    {
        // ดึงข้อมูลธนาคารที่มีสถานะเป็น 0
        $group_bin = DB::table('fg')->select('bin')->groupBy('bin')->get();

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if ($group_bin->isEmpty()) {
            return response()->json(['group_bin' => []]);
        }

        // คืนค่าข้อมูลธนาคารในรูปแบบ JSON
        return response()->json(['group_bin' => $group_bin]);
    }
}
