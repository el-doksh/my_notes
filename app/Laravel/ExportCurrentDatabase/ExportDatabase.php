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
