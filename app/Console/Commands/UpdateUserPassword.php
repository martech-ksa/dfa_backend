<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UpdateUserPassword extends Command
{
    // The name and signature of the console command.
    protected $signature = 'user:update-password {email} {password}';

    // The console command description.
    protected $description = 'Update the password for a user based on email.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Retrieve email and password arguments
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Attempt to find the user by email
        $user = User::where('email', $email)->first();

        // Check if the user exists
        if ($user) {
            // Hash and update the user's password
            $user->password = bcrypt($password);
            $user->save(); // Save the updated user record

            // Success message
            $this->info("Password updated successfully for $email.");
        } else {
            // Error message if user is not found
            $this->error("User with email $email not found.");
        }
    }
}