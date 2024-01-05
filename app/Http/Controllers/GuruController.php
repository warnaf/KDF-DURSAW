<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GuruController extends Controller
{
    public function index() {
        $data = DB::table('guru')
                ->join('departments', 'departments.id' ,'=', 'guru.department_id')
                ->select('guru.*', 'departments.nama_department')
                ->orderBy('guru.id' , 'asc')
                ->get();
        return view('guru.dataGuru', [
            'title' => 'Data Guru'
            // 'dataGuru' => compact($data)
        ])->with('dataGuru', $data);
    }

    public function create() {
        return view('guru.formGuru', [
            'title' => 'Form Guru',
            'departments' => Department::all()
            
        ]);
    }

    public function store(Request $request) {
        $validateData = Validator::make($request->all(), [
            'id' => 'required|max:6|unique:guru',
            'nama_guru' => 'required',
            'jenis_kelamin' => 'required',
            'department_id' => 'required',
            'jabatan' => 'required',
            'tanggal_masuk' => 'required'
        ], [
            'id.required' => 'Kolom kode guru wajib diisi.',
            'nama_guru.required' => 'Kolom nama guru wajib diisi.',
            'jenis_kelamin.required' => 'Kolom jenis kelamin wajib diisi.',
            'department_id.required' => 'Kolom department wajib diisi.',
            'jabatan.required' => 'Kolom jabatan wajib diisi.',
            'tanggal_masuk.required' => 'Kolom tanggal wajib diisi.',
            'id.unique' => 'Kode Guru sudah ada.',
            'id.max' => 'Kode Guru maksimal 6 karakter.'
        ]);

        // Jika validasi gagal, kembalikan respon dengan pesan kesalahan
        if ($validateData->fails()) {
            return redirect('/guru/create')
                ->withErrors($validateData)
                ->withInput();
        }
        // Jika validasi berhasil, simpan data ke database
        Guru::create([
            'id' => $request->input('id'),
            'nama_guru' => $request->input('nama_guru'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'department_id' => $request->input('department_id'),
            'jabatan' => $request->input('jabatan'),
            'tanggal_masuk' => $request->input('tanggal_masuk'),
        ]);

        // Guru::create($validateData);
        return redirect('/guru')->with('success', 'Data baru berhasil di tambahkan!');
    }

    public function edit($id) {
        // $data = $guru->find($id);
        $data = Guru::find($id);
        if($data) {
            return view('guru.editGuru')->with([
                'title' => 'Edit Guru',
                // 'id' => $id,
                // 'jenis_kelamin' => $data->jenis_kelamin,
                // 'department_id' => $data->department_id,
                // 'jabatan' => $data->jabatan,
                // 'tahun_masuk' => $data->tahun_masuk,
                'guru' => $data,
                'departments' => Department::all()
            ]);
        }else{
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    }

    // public function update(Request $request, Guru $guru) {
    //     $data = Guru::find($guru->id);
    //     // $data->id = $request->id;
    //     $data->nama_guru = $request->nama_guru;
    //     $data->jenis_kelamin = $request->jenis_kelamin;
    //     $data->department_id = $request->department_id;
    //     $data->jabatan = $request->jabatan;
    //     $data->tanggal_masuk = $request->tanggal_masuk;
    //     $data->save();
        
    //     return redirect('/guru')->with('success', 'New data has been update!');
    // }

    public function update(Request $request, $id) {
        try {
            $request->validate([
            'id' => 'required|max:6|unique:guru,id,' . $id,
            'nama_guru' => 'required',
            'jenis_kelamin' => 'required',
            'department_id' => 'required',
            'jabatan' => 'required',
            'tanggal_masuk' => 'required'
        ], [
            'id.required' => 'Kolom kode guru wajib diisi.',
            'nama_guru.required' => 'Kolom nama guru wajib diisi.',
            'jenis_kelamin.required' => 'Kolom jenis kelamin wajib diisi.',
            'department_id.required' => 'Kolom department wajib diisi.',
            'jabatan.required' => 'Kolom jabatan wajib diisi.',
            'tanggal_masuk.required' => 'Kolom tanggal wajib diisi.'
            ]);
            
            // Jika validasi berhasil, simpan data ke database
            $validateData = $request->all();
            $data = Guru::find($id);
            $data->update($validateData);
            
            return redirect('/guru')->with('success', 'Data berhasil di ubah!');
        } catch (ValidationException $e) {
            // Tangkap exception jika validasi gagal
            return redirect()->back()->withErrors($e->errors())->withInput();
        }  catch(\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data. Silakan coba lagi!');
        } 
    }

    public function destroy(Guru $guru) {
        // $data = $guru->find($id);
        // $data->delete();
        Guru::destroy($guru->id);
        return redirect('/guru')->with('success', 'Data berhasil di hapus!');
    }
}
