<?php

namespace App\Imports\Question;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportQuestions implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // variable $row here holds only one row from the excel
        //  so you can use it direct to your model
        return new User([
            'name' => $row[0],
            'email' => $row[1],
            'password' => bcrypt($row[2]),
        ]);
    }
}
