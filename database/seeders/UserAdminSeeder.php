<?php
namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = DB::table('users')->where('email', 'admin@warehouse.app')->get();
        if ($admin->isEmpty()) {
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'admin@warehouse.app',
                'password' => Hash::make('admin'),
                'is_admin' => true,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        }
    }
}
