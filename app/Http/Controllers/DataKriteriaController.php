<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataKriteria;
use Illuminate\Http\Request;

class DataKriteriaController extends Controller
{
    function index()
{
    $data = DataKriteria::all();
    return view('data_kriteria.index', compact('data'));
}

    function tambah(){
        return view('data_kriteria.tambah');
    }
    function edit($id){
        $data = DataKriteria::find($id);
        return view('data_kriteria.edit', ['data' => $data]); // Menggunakan 'data_karyawan.edit' dengan tanda kutip
    }    
    function hapus(Request $id){
        DataKriteria::where('id', $request->id)->delet();

        Session::flash('success', 'Berhasil Hapus Data');

        return redirect('/datakriteria');
    }
    // new
    function create(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|min:3',
            'bobot_kriteria' => 'required|numeric'
        ], [
            'nama_kriteria.required' => 'Nama Kriteria wajib diisi',
            'nama_kriteria.min' => 'Nama Kriteria minimal harus 3 karakter.',
            'bobot_kriteria.required' => 'Bobot Kriteria wajib diisi',
            'bobot_kriteria.numeric' => 'Bobot Kriteria harus berupa angka',
        ]);

        DataKriteria::insert([
            'nama_kriteria' => $request->nama_kriteria, // Mengubah 'name' menjadi 'nama_kriteria'
            'bobot_kriteria' => $request->bobot_kriteria, // Mengubah 'email' menjadi 'bobot_kriteria'
        ]);

        Session::flash('success', 'Data berhasil ditambahkan');

        return redirect('/datakriteria')->with('success', 'Berhasil Menambahkan Data');
    }
    function change(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|min:3',
            'bobot_kriteria' => 'required|numeric'
        ], [
            'nama_kriteria.required' => 'Nama Kriteria wajib diisi',
            'nama_kriteria.min' => 'Nama Kriteria minimal harus 3 karakter.',
            'bobot_kriteria.required' => 'Bobot Kriteria wajib diisi',
            'bobot_kriteria.numeric' => 'Bobot Kriteria harus berupa angka',
        ]);

        $datakriteria = DataKriteria::find($request->id);

        $datakrireria->nama_kriteria = $request->nama_kriteria;
        $datakriteria->bobot_kriteria= $request->bobot_kriteria;
        $datakriteria->save();

        Session::flash('success', 'Berhasil Mengubah Data');

        return redirect('/datakriteria');
    }
}
