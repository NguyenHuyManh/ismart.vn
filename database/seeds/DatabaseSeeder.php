<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        // DB::table('admins')->insert([
        //     'name' => 'Cẩm Tú',
        //     'email' => 'hcamtu2001@gmail.com',
        //     'phone' => '0374469999',
        //     'password' => Hash::make('huymanh98'),
        // ]);

        DB::table('products')->where('id', 1)->increment('pro_pay');
    }
}
