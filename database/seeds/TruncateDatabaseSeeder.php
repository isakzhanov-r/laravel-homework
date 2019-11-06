<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class TruncateDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = $this->getTables();
        Schema::disableForeignKeyConstraints();

        $tables->each(function ($table) {
            DB::table($table)->truncate();
        });

        Schema::enableForeignKeyConstraints();
    }

    private function getTables(): \Illuminate\Support\Collection
    {
        $needable = ['migrations', 'users', 'password_resets'];

        $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        return collect($tables)->filter(function ($table) use ($needable) {
            return !in_array($table, $needable);
        });
    }
}
