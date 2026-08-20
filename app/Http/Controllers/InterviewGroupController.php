<?php

namespace App\Http\Controllers;

use App\Models\InterviewGroup;
use App\Models\User;
use Illuminate\Http\Request;

class InterviewGroupController extends Controller
{
    public function index()
    {
        session(['sidebar' => 18]);
        $groups = InterviewGroup::all();
        return view('panel.tanimlar.interview-groups.index', compact('groups'));
    }

    public function create()
    {
        $users = User::all();
        return view('panel.tanimlar.interview-groups.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'members' => 'required|array',
            'members.*' => 'exists:users,id'
        ]);

        $result = InterviewGroup::create([
            'name' => $request->name,
            'members' => $request->members
        ]);
        return redirect()->route('mulakat-grup.index')
            ->with('success', 'Mülakat grubu başarıyla oluşturuldu');
    }

    public function edit(InterviewGroup $group)
    {
        $users = User::all();
        return view('panel.tanimlar.interview-groups.edit', compact('group', 'users'));
    }

    public function update(Request $request, InterviewGroup $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'members' => 'required|array',
            'members.*' => 'exists:users,id'
        ]);

        $group->update([
            'name' => $request->name,
            'members' => $request->members
        ]);

        return redirect()->route('mulakat-grup.index')
            ->with('success', 'Mülakat grubu başarıyla güncellendi');
    }

    public function destroy(InterviewGroup $group)
    {
        $group->delete();
        return redirect()->route('mulakat-grup.index')
            ->with('success', 'Mülakat grubu başarıyla silindi');
    }
}
