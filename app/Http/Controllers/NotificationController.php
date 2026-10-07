<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = Notification::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    public function markAsRead(
        Request $request,
        Notification $notification
    ): RedirectResponse {

        abort_unless(
            $notification->user_id === $request->user()->id,
            403
        );

        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        if ($notification->ba_rampung_id) {
            return redirect()->route(
                'ba-rampung.show',
                $notification->ba_rampung_id
            );
        }

        return back();
    }

    public function markAllAsRead(
        Request $request
    ): RedirectResponse {

        Notification::query()
            ->where('user_id', $request->user()->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return back();
    }
}