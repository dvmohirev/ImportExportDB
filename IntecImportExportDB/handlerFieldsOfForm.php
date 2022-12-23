<?php

class handlerFieldsOfForm
{

    public function __construct()
    {
    }

    function rightSmallText($small_text, $big_text){
        if($small_text == null || $small_text == ''){
            $small_text = mb_substr($big_text, 0, 30);
        }
        return mb_substr(strip_tags($small_text),0, 30);
    }
}