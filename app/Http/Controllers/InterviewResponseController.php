<?php

namespace App\Http\Controllers;

use App\Models\InterviewTimeline;
use App\Models\NewInterview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InterviewResponseController extends Controller
{
    public const PARTICIPATION_OPTIONS = [
        'Katılacağım',
        'Başka bir tarihte ve/veya saatte katılmak istiyorum',
        'Katılmayacağım',
    ];

    public function show(string $uuid): View
    {
        $interview = NewInterview::where('uuid', $uuid)->firstOrFail();

        $alreadyAnswered = is_string($interview->aday_katilim_durumu) && trim($interview->aday_katilim_durumu) !== '';

        return view('interview-response.form', [
            'uuid' => $uuid,
            'interview' => $interview,
            'options' => self::PARTICIPATION_OPTIONS,
            'alreadyAnswered' => $alreadyAnswered,
        ]);
    }

    public function store(Request $request, string $uuid): RedirectResponse
    {
        $interview = NewInterview::where('uuid', $uuid)->firstOrFail();

        if (is_string($interview->aday_katilim_durumu) && trim($interview->aday_katilim_durumu) !== '') {
            return redirect()
                ->route('interview.response.show', ['uuid' => $uuid])
                ->with('info', 'Katılım durumunuz daha önce belirlenmiş.');
        }

        $validated = $request->validate([
            'aday_katilim_durumu' => 'required|in:'.implode(',', self::PARTICIPATION_OPTIONS),
        ]);

        $interview->aday_katilim_durumu = $validated['aday_katilim_durumu'];
        $interview->aday_katiliim_mazereti = null;
        $interview->save();

        InterviewTimeline::create([
            'interview_id' => $interview->id,
            'title' => 'Aday Katılım Durumu Güncellendi',
            'text' => 'Aday katılım durumunu e-posta bağlantısı üzerinden bildirdi: '.$validated['aday_katilim_durumu'],
            'topTitle' => 'Mülakat Süreci',
        ]);

        return redirect()
            ->route('interview.response.show', ['uuid' => $uuid])
            ->with('success', 'Katılım durumunuz kaydedildi. Teşekkürler.');
    }
}

