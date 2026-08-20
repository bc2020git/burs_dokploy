<?php

namespace App\Http\Controllers;

use App\Models\OtpSetting;
use Illuminate\Http\Request;

class OtpSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = OtpSetting::first() ?? new OtpSetting();
        return view('panel.otp-setting.index', compact('settings'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OtpSetting $otpSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OtpSetting $otpSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $settings = OtpSetting::first() ?? new OtpSetting();

        $data = [
            'otp_status' => $request->boolean('otp_status'),
            'crm_otp_status' => $request->boolean('crm_otp_status'),
            'portal_otp_status' => $request->boolean('portal_otp_status'),
            'admin_otp_status' => $request->boolean('admin_otp_status'),
        ];

        // Bildirim kanalları UI'da kapalı olabilir; bu durumda mevcut değerleri ezmeyelim.
        if ($request->has('sms_status')) {
            $data['sms_status'] = $request->boolean('sms_status');
        }
        if ($request->has('email_status')) {
            $data['email_status'] = $request->boolean('email_status');
        }

        $settings->fill($data);

        $settings->save();

        return redirect()->back()->with('success', 'Ayarlar başarıyla güncellendi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OtpSetting $otpSetting)
    {
        //
    }
}
