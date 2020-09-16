<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    use AskValid;

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
        $email = $this->askValid(
            'What is your email address?',
            'email',
            ['required', 'email']
        );
        $password = $this->askValidSecret(
            'Please enter a password',
            'password',
            ['required', 'min:6', 'string']
        );
        $passwordConfirm = $this->secret('Please confirm the password');
        if ($password !== $passwordConfirm) {
            $this->output->error('Your passwords do not match.');
            exit(1);
        }
        $name = $this->askValid(
            'What is your name?',
            'name',
            ['required']
        );

        $user = User::create([
            'email' => $email,
            'name' => $name,
            'password' => Hash::make($password),
        ]);

        $this->output->success(sprintf('Created user %s with id %d', $user->email, $user->id));

        return 0;
    }
}
