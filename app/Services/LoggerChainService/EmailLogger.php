<?php

namespace App\Services\LoggerChainService;

use App\Models\User;
use App\Notifications\ServerErrorNotification;

class EmailLogger extends AbstractLogger
{
    public function handle(\Throwable $e)
    {
        $code = $e->getCode();
        if (!$code || $code >= 500) {
            $adminEmail = env('ADMIN_EMAIL');
            $admin = $adminEmail ? User::where('email', $adminEmail)->first() : '';
            $admin?->notify(new ServerErrorNotification($e));
        }
        parent::handle($e);
    }

}
