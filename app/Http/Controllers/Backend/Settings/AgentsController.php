<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Agent;

class AgentsController extends Controller
{
    public function index()
    {
        $agents = Agent::latest()->paginate(10);

        return view("backend.settings.agents.index", compact('agents'));
    }

    public function create()
    {
        return view("backend.settings.agents.create");
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

        Agent::updateOrCreate(['email' => request('email')], [
            'name' => request('name'),
            'address' => request('address'),
            'po_box' => request('po_box'),
            'country' => request('country'),
            'town' => request('town'),
            'tel' => request('mobile')
        ]);

        return redirect()
            ->to(route("admin.settings.agents.index"))
            ->with('flash_success', 'Agent created successfully');
    }

    public function edit($id)
    {
        $agent = Agent::findOrFail($id);

        return view("backend.settings.agents.edit", compact('agent'));
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

        $agent = Agent::findOrFail($id);

        $agent->update([
            'name' => request('name'),
            'address' => request('address'),
            'po_box' => request('po_box'),
            'country' => request('country'),
            'town' => request('town'),
            'tel' => request('mobile')
        ]);

        return redirect()
            ->to(route("admin.settings.agents.index"))
            ->with('flash_success', 'agent updated successfully');
    }

    public function destroy($id)
    {
        Agent::destroy(($id));

        return redirect()
            ->to(route("admin.settings.agents.index"))
            ->with('flash_success', 'agent deleted successfully');
    }
}
