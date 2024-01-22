<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MataPelajaranController extends Controller
{
    public function index() {
        return view('mataPelajaran.dataMatpel', [
            'title' => 'Data Mata Pelajaran',
            'dataMatpel' => MataPelajaran::orderBy('id', 'desc')->get()
        ]);
    }

    public function create() {
        return view('mataPelajaran.formMatpel', [
            'title' => 'Form Mata Pelajaran'
        ]);
    }

    public function store(Request $request) {
        // $validateData = $request->validate([
        //     'id' => 'required|max:6|unique:mata_pelajaran',
        //     'nama_mata_pelajara' => 'required',
        //     'is_penjuruan' => 'required',
        // ]);
        $validateData = Validator::make($request->all(), [
            'id' => 'required|max:6|unique:mata_pelajaran',
            'nama_mata_pelajara' => 'required',
            'is_penjuruan' => 'required',
        ], [
            'id.required' => 'Kolom Kode matpel wajib diisi.',
            'nama_mata_pelajara.required' => 'Kolom Nama matpel wajib diisi.',
            'is_penjuruan.required' => 'Kolom Penjuruan matpel wajib diisi.',
            'id.unique' => 'Kode matpel sudah ada.',
            'id.max' => 'Kode matpel maksimal 6 karakter.'
        ]);

         // Jika validasi gagal, kembalikan respon dengan pesan kesalahan
         if ($validateData->fails()) {
            return redirect('/matpel/create')
                ->withErrors($validateData)
                ->withInput();
        }
        // Jika validasi berhasil, simpan data ke database
        MataPelajaran::create([
            'id' => $request->input('id'),
            'nama_mata_pelajara' => $request->input('nama_mata_pelajara'),
            'is_penjuruan' => $request->input('is_penjuruan')
        ]);

        // MataPelajaran::create($validateData);
        return redirect('/matpel')->with('success', 'Data baru berhasil di tambahkan!');
    }

    // public function edit(MataPelajaran $mata_pelajara, $id) {
    //     $data = $mata_pelajara->find($id);
    //     return view('mataPelajaran.editMatpel')->with([
    //         'title' => 'Edit Mata Pelajaran',
    //         'id' => $id,
    //         'nama_mata_pelajara' => $data->nama_mata_pelajara,
    //         'is_penjuruan' => $data->is_penjuruan
    //     ]);
    // }

    public function edit($id) {
        $data = MataPelajaran::find($id);
        
        if($data) {
            return view('mataPelajaran.editMatpel', compact('data'))->with([
                'title' => 'Edit Mata Pelajaran'
            ]);
        }else{
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    }

    // public function update(Request $request, MataPelajaran $mata_pelajara, $id) {
    //     $data = $mata_pelajara->find($id);
    //     $data->nama_mata_pelajara = $request->nama_mata_pelajara;
    //     $data->is_penjuruan = $request->is_penjuruan;
    //     $data->save();
        
    //     return redirect('/matpel')->with('success', 'New data has been update!');
    // }

    public function update(Request $request, $id) {
        try {
            $request->validate([
                'id' => 'required|max:6|unique:mata_pelajaran,id,' . $id, 
                'nama_mata_pelajara' => 'required',
                'is_penjuruan' => 'required'
            ], [
                'id.required' => 'Kolom Kode matpel wajib diisi.',
                'nama_mata_pelajara.required' => 'Kolom Nama matpel wajib diisi.',
                'is_penjuruan.required' => 'Kolom Penjuruan matpel wajib diisi.'
            ]);
            
            // Jika validasi berhasil, simpan data ke database
            $validateData = $request->all();
            $data = MataPelajaran::find($id);
            $data->update($validateData);
            
            return redirect('/matpel')->with('success', 'Data berhasil di ubah!');
        } catch (ValidationException $e) {
            // Tangkap exception jika validasi gagal
            return redirect()->back()->withErrors($e->errors())->withInput();
        }  catch(\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data. Silakan coba lagi!');
        } 
    }

    public function destroy(MataPelajaran $mata_pelajara, $id) {
        $data = $mata_pelajara->find($id);
        $data->delete();
        return redirect('/matpel')->with('success', 'Data berhasil di hapus!');
        
    }
}
