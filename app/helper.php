<?php

use Carbon\Carbon;

function generatefilename($name){

    $year=Carbon::now()->year;
    $month=Carbon::now()->month;
    $day=Carbon::now()->day;
    $hour=Carbon::now()->hour;
    $minute=Carbon::now()->minute;
    $second=Carbon::now()->second;
    $microsecond=Carbon::now()->microsecond;
    $filename=$year."_".$month."_".$day."_".$hour."_".$minute."_".$second."_".$microsecond."_".$name;

    return $filename;

}

function convertdate($getdate){
    if($getdate == null){
        return null;
    }
    $pattern="/[-\s]/";
    $date=preg_split($pattern ,$getdate);
    $shamsidate=verta()->getGregorian($date[0],$date[1],$date[2]);
    $gregoriandate=implode($shamsidate,"-")." ".$date[3];
    return $gregoriandate;
}
