<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\User;

class UserNotificationsController extends Controller
{   
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        $user = auth()->id();
        $notification = auth()->user()->unreadNotifications;
        
        return $notification;
    }
    
    public function destroy(User $user, $notificationId) {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
    
}
