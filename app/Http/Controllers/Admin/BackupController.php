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

    $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $filePath = storage_path('app/' . $fileName);

    $handle = fopen($filePath, 'w');

    fwrite($handle, "-- Backup Database\n");
    fwrite($handle, "-- Generated: " . date('Y-m-d H:i:s') . "\n\n");

    foreach ($tables as $table) {
        $tableName = $table->{"Tables_in_$dbName"};

        fwrite($handle, "DROP TABLE IF EXISTS `$tableName`;\n");

        $create = DB::select("SHOW CREATE TABLE `$tableName`");
        fwrite($handle, $create[0]->{'Create Table'} . ";\n\n");

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

            fwrite($handle, "INSERT INTO `$tableName` VALUES (" . implode(',', $values) . ");\n");
        }

        fwrite($handle, "\n\n");
    }

    fclose($handle);

    return response()->download($filePath)->deleteFileAfterSend(true);
}
}
