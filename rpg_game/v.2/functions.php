<?php

function getColorClass(float $fRatio) : string
{
    $sClass= '';
    if ($fRatio > 70) {
        $sClass = 'bg-success';
    } elseif ($fRatio > 35) {
        $sClass ='bg-warning';
    } else {
        $sClass = 'bg-danger';
    }
    return $sClass;
}