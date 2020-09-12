<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user for the application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->ask('Email address');
        $password = $this->secret('Password');
        $passwordConfirm = $this->secret('Confirm password');
        if ($password !== $passwordConfirm) {
            $this->output->error('Passwords do not match.');
            return 1;
        }
        $name = $this->ask('Name');
        
        if (empty($name)) {
            $this->output->error('Invalid username');
            return 2;
        }

        $user = User::create([
            'email' => $email,
            'name' => $name,
            'password' => Hash::make($password)
        ]);
        
        $this->output->success(sprintf('Created user %s with id %d', $user->email, $user->id));

        return 0;
    }
}
