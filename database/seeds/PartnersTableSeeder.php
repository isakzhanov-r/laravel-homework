<?php

use Illuminate\Database\Seeder;

use App\Models\Partner;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $limit = 20;

        factory(Partner::class, $limit)->create();
    }
}
