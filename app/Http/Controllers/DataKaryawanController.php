<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataKaryawan;
use Illuminate\Http\Request;

class DataKaryawanController extends Controller
{
    function index()
    {
        $data = DataKaryawan::all();
        return view('data_karyawan.index',['data' => $data]);
    }
    function tambah(){
        return view('data_karyawan.tambah');
    }
    function edit($id){
        $data = DataKaryawan::find($id);
        return view('data_karyawan.edit', ['data' => $data]); // Menggunakan 'data_karyawan.edit' dengan tanda kutip
    }    
    function hapus(Request $id){
        DataKaryawan::where('id', $request->id)->delete();

        Session::flash('success', 'Berhasil Hapus Data');

        return redirect('/datakaryawan');
    }
    // new
    function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'jeniskelamin' => 'required|in:Laki-laki,Perempuan',
        ], [
            'name.required' => 'Name Wajib Di isi',
            'name.min' => 'Bidang name minimal harus 3 karakter.',
            'email.required' => 'Email Wajib Di isi',
            'email.email' => 'Format Email Invalid',
            'jeniskelamin.required' => 'Jenis Kelamin Wajib Di isi',
            'jeniskelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan',
        ]);

        DataKaryawan::insert([
            'name' => $request->name,
            'email' => $request->email,
            'jeniskelamin' => strtoupper($request->jeniskelamin),
        ]);

        Session::flash('success', 'Data berhasil ditambahkan');

        return redirect('/datakaryawan')->with('success', 'Berhasil Menambahkan Data');
    }
    function change(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'jeniskelamin' => 'required|in:Laki-laki,Perempuan',
        ], [
            'name.required' => 'Name Wajib Di isi',
            'name.min' => 'Bidang name minimal harus 3 karakter.',
            'email.required' => 'Email Wajib Di isi',
            'email.email' => 'Format Email Invalid',
            'jeniskelamin.required' => 'Jenis kelamin wajib diisi.',
            'jeniskelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
        ]);

        $datkaryawan = DataKaryawan::find($request->id);

        $datakaryawan->name = $request->name;
        $datakaryawan->email = $request->email;
        $datakaryawan->jeniskelamin = $request->jeniskelamin;
        $datakaryawan->save();

        Session::flash('success', 'Berhasil Mengubah Data');

        return redirect('/datakaryawan');
    }
}

