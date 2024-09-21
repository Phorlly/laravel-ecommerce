<?php

use Illuminate\Support\Facades\Request;

function isActive($path, $index = 2)
{
    return Request::segment($index) == $path ? true : false;
}
