<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('check-jwt');
    }

    //
    public function getNotification(){
        return response()->success(NotificationResource::collection(auth()->user()->notifications ?? []), 200);
    }

    //
    public function getUnreadNotification(){
        return response()->success(NotificationResource::collection(auth()->user()->unreadNotifications ?? []), 200);
    }

    public function markReadNotification($notifyId){
        auth()->user()->unreadNotifications->where('id', $notifyId)->markAsRead();
        return response()->success('Success', 200);
    }
}
