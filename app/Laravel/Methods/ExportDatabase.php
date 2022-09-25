<?php

use Spatie\DbDumper\Databases\MySql;

public function export(Request $request)
    {
        $folderName = 'db_backups';
        //create folder if it doesn't exists
        \Storage::makeDirectory($folderName);
        // generate a sql file
        $fileName = strtotime(now()).'_dump.sql';
        MySql::create()
            ->setDbName(ENV('DB_DATABASE'))
            ->setUserName(ENV('DB_USERNAME'))
            ->setPassword(ENV('DB_PASSWORD'))
            ->dumpToFile( storage_path("app/$folderName/$fileName") );

        return \Storage::download("$folderName/$fileName");
    }
    
    public function export_file($file)
    {
        $folderName = Setting::DB_FOLDER;
        return \Storage::download("$folderName/$file");
    }

    function export_manual_database_laravel(Type $var = null)
    {

        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        // $tables             = array("users","messages","posts"); //here your tables...

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword",
            array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();

        $output = '';
        foreach($result as $table) {
            $table_name = $table[0];
            $show_table_query = "SHOW CREATE TABLE " . $table_name . "";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();

            foreach($show_table_result as $show_table_row) {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table_name . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();

            for($count=0; $count<$total_row; $count++) {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);
                $output .= "\nINSERT INTO $table_name (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= '"'. implode('","', $table_value_array) . '");';
            }
        }
        
        $folder_name = Setting::DB_FOLDER;
        Storage::makeDirectory($folder_name, '0777', true);
        $file_name = strtotime(now()).'_dump.sql';
        // $file_handle = fopen($file_name, 'w+');
        // fwrite($file_handle, $output);
        // fclose($file_handle);
        Storage::put("$folder_name/$file_name", $output);
        return Storage::download("$folder_name/$file_name");
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        ob_clean();
        flush();
        readfile($file_name);
        unlink($file_name);
        return Storage::download("$folder_name/$file_name");
    }