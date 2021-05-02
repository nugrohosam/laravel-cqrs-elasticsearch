<?php

namespace App\Transformers;

class BookTransformer {

    public static function fromJsonListener($book, $inArray = false){
        return json_decode($book, $inArray);
    }
}