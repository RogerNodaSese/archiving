<?php

namespace App\Classes;
use Carbon\Carbon;
class Date {

    public static function months(){
        return collect([
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ]);
    }

    public static function days($month = 1){
        if($month == 2)
        {
            return collect()->range(1,28);
        }
        if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12){
            return collect()->range(1,31);
        }else{
            return collect()->range(1,30);
        }
    }

    public static function years(){
        
        return collect()->range(1970,Carbon::now()->year);
    }
}