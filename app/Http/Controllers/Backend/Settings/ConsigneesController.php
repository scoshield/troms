<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Consignee;

class ConsigneesController extends Controller
{
    public function index()
    {
        $consignees = Consignee::latest()->paginate(10);

        return view("backend.settings.consignee.index", compact('consignees'));
    }

    public function create()
    {
        return view("backend.settings.consignee.create");
    }

    public function store()
    {
        request()->validate([
            'name' => 'required'
        ]);

        Consignee::updateOrCreate(['name' => request('name')]);

        return redirect()
            ->to(route("admin.settings.consignee.index"))
            ->with('flash_success', 'Consignee created successfully');
    }

    public function edit($id)
    {
        $consignee = Consignee::findOrFail($id);

        return view("backend.settings.consignee.edit", compact('consignee'));
    }

    public function update($id)
    {
        request()->validate([
            'name' => 'required'
        ]);

        $consignee = Consignee::findOrFail($id);

        $consignee->update(['name' => request('name')]);

        return redirect()
            ->to(route("admin.settings.consignee.index"))
            ->with('flash_success', 'Consignee updated successfully');
    }

    public function destroy($id)
    {
        Consignee::destroy(($id));

        return redirect()
            ->to(route("admin.settings.consignee.index"))
            ->with('flash_success', 'Consignee deleted successfully');
    }
}
