<?php 

namespace App\Classes;

class Color{
    
    public static function randomColor(){
        $color = collect([
           
            "#ddeedd"
        ]);
        return $color->random();
    }
}