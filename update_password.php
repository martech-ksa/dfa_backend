<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UpdateUserPassword extends Command
{
    protected $signature = 'user:update-password {email} {password}';
    protected $description = 'Update user password';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->password = bcrypt($password);
            $user->save();
            $this->info("Password updated successfully for $email.");
        } else {
            $this->error("User with email $email not found.");
        }
    }
}