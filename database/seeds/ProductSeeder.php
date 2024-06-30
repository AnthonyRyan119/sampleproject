<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->insert([
            'name' => 'Test Product',
            'category' => 'Test',
            'date' => '2024-06-30 03:41 pm',
            'description' => 'testing',
        ]);
    }
}
