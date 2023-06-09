<?php

namespace Database\Seeders;

use App\Models\OrderItemsDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemsDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderItemsDetail::factory()
            ->count(3)
            ->create();
        // DB::table('order_items_details')->insert([
        //     'item_id' => 1,
        //     'order_item_id' => 1,
        //     'quantity' => 3,
        // ]);
        
        // DB::table('order_items_details')->insert([
        //     'item_id' => 2,
        //     'order_item_id' => 1,
        //     'quantity' => 5,
        // ]);
    }
}
