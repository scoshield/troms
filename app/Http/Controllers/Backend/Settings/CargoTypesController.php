<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\CargoType;

class CargoTypesController extends Controller
{
    public function index()
    {
        $cargoTypes = CargoType::latest()->paginate(10);

        return view("backend.settings.cargo-types.index", compact('cargoTypes'));
    }

    public function create()
    {
        return view("backend.settings.cargo-types.create");
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
        ]);

        CargoType::updateOrCreate(['name' => request('name')]);

        return redirect()
            ->to(route("admin.settings.cargo-types.index"))
            ->with('flash_success', 'Cargo Type created successfully');
    }

    public function edit($id)
    {
        $cargoType = CargoType::findOrFail($id);

        return view("backend.settings.cargo-types.edit", compact('cargoType'));
    }

    public function update($id)
    {
        request()->validate([
            'name' => 'required',
        ]);

        $agent = CargoType::findOrFail($id);

        $agent->update(request()->all());

        return redirect()
            ->to(route("admin.settings.cargo-types.index"))
            ->with('flash_success', 'Cargo Type updated successfully');
    }

    public function destroy($id)
    {
        CargoType::destroy(($id));

        return redirect()
            ->to(route("admin.settings.cargo-types.index"))
            ->with('flash_success', 'Cargo Type deleted successfully');
    }
}
