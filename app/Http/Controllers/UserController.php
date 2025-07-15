<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function login(Request $request)
    {
        $level = ['Director', 'Manager', 'Admin', 'User', 'Preuser'];
        // Perform your login validation logic here
        $username = $request->input('username');
        $password = $request->input('password');

        $user = DB::connection('mysql2')->table('users')->where('username', $username)->where('password', $password)->whereIn('users.level', $level)->first();
        // dd($user->level);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Username หรือ Password ไม่ถูกต้อง']);
        } elseif ($user->level == 'Preuser') {
            return response()->json(['status' => 'error', 'message' => 'กรุณาแจ้งหัวหน้าแผนกของคุณเพื่อทำการอนุมัติเข้าใช้งาน!']);
        }

        $department = DB::connection('mysql2')
            ->table('users')
            ->join('department', 'users.department', '=', 'department.did') // Corrected alias to 'department'
            ->where('users.username', $username)
            ->where('users.password', $password)
            ->first();

        if ($user && $department) {
            // Authentication successful, store the user's session
            $formattedName = ucfirst(strtolower($user->name));
            $SurName = ucfirst(strtolower($user->surname));
            $firstChar = strtoupper(substr($user->surname, 0, 1));
            $formattedSurname = $firstChar . '.';
            $request->session()->put('user', [
                'username' => $username,
                'empno' => $user->empno,
                'name' => $formattedName,
                'surname' => $SurName,
                '1surname' => $formattedSurname,
                'department' => $user->department,
                'level' => $user->level,
            ]);

            $request->session()->put('department', [
                'department_name' => $department->department_name,
            ]);

            DB::connection('mysql2')
                ->table('users')
                ->where('username', $username)
                ->where('password', $password)
                ->update(['last_login_at' => now()]);

            return response()->json(['status' => 'success', 'message' => 'You have been logged in successfully!']);
        }

        return response()->json(['status' => 'error', 'message' => 'Username or Password ไม่ถูกต้อง']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $username = $request->session()->get('user.username');
        $empno = $request->session()->get('user.empno');

        // dd($username);
        DB::connection('mysql2')
            ->table('users')
            ->where('username', $username)
            ->where('empno', $empno)
            ->update(['last_logout_at' => now()]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}
