<?php

namespace App\Http\Controllers;

use App\Models\InterviewGroup;
use App\Models\NewInterview;
use App\Models\Notification;
use App\Models\UserNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Bildirimler listesi
     */
    public function index()
    {
        \Carbon\Carbon::setLocale('tr');
        $userEmail = Auth::user()->email;
        
        $notifications = UserNotification::with('notification')
            ->where('user_email', $userEmail)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('panel.notifications.index', compact('notifications'));
    }

    /**
     * Bildirimi okundu olarak işaretle
     */
    public function markAsRead($id)
    {
        $notification = UserNotification::where('user_email', Auth::user()->email)
            ->where('id', $id)
            ->firstOrFail();

        $notification->update(['is_checked' => '1']);

        return response()->json(['success' => true]);
    }

    /**
     * Bildirimi sil (Sadece UserNotification kaydını siler)
     */
    public function destroy($id)
    {
        $notification = UserNotification::where('user_email', Auth::user()->email)
            ->where('id', $id)
            ->firstOrFail();

        $notification->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Mülakat atanan grubuna bildirim gönder
     */
    public function sendInterviewNotification(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:new_interviews,id'
        ]);

        $interview = NewInterview::with('aday')->findOrFail($request->id);
        
        if (!$interview->interview_person) {
            return response()->json(['success' => false, 'message' => 'Bu mülakata henüz bir grup/kişi atanmamış.'], 400);
        }

        // Grubu bul
        $group = InterviewGroup::find($interview->interview_person);
        if (!$group || !$group->members) {
             return response()->json(['success' => false, 'message' => 'Atanan grup bilgisi bulunamadı veya üye yok.'], 400);
        }

        // Ana bildirim metnini oluştur
        $title = 'Yeni Mülakat Ataması';
        $text = $interview->aday->name . ' ' . $interview->aday->surname . ' isimli adayın mülakat süreci size atanmıştır. ' . 
                'Mülakat Tarihi: ' . $interview->interview_date . ' ' . $interview->interview_time;

        $notification = Notification::create([
            'title' => $title,
            'text' => $text,
            'email' => Auth::user()->email, // Gönderen
            'is_checked' => '0'
        ]);

        // Grup üyelerine dağıt
        $members = is_array($group->members) ? $group->members : json_decode($group->members, true);
        
        foreach ($members as $userId) {
            $user = User::find($userId);
            if ($user && $user->email) {
                UserNotification::create([
                    'message_id' => $notification->id,
                    'user_email' => $user->email,
                    'is_checked' => '0'
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Bildirim başarıyla gönderildi.']);
    }
}
