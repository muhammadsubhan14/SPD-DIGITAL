<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaPegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = MaPegawai::orderBy('nama')->get();
        return view('admin.pegawai.index', compact('pegawai'));
    }

    public function search(Request $request)
    {
        $pegawai = MaPegawai::search($request->keyword)->get();
        return view('admin.pegawai.index', compact('pegawai'));
    }}
