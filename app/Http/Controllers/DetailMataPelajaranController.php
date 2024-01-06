<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailMataPelajaran;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DetailMataPelajaranController extends Controller
{
    public function index() {
        $data = DB::table('detail_mata_pelajaran')
                ->join('mata_pelajaran', 'mata_pelajaran.id' ,'=', 'detail_mata_pelajaran.mata_pelajaran_ref')
                ->select('detail_mata_pelajaran.*', 'mata_pelajaran.nama_mata_pelajara')
                ->orderBy('detail_mata_pelajaran.id' , 'asc')
                ->get();
        return view('detailMataPelajaran.dataDetailMatpel', [
            'title' => 'Data Detail Mata Pelajaran'
            // 'dataGuru' => compact($data)
        ])->with('dataDetailMatpel', $data);
    }

    public function create() {
        return view('detailMataPelajaran.formDetailMatpel', [
            'title' => 'Form Detail Matpel',
            'detail_mata_pelajaran' => MataPelajaran::all()
            
        ]);
    }

    public function store(Request $request) {
        // $validateData = $request->validate([
        //     'id' => 'required|max:6|unique:detail_mata_pelajaran',
        //     'mata_pelajaran_ref' => 'required',
        //     'jumlah_jam' => 'required',
        //     'max_jam' => 'required',
        //     'semester' => 'required',
        //     'jenjang' => 'required'
        // ]);
        $validateData = Validator::make($request->all(), [
            'id' => 'required|max:6|unique:detail_mata_pelajaran',
            'mata_pelajaran_ref' => 'required',
            'jumlah_jam' => 'required',
            'max_jam' => 'required',
            'semester' => 'required',
            'jenjang' => 'required'
        ], [
            'id.required' => 'Kolom kode detail matpel wajib diisi.',
            'mata_pelajaran_ref.required' => 'Kolom matpel wajib diisi.',
            'jumlah_jam.required' => 'Kolom jumlah jam wajib diisi.',
            'max_jam.required' => 'Kolom maks jam wajib diisi.',
            'semester.required' => 'Kolom semester wajib diisi.',
            'jenjang.required' => 'Kolom jenjang wajib diisi.',
            'id.unique' => 'Kode detail matpel sudah ada.',
            'id.max' => 'Kode detail matpel maksimal 6 karakter.'
        ]);

         // Jika validasi gagal, kembalikan respon dengan pesan kesalahan
         if ($validateData->fails()) {
            return redirect('/detailMatpel/create')
                ->withErrors($validateData)
                ->withInput();
        }
        // Jika validasi berhasil, simpan data ke database
        DetailMataPelajaran::create([
            'id' => $request->input('id'),
            'mata_pelajaran_ref' => $request->input('mata_pelajaran_ref'),
            'jumlah_jam' => $request->input('jumlah_jam'),
            'max_jam' => $request->input('max_jam'),
            'semester' => $request->input('semester'),
            'jenjang' => $request->input('jenjang'),
        ]);

        // DetailMataPelajaran::create($validateData);
        return redirect('/detailMatpel')->with('success', 'Data baru berhasil di tambahkan!');
    }

    public function edit($id) {
        // $data = $detail_mata_pelajaran->find($id);
        // return view('detailMataPelajaran.editDetailMatpel')->with([
        //     'title' => 'Edit Detail Pelajaran',
        //     'id' => $id,
        //     'mata_pelajaran_ref' => $data->mata_pelajaran_ref,
        //     'jumlah_jam' => $data->jumlah_jam,
        //     'max_jam' => $data->max_jam,
        //     'semester' => $data->semester,
        //     'jenjang' => $data->jenjang,
        //     // 'detail_mata_pelajaran' => $detail_mata_pelajaran,
        //     'mata_pelajaran' => MataPelajaran::all()
        // ]);
        $data = DetailMataPelajaran::find($id);
        if($data) {
             return view('detailMataPelajaran.editDetailMatpel')->with([
                'title' => 'Edit Detail Pelajaran',
                'detail_mata_pelajaran' => $data,
                'mata_pelajaran' => MataPelajaran::all()
            ]);
        }else{
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    }

    // public function update(Request $request, DetailMataPelajaran $detail_mata_pelajaran, $id) {
    //     $data = $detail_mata_pelajaran->find($id);
    //     // $data->id = $request->id;
    //     $data->mata_pelajaran_ref = $request->mata_pelajaran_ref;
    //     $data->jumlah_jam = $request->jumlah_jam;
    //     $data->max_jam = $request->max_jam;
    //     $data->semester = $request->semester;
    //     $data->jenjang = $request->jenjang;
    //     $data->save();
        
    //     return redirect('/detailMatpel')->with('success', 'New data has been update!');
    // }
    public function update(Request $request, $id) {
        try {
            $request->validate([
            'id' => 'required|max:6|unique:detail_mata_pelajaran,id,' . $id,
            'mata_pelajaran_ref' => 'required',
            'jumlah_jam' => 'required',
            'max_jam' => 'required',
            'semester' => 'required',
            'jenjang' => 'required'
        ], [
            'id.required' => 'Kolom kode detail matpel wajib diisi.',
            'mata_pelajaran_ref.required' => 'Kolom matpel wajib diisi.',
            'jumlah_jam.required' => 'Kolom jumlah jam wajib diisi.',
            'max_jam.required' => 'Kolom maks jam wajib diisi.',
            'semester.required' => 'Kolom semester wajib diisi.',
            'jenjang.required' => 'Kolom jenjang wajib diisi.',
            ]);
            
            // Jika validasi berhasil, simpan data ke database
            $validateData = $request->all();
            $data = DetailMataPelajaran::find($id);
            $data->update($validateData);
            
            return redirect('/detailMatpel')->with('success', 'Data berhasil di ubah!');
        } catch (ValidationException $e) {
            // Tangkap exception jika validasi gagal
            return redirect()->back()->withErrors($e->errors())->withInput();
        }  catch(\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data. Silakan coba lagi!');
        } 
    }

    public function destroy(DetailMataPelajaran $detail_mata_pelajaran, $id) {
        $data = $detail_mata_pelajaran->find($id);
        $data->delete();
        // DetailMataPelajaran::destroy($detail_mata_pelajaran->id);
        return redirect('/detailMatpel')->with('success', 'Data berhasil di hapus!');
    }
}
