<?php

namespace App\Http\Controllers;
use App\Models\Kelas;

use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index() {
        return view('kelas.dataKelas', [
            'title' => 'Data Kelas',
            'dataKelas' => Kelas::all()
        ]);
    }

    public function create() {
        return view('kelas.formKelas', [
            'title' => 'Form Kelas'
        ]);
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'id' => 'required|max:6|unique:kelas',
            'jenjang' => 'required',
            'nama_kelas' => 'required',
            'jurusan' => 'required'
        ]);

        Kelas::create($validateData);
        return redirect('/kelas')->with('success', 'New data has been added!');
    }

    public function edit(Kelas $kelas, $id) {
        $data = $kelas->find($id);
        return view('kelas.editKelas')->with([
            'title' => 'Edit Kelas',
            'id' => $id,
            'jenjang' => $data->jenjang,
            'nama_kelas' => $data->nama_kelas,
            'jurusan' => $data->jurusan
        ]);
    }

    public function update(Request $request, Kelas $kelas, $id) {
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

    public function destroy(Kelas $kelas,$id) {
        $data = $kelas->find($id);
        $data->delete();
        // Kelas::destroy($kelas->id);
        return redirect('/kelas')->with('success', 'Data has been deleted!');
    }
}
