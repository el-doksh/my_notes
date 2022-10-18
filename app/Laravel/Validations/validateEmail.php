<?php
return [
    'email'  => 'required|email|max:250|unique:users,email|regex:/@(.+)\./',

];
