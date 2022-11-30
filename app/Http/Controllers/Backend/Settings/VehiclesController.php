<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\Vehicle;

class VehiclesController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(10);

        return view("backend.settings.vehicles.index", compact('vehicles'));
    }

    public function create()
    {
        $carriers = Carrier::latest()->get(); // TODO: make this a searchable autocomplete

        return view("backend.settings.vehicles.create", compact('carriers'));
    }

    public function store()
    {
        request()->validate([
            'number' => 'required',
            'carrier_id' => 'required',
            'trailer' => 'required'
        ]);

        Vehicle::updateOrCreate(['number' => request('number')], [
            'carrier_id' => request('carrier_id'),
            'trailer' => request('trailer'),
        ]);

        return redirect()
            ->to(route("admin.settings.vehicles.index"))
            ->with('flash_success', 'Vehicle created successfully');
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $carriers = Carrier::latest()->get(); // TODO: make this a searchable autocomplete

        return view("backend.settings.vehicles.edit", compact('vehicle', 'carriers'));
    }

    public function update($id)
    {
        request()->validate([
            'number' => 'required',
            'carrier_id' => 'required',
            'trailer' => 'required'
        ]);

        $agent = Vehicle::findOrFail($id);

        $agent->update([
            'number' => request('number'),
            'carrier_id' => request('carrier_id'),
            'trailer' => request('trailer'),
        ]);

        return redirect()
            ->to(route("admin.settings.vehicles.index"))
            ->with('flash_success', 'Vehicle updated successfully');
    }

    public function destroy($id)
    {
        Vehicle::destroy(($id));

        return redirect()
            ->to(route("admin.settings.vehicles.index"))
            ->with('flash_success', 'Vehicle deleted successfully');
    }
}
