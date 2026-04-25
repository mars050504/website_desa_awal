public function backup()
{
    $tables = DB::select('SHOW TABLES');
    $dbName = env('DB_DATABASE');

    $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';

    return response()->streamDownload(function () use ($tables, $dbName) {

        echo "-- Backup Database\n";
        echo "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";

        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_$dbName"};

            echo "DROP TABLE IF EXISTS `$tableName`;\n";

            $create = DB::select("SHOW CREATE TABLE `$tableName`");
            echo $create[0]->{'Create Table'} . ";\n\n";

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

                echo "INSERT INTO `$tableName` VALUES (" . implode(',', $values) . ");\n";
            }

            echo "\n\n";
        }

    }, $fileName);
}
