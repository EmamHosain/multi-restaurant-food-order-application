<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DestroyTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:destroy {table}';
    protected $description = 'delete table all data';
    /**
     * The console command description.
     *
     * @var string
     */


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->argument('table');

        if ($this->confirm("Are you sure you want to truncate the table: {$table}?")) {
            DB::table($table)->truncate();
            $this->info("Table '{$table}' has been truncated.");
        } else {
            $this->info('Truncate operation canceled.');
        }
    }
}
