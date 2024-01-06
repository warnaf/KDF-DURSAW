<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DepartmentController extends Controller
{
    public function index() {
        return view('department.dataDepartment', [
            'title' => 'Data Department',
            'dataDepartment' => Department::orderBy('id', 'desc')->get()
        ]);
    }

    public function create() {
        return view('department.formDepartment', [
            'title' => 'Form Department'
        ]);
    }

    public function store(Request $request) {
        // $validateData = $request->validate([
        //     'id' => 'required|max:6|unique:departments',
        //     'nama_department' => 'required'
        // ]);

        $validateData = Validator::make($request->all(), [
            'id' => 'required|max:6|unique:departments',
            'nama_department' => 'required'
        ], [
            'id.required' => 'Kolom kode department wajib diisi.',
            'nama_department.required' => 'Kolom nama department wajib diisi.',
            'id.unique' => 'Kode department sudah ada.',
            'id.max' => 'Kode department maksimal 6 karakter.'
        ]);

        // Jika validasi gagal, kembalikan respon dengan pesan kesalahan
        if ($validateData->fails()) {
            return redirect('/department/create')
                ->withErrors($validateData)
                ->withInput();
        }
        // Jika validasi berhasil, simpan data ke database
        Department::create([
            'id' => $request->input('id'),
            'nama_department' => $request->input('nama_department'),
        ]);

        // Department::create($validateData);
        return redirect('/department')->with('success', 'Data baru berhasil di tambahkan!');
    }

    // public function edit(Department $departments, $id) {
    //     $data = $departments->find($id);
    //     return view('department.editDepartment')->with([
    //         'title' => 'Edit Department',
    //         'id' => $id,
    //         'nama_department' => $data->nama_department
    //     ]);
    // }

    public function edit($id) {
        $data = Department::find($id);

        if($data) {
            return view('department.editDepartment', compact('data'))->with([
                'title' => 'Edit Department'
            ]);
        }else{
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }
    }

    // public function update(Request $request, Department $departments, $id) {
    //     $data = $departments->find($id);
    //     $data->nama_department = $request->nama_department;
    //     $data->save();
        
    //     return redirect('/department')->with('success', 'New data has been update!');
    // }

    public function update(Request $request, $id) {
        try {
            $request->validate([
                'id' => 'required|max:6|unique:departments,id,' . $id, 
                'nama_department' => 'required'
            ], [
                'id.required' => 'Kolom kode department wajib diisi.',
                'nama_department.required' => 'Kolom nama department wajib diisi.'
            ]);

            // Jika validasi berhasil, simpan data ke database
            $validateData = $request->all();
            $data = Department::find($id);
            $data->update($validateData);
            
            return redirect('/department')->with('success', 'Data berhasil di ubah!');
        } catch (ValidationException $e) {
            // Tangkap exception jika validasi gagal
            return redirect()->back()->withErrors($e->errors())->withInput();
        }  catch(\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data. Silakan coba lagi!');
        } 
    }

    public function destroy(Department $departments, $id) {
        $data = $departments->find($id);
        $data->delete();
        return redirect('/department')->with('success', 'Data berhasil di hapus!');
        
    }
}
