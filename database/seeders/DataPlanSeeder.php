<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_plans')->insert([
            [
                'name' => '1 GB',
                'price' => 25000,
                'operator_card_id' => 1,
            ],
            [
                'name' => '2 GB',
                'price' => 25000,
                'operator_card_id' => 1,
            ],
            [
                'name' => '5 GB',
                'price' => 25000,
                'operator_card_id' => 1,
            ],
            [
                'name' => '10 GB',
                'price' => 25000,
                'operator_card_id' => 1,
            ],
        ]);
    }
}
