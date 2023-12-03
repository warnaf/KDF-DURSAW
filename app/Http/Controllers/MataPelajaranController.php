<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    public function index() {
        return view('mataPelajaran.dataMatpel', [
            'title' => 'Data Mata Pelajaran',
            'dataMatpel' => MataPelajaran::all()
        ]);
    }

    public function create() {
        return view('mataPelajaran.formMatpel', [
            'title' => 'Form Mata Pelajaran'
        ]);
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'id' => 'required|max:6|unique:mata_pelajaran',
            'nama_mata_pelajara' => 'required',
            'is_penjuruan' => 'required',
        ]);

        MataPelajaran::create($validateData);
        return redirect('/matpel')->with('success', 'New data has been added!');
    }

    public function edit(MataPelajaran $mata_pelajara, $id) {
        $data = $mata_pelajara->find($id);
        return view('mataPelajaran.editMatpel')->with([
            'title' => 'Edit Mata Pelajaran',
            'id' => $id,
            'nama_mata_pelajara' => $data->nama_mata_pelajara,
            'is_penjuruan' => $data->is_penjuruan
        ]);
    }

    public function update(Request $request, MataPelajaran $mata_pelajara, $id) {
        $data = $mata_pelajara->find($id);
        $data->nama_mata_pelajara = $request->nama_mata_pelajara;
        $data->is_penjuruan = $request->is_penjuruan;
        $data->save();
        
        return redirect('/matpel')->with('success', 'New data has been update!');
    }

    public function destroy(MataPelajaran $mata_pelajara, $id) {
        $data = $mata_pelajara->find($id);
        $data->delete();
        return redirect('/matpel')->with('success', 'Data has been deleted!');
        
    }
}
