<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->paginate(10);

        return view("backend.settings.departments.index", compact('departments'));
    }

    public function create()
    {
        return view("backend.settings.departments.create");
    }

    public function store()
    {
        request()->validate([
            'name' => 'required|string',
            'code' => 'required|string',
            'com' => 'required|string',
            'branch'=> 'required|string'
        ]);

        Department::updateOrCreate(['code' => request('code')], [
            'name' => request('name'),
            'code' => request('code'),
            'com'=> request('com'),
            'branch'=> request('branch')
        ]);

        return redirect()
            ->to(route("admin.settings.departments.index"))
            ->with('flash_success', 'Department created successfully');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view("backend.settings.departments.edit", compact('department'));
    }

    public function update($id)
    {
        request()->validate([
            'name' => 'required',
            'code' => 'required',
            'com' => 'required|string',
            'branch'=> 'required|string'
        ]);

        $department = Department::findOrFail($id);

        $department->update([
            'name' => request('name'),
            'code' => request('code'),
            'com'=> request('com'),
            'branch'=> request('branch')
        ]);

        return redirect()
            ->to(route("admin.settings.departments.index"))
            ->with('flash_success', 'Department updated successfully');
    }

    public function destroy($id)
    {
        Department::destroy(($id));

        return redirect()
            ->to(route("admin.settings.departments.index"))
            ->with('flash_success', 'Vehicle deleted successfully');
    }
}
