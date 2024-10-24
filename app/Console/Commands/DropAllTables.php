<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropAllTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:drop-all-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all tables from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Get all table names
        $tables = DB::select('SHOW TABLES');

        // Get the name of the column where table names are stored
        $columnName = 'Tables_in_' . DB::getDatabaseName();

        // Drop each table
        foreach ($tables as $table) {
            $tableName = $table->$columnName;
            Schema::drop($tableName);
            $this->info("Dropped table: {$tableName}");
        }

        // Enable foreign key checks
        Schema::enableForeignKeyConstraints();

        $this->info('All tables dropped successfully');
    }
}
