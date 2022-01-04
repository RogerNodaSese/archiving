<?php 

namespace App\Classes;

class Color{
    
    public static function randomColor(){
        $color = collect([
            "#ddbb99",
            "#eebb88",
            "#ddeedd",
            "#faf0e6",
            "#ddeecc",
            "#bbeedd",
            "#d3ffce",
        ]);
        return $color->random();
    }
}