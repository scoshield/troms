<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Shipper;

class ShippersController extends Controller
{
    public function index()
    {
        $shippers = Shipper::latest()->paginate(10);

        return view("backend.settings.shippers.index", compact('shippers'));
    }

    public function create()
    {
        return view("backend.settings.shippers.create");
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'country' => 'required',
            'town' => 'required',
        ]);

        Shipper::updateOrCreate(['email' => request('email')], [
            'name' => request('name'),
            'address' => request('address'),
            'po_box' => request('po_box'),
            'country' => request('country'),
            'town' => request('town'),
            'tel' => request('mobile')
        ]);

        return redirect()
            ->to(route("admin.settings.shippers.index"))
            ->with('flash_success', 'Shipper created successfully');
    }

    public function edit($id)
    {
        $shipper = Shipper::findOrFail($id);

        return view("backend.settings.shippers.edit", compact('shipper'));
    }

    public function update($id)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'country' => 'required',
            'town' => 'required',
        ]);

        $shipper = Shipper::findOrFail($id);

        $shipper->update([
            'name' => request('name'),
            'address' => request('address'),
            'po_box' => request('po_box'),
            'country' => request('country'),
            'town' => request('town'),
            'tel' => request('mobile')
        ]);

        return redirect()
            ->to(route("admin.settings.shippers.index"))
            ->with('flash_success', 'Shipper updated successfully');
    }

    public function destroy($id)
    {
        Shipper::destroy(($id));

        return redirect()
            ->to(route("admin.settings.shippers.index"))
            ->with('flash_success', 'Shipper deleted successfully');
    }
}
