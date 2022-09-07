<?php

 function scopeSearch($query, $data)
{
    $query = $query->where('is_temp', 0);
    if(isset($data['name'])) {
        $query = $query->whereTranslationLike('name', '%'.$data['name'].'%');
    }
    if(isset($data['type']) && $data['type'] > 0){
        $query = $query->where('type', $data['type']);
    }
    $query = $query->orWhere(function ($q) {
        return $q->where('cms.is_temp', 1)
            ->whereHas('history', function($q) {
                return $q->where('action', '=', 'create')
                        ->where('user_id', Auth::user()->id);
            });
    });
    return $query;
}