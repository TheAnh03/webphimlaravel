<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\AccountDeletedNotification;
use Illuminate\Support\Facades\Mail;

class DeleteUnverifiedUsers extends Command
{
    protected $signature = 'users:cleanup-unverified';
    protected $description = 'Xoá tài khoản chưa xác minh sau 15 ngày và gửi thông báo qua email';

    public function handle()
    {
        $usersToDelete = User::whereNull('email_verified_at')
            ->where('created_at', '<', now()->subDays(15))
            ->get();

        $deleted = 0;

        foreach ($usersToDelete as $user) {
            
            Mail::to($user->email)->send(new AccountDeletedNotification($user));

           
            $user->delete();
            $deleted++;
        }

        $this->info("Đã gửi email và xoá $deleted tài khoản chưa xác minh.");
    }
}
