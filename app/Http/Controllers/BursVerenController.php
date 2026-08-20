<?php

namespace App\Http\Controllers;

use App\Models\Bursveren;
use Illuminate\Http\Request;

class BursVerenController extends Controller
{
    public function index()
    {
        session(['sidebar' => 30]);

        $bursverenler = Bursveren::all();
        return view('panel.bursveren.index', compact('bursverenler'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
        ]);

        $bursveren = Bursveren::create($request->all());

        return response()->json(['success' => true, 'bursveren' => $bursveren]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
        ]);

        $bursveren = Bursveren::findOrFail($id);
        $bursveren->update($request->all());

        return response()->json(['success' => true, 'bursveren' => $bursveren]);
    }

    public function destroy($id)
    {
        $bursveren = Bursveren::findOrFail($id);
        $bursveren->delete();

        return response()->json(['success' => true]);
    }
}