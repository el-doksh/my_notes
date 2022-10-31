<?php

namespace App\Imports\Question;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportQuestions implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public function collection(Collection $data)
    {
        // variable $data here holds all excel rows
        // so you can foreach on it and make your logic
        foreach ($data as $key => $item) {
            if($key > 0 ){
                User::create([
                    'email'=> $item[0],
                    'name' => $item[1],
                ]);
            }
        }
        // dd($data[100]);
        # code...
    }
   
}
