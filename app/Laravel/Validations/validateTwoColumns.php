<?php
return [
    'phone' => [
        'nullable', 
        'numeric', 
        'digits_between:1,12', 
        'unique:users,phone,null,null,nationality_id,'.$this->nationality_id,
    ]
];
