<?php

namespace App\Http\Controllers;

use App\Models\PermissionCategory;
use Illuminate\Http\Request;

class PermissionCategoryController extends Controller
{
    public function index()
    {
        $categories = PermissionCategory::all();
        return view('panel.settings.permissions.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:permission_categories'
        ]);

        $category = PermissionCategory::create($validated);

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = PermissionCategory::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:permission_categories,title,' . $id
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = PermissionCategory::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true]);
    }
} 