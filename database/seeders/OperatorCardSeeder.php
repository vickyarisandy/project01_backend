<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OperatorCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->insert([
           [
            'name' => 'Telkomsel',
            'status' => 'inactive',
            'thumbnail' => 'Telkomsel.png',
            'created_at' => now(),
            'updated_at' => now(),
           ],
           [
            'name' => 'Indosat',
            'status' => 'inactive',
            'thumbnail' => 'indosat.png',
            'created_at' => now(),
            'updated_at' => now(),
           ],
           [
            'name' => '3 ',
            'status' => 'inactive',
            'thumbnail' => 'three.png',
            'created_at' => now(),
            'updated_at' => now(),
           ],
        ]);
    }
}
