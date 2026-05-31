<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class GraduationController extends Controller
{
    public function index() {
        return view('kelulusan.index');
    }

    public function check(Request $request) {
        $nis = $request->input('nis');
        // Query ke DB atau array dummy
        $students = [
            '12001' => ['name' => 'Ahmad Fauzi', 'class' => 'XII IPA 1', 'gpa' => 3.85, 'status' => 'LULUS'],
            '12005' => ['name' => 'Rizky Pratama', 'class' => 'XII IPA 2', 'gpa' => 2.95, 'status' => 'TIDAK LULUS'],
        ];
        return response()->json($students[$nis] ?? ['error' => 'NIS tidak ditemukan']);
    }
}