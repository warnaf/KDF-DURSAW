<?php

namespace App\Http\Controllers;
use App\Models\Kelas;

use Illuminate\Http\Request;
// use Dotenv\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

// use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    public function index() {
        return view('kelas.dataKelas', [
            'title' => 'Data Kelas',
            'dataKelas' => Kelas::orderBy('id', 'desc')->get()
        ]);
    }

    public function create() {
        return view('kelas.formKelas', [
            'title' => 'Form Kelas'
        ]);
    }

    public function store(Request $request) {
        // $validateData = $request->validate([
        //     'id' => 'required|max:6|unique:kelas',
        //     'jenjang' => 'required',
        //     'nama_kelas' => 'required',
        //     'jurusan' => 'required'
        // ]);

        $validateData = Validator::make($request->all(), [
            'id' => 'required|max:6|unique:kelas',
            'jenjang' => 'required',
            'nama_kelas' => 'required',
            'jurusan' => 'required'
        ], [
            'id.required' => 'Kolom kode kelas wajib diisi.',
            'jenjang.required' => 'Kolom jenjang wajib diisi.',
            'nama_kelas.required' => 'Kolom nama kelas wajib diisi.',
            'jurusan.required' => 'Kolom jurusan wajib diisi.',
            'id.unique' => 'Kode kelas sudah ada.',
            'id.max' => 'Kode kelas maksimal 6 karakter.'
        ]);

        // Jika validasi gagal, kembalikan respon dengan pesan kesalahan
        if ($validateData->fails()) {
            return redirect('/kelas/create')
                ->withErrors($validateData)
                ->withInput();
        }
        // Jika validasi berhasil, simpan data ke database
        Kelas::create([
            'id' => $request->input('id'),
            'jenjang' => $request->input('jenjang'),
            'nama_kelas' => $request->input('nama_kelas'),
            'jurusan' => $request->input('jurusan'),
        ]);

        // Kelas::create($validateData);
        return redirect('/kelas')->with('success', 'Data baru berhasil di tambahkan!');
    }

    // public function edit(Kelas $kelas, $id) {
    //     $data = $kelas->find($id);
    //     return view('kelas.editKelas')->with([
    //         'title' => 'Edit Kelas',
    //         'id' => $id,
    //         'jenjang' => $data->jenjang,
    //         'nama_kelas' => $data->nama_kelas,
    //         'jurusan' => $data->jurusan
    //     ]);
    // }
    public function edit($id) {
        $data = Kelas::find($id);
        // return view('kelas.editKelas', compact('data'))->with([
        //     'title' => 'Edit Kelas'
        // ]);

        if($data) {
            return view('kelas.editKelas', compact('data'))->with([
                'title' => 'Edit Kelas'
            ]);
        }else{
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    }

    // public function update(Request $request, Kelas $kelas, $id) {
    //     $data = $kelas->find($id);
    //     $data->jenjang = $request->jenjang;
    //     $data->nama_kelas = $request->nama_kelas;
    //     $data->jurusan = $request->jurusan;
    //     $data->save();

        
    //     return redirect('/kelas')->with('success', 'New data has been update!');
    // }
    public function update(Request $request, $id) {
        try {
            $request->validate([
                'id' => 'required|max:6|unique:kelas,id,' . $id, 
                'jenjang' => 'required',
                'nama_kelas' => 'required',
                'jurusan' => 'required',
            ], [
                'id.required' => 'Kolom kode kelas wajib diisi.',
                'jenjang.required' => 'Kolom jenjang wajib diisi.',
                'nama_kelas.required' => 'Kolom nama kelas wajib diisi.',
                'jurusan.required' => 'Kolom jurusan wajib diisi.'
            ]);


            // Jika validasi gagal, kembalikan respon dengan pesan kesalahan
            // if ($rules->fails()) {
            //     return redirect('/kelas/edit')
            //         ->withErrors($rules)
            //         ->withInput();
            // }

            // $validateData = $request->validate($rules);
            
            // Jika validasi berhasil, simpan data ke database
            $validateData = $request->all();
            $data = Kelas::find($id);
            $data->update($validateData);
            
            return redirect('/kelas')->with('success', 'Data berhasil di ubah!');
        } catch (ValidationException $e) {
            // Tangkap exception jika validasi gagal
            return redirect()->back()->withErrors($e->errors())->withInput();
        }  catch(\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data. Silakan coba lagi!');
        } 
    }

    public function destroy(Kelas $kelas,$id) {
        $data = $kelas->find($id);
        $data->delete();
        // Kelas::destroy($kelas->id);
        return redirect('/kelas')->with('success', 'Data berhasil di hapus!');
    }
}
