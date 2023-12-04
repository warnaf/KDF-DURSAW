<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mengajar;
use App\Models\Guru;
use App\Models\DetailMataPelajaran;
// use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;

class MengajarController extends Controller
{
    public function index() {
        $data = DB::table('mengajar')
                ->join('detail_mata_pelajaran', 'detail_mata_pelajaran.id', '=', 'mengajar.id_detail_mata_pelajaran')
                ->join('mata_pelajaran', 'mata_pelajaran.id' ,'=', 'detail_mata_pelajaran.mata_pelajaran_ref')
                ->join('guru', 'guru.id' ,'=', 'mengajar.id_guru')
                ->select('mengajar.*', 'mata_pelajaran.nama_mata_pelajara', 'guru.nama_guru')
                ->orderBy('mengajar.id' , 'asc')
                ->get();
        return view('mengajar.dataMengajar', [
            'title' => 'Data Mengajar'
            // 'dataGuru' => compact($data)
        ])->with('dataMengajar', $data);
    }

    public function create() {
        return view('detailMataPelajaran.formDetailMatpel', [
            'title' => 'Form Detail Matpel',
            'mengajar' => Mengajar::all()
            
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

        Mengajar::create($validateData);
        return redirect('/detailMatpel')->with('success', 'New data has been added!');
    }

    public function edit(Mengajar $detail_mata_pelajaran, $id) {
        $data = $detail_mata_pelajaran->find($id);
        return view('detailMataPelajaran.editDetailMatpel')->with([
            'title' => 'Edit Detail Pelajaran',
            'id' => $id,
            'mata_pelajaran_ref' => $data->mata_pelajaran_ref,
            'jumlah_jam' => $data->jumlah_jam,
            'max_jam' => $data->max_jam,
            'semester' => $data->semester,
            'jenjang' => $data->jenjang,
            // 'detail_mata_pelajaran' => $detail_mata_pelajaran,
            'detail_pelajaran' => DetailMataPelajaran::all()
        ]);
    }

    public function update(Request $request, Mengajar $detail_mata_pelajaran, $id) {
        $data = $detail_mata_pelajaran->find($id);
        // $data->id = $request->id;
        $data->mata_pelajaran_ref = $request->mata_pelajaran_ref;
        $data->jumlah_jam = $request->jumlah_jam;
        $data->max_jam = $request->max_jam;
        $data->semester = $request->semester;
        $data->jenjang = $request->jenjang;
        $data->save();
        
        return redirect('/detailMatpel')->with('success', 'New data has been update!');
    }

    public function destroy(Mengajar $detail_mata_pelajaran, $id) {
        $data = $detail_mata_pelajaran->find($id);
        $data->delete();
        // DetailMataPelajaran::destroy($detail_mata_pelajaran->id);
        return redirect('/detailMatpel')->with('success', 'Data has been deleted!');
    }
}
