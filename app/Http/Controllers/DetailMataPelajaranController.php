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

    public function edit(DetailMataPelajaran $detail_mata_pelajaran, $id) {
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
            'mata_pelajaran' => MataPelajaran::all()
        ]);
    }

    public function update(Request $request, DetailMataPelajaran $detail_mata_pelajaran, $id) {
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

    public function destroy(DetailMataPelajaran $detail_mata_pelajaran, $id) {
        $data = $detail_mata_pelajaran->find($id);
        $data->delete();
        // DetailMataPelajaran::destroy($detail_mata_pelajaran->id);
        return redirect('/detailMatpel')->with('success', 'Data has been deleted!');
    }
}
