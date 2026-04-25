<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    public function backup()
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');

        $sql = "-- Backup Database\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";

        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_$dbName"};

            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";

            $create = DB::select("SHOW CREATE TABLE `$tableName`");
            $sql .= $create[0]->{'Create Table'} . ";\n\n";

            $rows = DB::table($tableName)->get();

            foreach ($rows as $row) {
                $values = [];

                foreach ((array)$row as $value) {
                    if (is_null($value)) {
                        $values[] = "NULL";
                    } else {
                        $values[] = "'" . str_replace("'", "''", $value) . "'";
                    }
                }

                $sql .= "INSERT INTO `$tableName` VALUES (" . implode(',', $values) . ");\n";
            }

            $sql .= "\n\n";
        }

        $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';

        return response($sql)
            ->header('Content-Type', 'application/sql')
            ->header('Content-Disposition', "attachment; filename={$fileName}");
    }
}
