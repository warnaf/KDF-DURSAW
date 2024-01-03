<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mengajar;
use App\Models\Guru;
use App\Models\DetailMataPelajaran;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;
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
        $validateData = $request->validate([
            'id' => 'required|max:6|unique:mengajar',
            'id_detail_mata_pelajaran' => 'required',
            'id_guru' => 'required'
        ]);

        Mengajar::create($validateData);
        return redirect('/mengajar')->with('success', 'New data has been added!');
    }

    public function edit(Mengajar $mengajar) {
        // $data = $mengajar->find($id);
        $detail = DB::table('detail_mata_pelajaran')
                        ->leftJoin('mata_pelajaran', 'mata_pelajaran.id' ,'=', 'detail_mata_pelajaran.mata_pelajaran_ref')
                        ->select('detail_mata_pelajaran.id', 'mata_pelajaran.nama_mata_pelajara','detail_mata_pelajaran.jenjang')
                        ->get();
        return view('mengajar.editMengajar')->with([
            'title' => 'Edit Mengajar',
            // 'id' => $data->id,
            'mengajar' => $mengajar,
            'guru' => Guru::all(),
            'detail_pelajaran' => $detail
        ]);
    }

    public function update(Request $request, Mengajar $mengajar) {
        $data = Mengajar::find($mengajar->id);
        // $data->id = $request->id;
        $data->id_detail_mata_pelajaran = $request->id_detail_mata_pelajaran;
        $data->id_guru = $request->id_guru;
        $data->save();
        
        return redirect('/mengajar')->with('success', 'New data has been update!');
    }

    public function destroy(Mengajar $mengajar) {
        // $data = $mengajar->find($id);
        // $data->delete();
        Mengajar::destroy($mengajar->id);
        return redirect('/mengajar')->with('success', 'Data has been deleted!');
    }
}
