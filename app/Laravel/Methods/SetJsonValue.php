<?php

function setMessageAttribute($value)
{
    $this->attributes['message'] = json_encode($value);
}