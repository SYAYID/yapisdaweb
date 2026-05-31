<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateLegacyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-legacy-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from legacy database to the current database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting legacy data migration...');

        $tables = [
            'users',
            'registrations',
            'smp_registrations' => 'registrations_smp', // Local table name => Legacy table name
            'applicants',
            'smp_applicants'
        ];

        foreach ($tables as $localTable => $legacyTable) {
            if (is_int($localTable)) {
                $localTable = $legacyTable;
            }

            $this->info("Migrating {$legacyTable} to {$localTable}...");

            $records = DB::connection('mysql_old')->table($legacyTable)->get();
            $count = 0;

            // Get columns of the local table to filter out non-existent columns from legacy
            $localColumns = Schema::connection('mysql')->getColumnListing($localTable);

            foreach ($records as $record) {
                $data = (array) $record;

                // Handle column renames
                if ($legacyTable === 'registrations_smp' && isset($data['school_type'])) {
                    $data['school_program'] = $data['school_type'];
                    unset($data['school_type']);
                }
                
                // Filter out any columns from the legacy data that don't exist in the local schema
                $filteredData = [];
                foreach ($data as $key => $value) {
                    if (in_array($key, $localColumns)) {
                        $filteredData[$key] = $value;
                    }
                }

                // Insert into local DB
                try {
                    // Try to update or insert to keep IDs
                    $id = $filteredData['id'] ?? null;
                    if ($id && DB::table($localTable)->where('id', $id)->exists()) {
                        DB::table($localTable)->where('id', $id)->update($filteredData);
                    } else {
                        DB::table($localTable)->insert($filteredData);
                    }
                    $count++;
                } catch (\Exception $e) {
                    $this->error("Failed to insert record ID " . ($filteredData['id'] ?? 'unknown') . " into {$localTable}: " . $e->getMessage());
                }
            }

            $this->info("Successfully migrated {$count} records into {$localTable}.");
        }

        $this->info('Legacy data migration completed successfully.');
    }
}
