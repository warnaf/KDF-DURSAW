<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailMataPelajaran;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;

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
        $validateData = $request->validate([
            'id' => 'required|max:6|unique:detail_mata_pelajaran',
            'mata_pelajaran_ref' => 'required',
            'jumlah_jam' => 'required',
            'max_jam' => 'required',
            'semester' => 'required',
            'jenjang' => 'required'
        ]);

        DetailMataPelajaran::create($validateData);
        return redirect('/detailMatpel')->with('success', 'New data has been added!');
    }

    public function edit(DetailMataPelajaran $guru) {
        // $data = $guru->find($id);
        return view('guru.editGuru')->with([
            'title' => 'Edit Guru',
            // 'id' => $id,
            // 'jenis_kelamin' => $data->jenis_kelamin,
            // 'department_id' => $data->department_id,
            // 'jabatan' => $data->jabatan,
            // 'tahun_masuk' => $data->tahun_masuk,
            'guru' => $guru,
            'departments' => MataPelajaran::all()
        ]);
    }

    public function update(Request $request, DetailMataPelajaran $guru) {
        $data = DetailMataPelajaran::find($guru->id);
        // $data->id = $request->id;
        $data->nama_guru = $request->nama_guru;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->department_id = $request->department_id;
        $data->jabatan = $request->jabatan;
        $data->tanggal_masuk = $request->tanggal_masuk;
        $data->save();
        
        return redirect('/guru')->with('success', 'New data has been update!');
    }

    public function destroy(DetailMataPelajaran $guru) {
        // $data = $guru->find($id);
        // $data->delete();
        DetailMataPelajaran::destroy($guru->id);
        return redirect('/guru')->with('success', 'Data has been deleted!');
    }
}
