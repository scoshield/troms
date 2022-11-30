<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Destination;

class DestinationsController extends Controller
{
    public function index()
    {
        $destinations = Destination::latest()->paginate(10);

        return view("backend.settings.destinations.index", compact('destinations'));
    }

    public function create()
    {
        return view("backend.settings.destinations.create");
    }

    public function store()
    {
        request()->validate([
            'name' => 'required'
        ]);

        Destination::updateOrCreate(['name' => request('name')]);

        return redirect()
            ->to(route("admin.settings.destinations.index"))
            ->with('flash_success', 'Destination created successfully');
    }

    public function edit($id)
    {
        $destination = Destination::findOrFail($id);

        return view("backend.settings.destinations.edit", compact('destination'));
    }

    public function update($id)
    {
        request()->validate([
            'name' => 'required'
        ]);

        $destination = Destination::findOrFail($id);

        $destination->update(['name' => request('name')]);

        return redirect()
            ->to(route("admin.settings.destinations.index"))
            ->with('flash_success', 'Destination updated successfully');
    }

    public function destroy($id)
    {
        Destination::destroy(($id));

        return redirect()
            ->to(route("admin.settings.destinations.index"))
            ->with('flash_success', 'Destination deleted successfully');
    }
}
