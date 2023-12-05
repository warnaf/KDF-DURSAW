<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

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

    public function edit(Guru $guru) {
        // $data = $guru->find($id);
        return view('guru.editGuru')->with([
            'title' => 'Edit Guru',
            // 'id' => $id,
            // 'jenis_kelamin' => $data->jenis_kelamin,
            // 'department_id' => $data->department_id,
            // 'jabatan' => $data->jabatan,
            // 'tahun_masuk' => $data->tahun_masuk,
            'guru' => $guru,
            'departments' => Department::all()
        ]);
    }

    public function update(Request $request, Guru $guru) {
        $data = Guru::find($guru->id);
        // $data->id = $request->id;
        $data->nama_guru = $request->nama_guru;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->department_id = $request->department_id;
        $data->jabatan = $request->jabatan;
        $data->tanggal_masuk = $request->tanggal_masuk;
        $data->save();
        
        return redirect('/guru')->with('success', 'New data has been update!');
    }

    public function destroy(Guru $guru) {
        // $data = $guru->find($id);
        // $data->delete();
        Guru::destroy($guru->id);
        return redirect('/guru')->with('success', 'Data has been deleted!');
    }
}
