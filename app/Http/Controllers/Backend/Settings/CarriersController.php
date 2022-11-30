<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Carrier;

class CarriersController extends Controller
{
    public function index()
    {
        $carriers = Carrier::latest()->paginate(10);

        return view("backend.settings.carriers.index", compact('carriers'));
    }

    public function create()
    {
        return view("backend.settings.carriers.create");
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'country' => 'required',
            'town' => 'required',
            'kra_pin' => 'required'
        ]);

        Carrier::updateOrCreate(['email' => request('email')], [
            'name' => request('name'),
            'address' => request('address'),
            'po_box' => request('po_box'),
            'country' => request('country'),
            'town' => request('town'),
            'tel' => request('mobile'),
            'kra_pin' => request('kra_pin')
        ]);

        return redirect()
            ->to(route("admin.settings.carriers.index"))
            ->with('flash_success', 'Carrier created successfully');
    }

    public function edit($id)
    {
        $carrier = Carrier::findOrFail($id);

        return view("backend.settings.carriers.edit", compact('carrier'));
    }

    public function update($id)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'country' => 'required',
            'town' => 'required',
            'kra_pin' => 'required'
        ]);

        $carrier = Carrier::findOrFail($id);

        $carrier->update([
            'name' => request('name'),
            'address' => request('address'),
            'po_box' => request('po_box'),
            'country' => request('country'),
            'town' => request('town'),
            'tel' => request('mobile'),
            'kra_pin' => request('kra_pin')
        ]);

        return redirect()
            ->to(route("admin.settings.carriers.index"))
            ->with('flash_success', 'Carrier updated successfully');
    }

    public function destroy($id)
    {
        Carrier::destroy(($id));

        return redirect()
            ->to(route("admin.settings.carriers.index"))
            ->with('flash_success', 'Carrier deleted successfully');
    }
}
