<?php

namespace App\Http\Controllers;

use App\Notifications\WorkOrderValidated;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    /**
     * Show notification list.
     *
     * @param $request
     * @return View
     */
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->take(100)->get()->sort(function ($a, $b) {
            return [$a->created_at, $b->read_at] <=> [$b->read_at, $a->created_at];
        });

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Open notification and redirect to right place.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function show(Request $request, $id)
    {
        $notification = $request->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            if (!empty(data_get($notification->data, 'url'))) {
                redirect($notification->data['url']);
            }
            if ($notification->type == WorkOrderValidated::class && !empty(data_get($notification->data, 'id'))) {
                return redirect()->route('work-orders.show', ['work_order' => $notification->data['id']]);
            }
        }
        return redirect()->route('notifications.index');
    }

    /**
     * Mark all notification as read.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function readAll(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return redirect()->route('notifications.index')->with([
            'status' => 'success',
            'message' => 'All notification mark all as read'
        ]);
    }
}
