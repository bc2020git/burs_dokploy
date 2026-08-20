<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionCategory;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session(['sidebar' => 21]);
        $permissions = Permission::all();
        return view('panel.settings.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PermissionCategory::all();
        return view('panel.settings.permissions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions',
            'description' => 'nullable',
        ]);

        Permission::create($request->all());

        return redirect()->route('permissions.index')->with('success', 'İzin başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $categories = PermissionCategory::all();
        $result = [
            'permission' => $permission,
            'categories' => $categories
        ];
        return view('panel.settings.permissions.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'description' => 'nullable',
        ]);

        $permission->update($request->all());

        return redirect()->route('permissions.index')->with('success', 'İzin başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'İzin başarıyla silindi.');
    }
}
