<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Rules\Password;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create
                            {name? : The name of the user}
                            {email? : The email of the user}
                            {password? : The password of the user}
                            {password_confirmation? : Repeat password of the user}
                            {--verify : Whether the user should be manually verified}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create administrator user';

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
     * @return int
     */
    public function handle()
    {
        $verify = $this->option('verify');
        $this->info($verify ? null : Carbon::now());
        $name = $this->argument('name') ?: $this->ask('What is your name?');
        $email = $this->argument('email') ?: $this->ask('Email user as administrator?');
        $password = $this->argument('password') ?: $this->secret('Input password?');
        $passwordConfirmation = $this->argument('password_confirmation') ?: $this->secret('Confirm the password?');

        try {
            $inputs = ['email' => $email, 'password' => $password, 'password_confirmation' => $passwordConfirmation];
            Validator::make($inputs, [
                'email' => ['email', Rule::unique(User::class)],
                'password' => ['required', 'string', new Password, 'confirmed']
            ])->validate();
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $input => $error) {
                $this->error(ucwords($input) . ': ' . $error[0]);
            }
            return 0;
        }

        if ($this->confirm('Do you want to create user ' . $name . ' as Administrator?')) {
            $verify = $this->option('verify');
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => $verify ? null : Carbon::now(),
                'is_admin' => true,
            ]);
            if ($user instanceof MustVerifyEmail) {
                $user->sendEmailVerificationNotification();
            }
            $this->line('User ' . $name . ' successfully created as Administrator');
        } else {
            $this->info('Creating user cancelled');
        }

        return 0;
    }
}
