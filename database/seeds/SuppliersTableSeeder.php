<?php

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Supplier::truncate();  // 先清理表数据
        factory(Supplier::class, 20)->create();
    }
}
