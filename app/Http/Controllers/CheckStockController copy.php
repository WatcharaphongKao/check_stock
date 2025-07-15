<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Models\FG;

class CheckStockController extends Controller
{
    //
    public function index(Request $request)
    {
        // dd($department);
        $qr_pallet = $request->input('qr_pallet'); // รับค่าตัวกรองจาก DataTable
        $fg = DB::table('fg');
        $fg->where('pallet', [$qr_pallet]);
        $fg->orderBy('box_no', 'ASC');
        return DataTables::query($fg)->addIndexColumn()->toJson();
    }

    public function edit($id)
    {
        $data = DB::table('fg')->select('pallet', DB::raw('COUNT(box_no) as `qr_total`'), DB::raw('COUNT(CASE WHEN checked = 1 THEN 1 END) as `qr_scan`'))->where('pallet', $id)->groupBy('pallet')->get();
        return response()->json($data);
    }

    public function checked(Request $request)
    {
        $username = $request->session()->get('user.username');
        $qr_box = $request->input('qr_box');
        $qr_pallet = $request->input('qr_pallet');
        // dd($qr_bin);
        $checked = FG::where('box_no', $qr_box)->where('pallet', $qr_pallet)->where('checked', 0)->first();
        if (!$checked) {
            return response()->json(['success' => false, 'message' => 'Box No ไม่มี หรือถูกยิงไปแล้ว']);
        }

        $checked->checked = 1;
        $checked->updated_by = $username;
        $checked->date_checked = now();
        $checked->updated_at = now();
        $checked->save();
        return response()->json(['success' => true, 'message' => 'response 200']);
    }
}
