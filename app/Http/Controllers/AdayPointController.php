<?php

namespace App\Http\Controllers;

use App\Models\AdayPoint;
use Illuminate\Http\Request;

class AdayPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tc_no' => 'required|string',
            'soru' => 'required|string',
            'puan' => 'required|numeric|min:1',
            'cevap' => 'required|string'
        ]);

        // Mevcut kaydı kontrol et
        $point = AdayPoint::where('tc_no', $data['tc_no'])
                         ->where('soru', $data['soru'])
                         ->first();

        if ($point) {
            // Kayıt varsa güncelle
            $point->update([
                'puan' => $data['puan'],
                'cevap' => $data['cevap']
            ]);
        } else {
            // Kayıt yoksa yeni kayıt oluştur
            AdayPoint::create($data);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(AdayPoint $adayPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdayPoint $adayPoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdayPoint $adayPoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $adayPoint = AdayPoint::find($id);
        $adayPoint->delete();
        return redirect()->back()->with('success', 'Puan silindi');
    }
}
