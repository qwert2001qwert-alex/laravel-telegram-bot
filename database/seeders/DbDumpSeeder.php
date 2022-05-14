<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DbDumpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::runningUnitTests()) {
            return;
        }

        ini_set('memory_limit', '-1');
        DB::unprepared(file_get_contents(database_path('dump/bot_init.sql')));
    }
}
