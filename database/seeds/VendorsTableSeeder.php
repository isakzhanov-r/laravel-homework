<?php

use Illuminate\Database\Seeder;

use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit = 10;

        factory(Vendor::class, $limit)->create();
    }
}
