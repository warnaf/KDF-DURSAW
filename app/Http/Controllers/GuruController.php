<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Department;

class GuruController extends Controller
{
    public function index() {
        return view('guru.dataGuru', [
            'title' => 'Data Guru',
            'dataGuru' => Guru::all()
        ]);
    }

    public function create() {
        return view('guru.formGuru', [
            'title' => 'Form Guru',
            'departments' => Department::all()
            
        ]);
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'id' => 'required|max:6|unique:guru',
            'nama_guru' => 'required',
            'jenis_kelamin' => 'required',
            'department_id' => 'required',
            'jabatan' => 'required',
            'tanggal_masuk' => 'required'
        ]);

        Guru::create($validateData);
        return redirect('/guru')->with('success', 'New data has been added!');
    }

    public function edit(Guru $kelas, $id) {
        $data = $kelas->find($id);
        return view('kelas.editKelas')->with([
            'title' => 'Edit Kelas',
            'id' => $id,
            'jenjang' => $data->jenjang,
            'nama_kelas' => $data->nama_kelas,
            'jurusan' => $data->jurusan
        ]);
    }

    public function update(Request $request, Guru $kelas, $id) {
        $data = $kelas->find($id);
        $data->jenjang = $request->jenjang;
        $data->nama_kelas = $request->nama_kelas;
        $data->jurusan = $request->jurusan;
        $data->save();

        // if($request->$id != $kelas->$id) {
        //     $rules['id'] = 'required|max:6|unique:kelas';
        // }

        
        return redirect('/kelas')->with('success', 'New data has been update!');
    }

    public function destroy(Guru $kelas,$id) {
        $data = $kelas->find($id);
        $data->delete();
        // Kelas::destroy($kelas->id);
        return redirect('/kelas')->with('success', 'Data has been deleted!');
    }
}
