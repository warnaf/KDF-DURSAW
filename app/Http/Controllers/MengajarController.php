<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mengajar;
use App\Models\Guru;
use App\Models\DetailMataPelajaran;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use League\CommonMark\Extension\Mention\Mention;

class MengajarController extends Controller
{
    public function index() {
        $data = DB::table('mengajar')
                ->join('detail_mata_pelajaran', 'detail_mata_pelajaran.id', '=', 'mengajar.id_detail_mata_pelajaran')
                ->join('mata_pelajaran', 'mata_pelajaran.id' ,'=', 'detail_mata_pelajaran.mata_pelajaran_ref')
                ->join('guru', 'guru.id' ,'=', 'mengajar.id_guru')
                ->select('mengajar.*', 'mata_pelajaran.nama_mata_pelajara','detail_mata_pelajaran.jenjang', 'guru.nama_guru')
                ->orderBy('mengajar.id' , 'desc')
                ->get();
        return view('mengajar.dataMengajar', [
            'title' => 'Data Mengajar'
            // 'dataGuru' => compact($data)
        ])->with('dataMengajar', $data);
    }

    public function create() {
        $detail_pelajaran = DB::table('detail_mata_pelajaran')
                        ->leftJoin('mata_pelajaran', 'mata_pelajaran.id' ,'=', 'detail_mata_pelajaran.mata_pelajaran_ref')
                        ->select('detail_mata_pelajaran.id','detail_mata_pelajaran.jenjang', 'mata_pelajaran.nama_mata_pelajara')
                        ->get();
        return view('mengajar.formMengajar', [
            'title' => 'Form Mengajar',
            'pelajaran' => $detail_pelajaran,
            'guru' => Guru::all()
            
        ]);
    }

    public function store(Request $request) {
        $validateData = Validator::make($request->all(), [
            'id' => 'required|max:6|unique:mengajar',
            'id_detail_mata_pelajaran' => 'required',
            'id_guru' => 'required'
        ], [
            'id.required' => 'Kolom kode mengajar wajib diisi.',
            'id_detail_mata_pelajaran.required' => 'Kolom detail pelajaran wajib diisi.',
            'id_guru.required' => 'Kolom guru wajib diisi.',
            'id.unique' => 'Kode mengajar sudah ada.',
            'id.max' => 'Kode mengajar maksimal 6 karakter.'
        ]);

        // Jika validasi gagal, kembalikan respon dengan pesan kesalahan
        if ($validateData->fails()) {
            return redirect('/mengajar/create')
                ->withErrors($validateData)
                ->withInput();
        }
        // Jika validasi berhasil, simpan data ke database
        Mengajar::create([
            'id' => $request->input('id'),
            'id_detail_mata_pelajaran' => $request->input('id_detail_mata_pelajaran'),
            'id_guru' => $request->input('id_guru')
        ]);
        return redirect('/mengajar')->with('success', 'Data baru berhasil di tambahkan!');
    }

    public function edit($id) {
        $data = Mengajar::find($id);
        $detail = DB::table('detail_mata_pelajaran')
                        ->leftJoin('mata_pelajaran', 'mata_pelajaran.id' ,'=', 'detail_mata_pelajaran.mata_pelajaran_ref')
                        ->select('detail_mata_pelajaran.id', 'mata_pelajaran.nama_mata_pelajara','detail_mata_pelajaran.jenjang')
                        ->get();
        if($data) {
            return view('mengajar.editMengajar')->with([
                'title' => 'Edit Mengajar',
                'mengajar' => $data,
                'guru' => Guru::all(),
                'detail_pelajaran' => $detail
            ]);
        }else{
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    }

    // public function update(Request $request, Mengajar $mengajar) {
    //     $data = Mengajar::find($mengajar->id);
    //     // $data->id = $request->id;
    //     $data->id_detail_mata_pelajaran = $request->id_detail_mata_pelajaran;
    //     $data->id_guru = $request->id_guru;
    //     $data->save();
        
    //     return redirect('/mengajar')->with('success', 'New data has been update!');
    // }

    public function update(Request $request, $id) {
        try {
            $request->validate([
            'id' => 'required|max:6|unique:mengajar,id,' . $id,
            'id_detail_mata_pelajaran' => 'required',
            'id_guru' => 'required'
        ], [
            'id.required' => 'Kolom kode mengajar wajib diisi.',
            'id_detail_mata_pelajaran.required' => 'Kolom detail pelajaran wajib diisi.',
            'id_guru.required' => 'Kolom guru wajib diisi.'
        ]);
            
            // Jika validasi berhasil, simpan data ke database
            $validateData = $request->all();
            $data = Mengajar::find($id);
            $data->update($validateData);
            
            return redirect('/mengajar')->with('success', 'Data berhasil di ubah!');
        } catch (ValidationException $e) {
            // Tangkap exception jika validasi gagal
            return redirect()->back()->withErrors($e->errors())->withInput();
        }  catch(\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data. Silakan coba lagi!');
        } 
    } 

    public function destroy(Mengajar $mengajar) {
        // $data = $mengajar->find($id);
        // $data->delete();
        Mengajar::destroy($mengajar->id);
        return redirect('/mengajar')->with('success', 'Data berhasil di hapus!');
    }
}
