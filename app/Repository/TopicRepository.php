<?php

namespace App\Repository;

use App\Model\Topic;

class TopicRepository {

    public function getAll($select = [], $params = []) : array 
    {
        $topics = Topic::latest()->get();    

        return $topics;
    }
}