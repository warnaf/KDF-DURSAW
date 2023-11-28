<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index() {
        return view('department.dataDepartment', [
            'title' => 'Data Department',
            'dataDepartment' => Department::all()
        ]);
    }

    public function create() {
        return view('department.formDepartment', [
            'title' => 'Form Department'
        ]);
    }

    public function store(Request $request) {
        $validateData = $request->validate([
            'id' => 'required|max:6|unique:departments',
            'nama_department' => 'required'
        ]);

        Department::create($validateData);
        return redirect('/department')->with('success', 'New data has been added!');
    }

    public function edit(Department $departments, $id) {
        $data = $departments->find($id);
        return view('department.editDepartment')->with([
            'title' => 'Edit Department',
            'id' => $id,
            'nama_department' => $data->nama_department
        ]);
    }

    public function update(Request $request, Department $department, $id) {
        $data = $department->find($id);
        $data->nama_department = $request->nama_department;
        $data->save();
        
        return redirect('/kelas')->with('success', 'New data has been update!');
    }

    public function destroy(Department $departments, $id) {
        $data = $departments->find($id);
        $data->delete();
        return redirect('/department')->with('success', 'Data has been deleted!');
        
    }
}
