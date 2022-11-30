<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Models\ApprovalLevel;
use App\Models\Department;

class ApprovalLevelController extends Controller
{
    public function index()
    {
        $users = User::all();
        $weights = ApprovalLevel::APPROVAL_WEIGHTS;
        $departments = Department::all();
        $approval_levels = ApprovalLevel::orderBy("weight", "desc")->paginate(20);

        return
            view("backend.auth.approval-level.index", compact('users', 'weights', 'departments', 'approval_levels'));
    }

    public function store()
    {
        ApprovalLevel::updateOrcreate(["user_id" => request("user_id")], [
            "user_id" => request("user_id"),
            "departments" => request('departments'),
            "weight" => request("weight"),
            "can_mark_as_approved" => request('can_mark_as_approved') == "on"
        ]);

        return redirect()
            ->to(route("admin.approval-levels.index"))
            ->with('flash_success', 'Approval Level added successfully');
    }

    public function destroy($id)
    {
        ApprovalLevel::destroy($id);

        return redirect()
            ->to(route("admin.approval-levels.index"))
            ->with('flash_success', 'Approval Level removed successfully');
    }
}
