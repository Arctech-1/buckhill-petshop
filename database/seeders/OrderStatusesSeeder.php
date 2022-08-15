<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $orderStatuses = ['open', 'pending payment', 'paid', 'shipped', 'cancelled'];
        for ($i = 0; $i < count($orderStatuses); $i++) {
            DB::table('order_statuses')->insert([
                'uuid' => Str::uuid(),
                'title' => $orderStatuses[$i],
                'created_at'=>  now(),
                'updated_at'=>  now(),
            ]);
        }
    }
}
