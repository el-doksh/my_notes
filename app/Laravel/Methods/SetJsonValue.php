<?php

function setMessageAttribute($value)
{
    $this->attributes['message'] = json_encode($value);
}

// or
public $cast = [
    'message' => 'array',
];