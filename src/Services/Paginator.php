<?php

namespace App\Services;

class Paginator
{

    public function getPartiel($data, $offset, $length){

        return \array_slice($data, $offset, $length);

    }
    
}