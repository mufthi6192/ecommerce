<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\Notification\NotificationInterface;

class NotificationController extends Controller
{
    private NotificationInterface $notification;

    public function __construct
    (
        NotificationInterface $notification
    ){
        $this->notification = $notification;
    }

    public function allNotification(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->notification->allData();
        return apiResponseFormatter($response);
    }
}
