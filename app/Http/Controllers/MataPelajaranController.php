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

    public function edit(MataPelajaran $departments, $id) {
        $data = $departments->find($id);
        return view('department.editDepartment')->with([
            'title' => 'Edit Department',
            'id' => $id,
            'nama_department' => $data->nama_department
        ]);
    }

    public function update(Request $request, MataPelajaran $departments, $id) {
        $data = $departments->find($id);
        $data->nama_department = $request->nama_department;
        $data->save();
        
        return redirect('/department')->with('success', 'New data has been update!');
    }

    public function destroy(MataPelajaran $mata_pelajara, $id) {
        $data = $mata_pelajara->find($id);
        $data->delete();
        return redirect('/matpel')->with('success', 'Data has been deleted!');
        
    }
}
