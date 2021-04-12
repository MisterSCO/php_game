<?php

function getColorClass(float $fRatio) : string
{
    $sClass= '';
    if ($fRatio > 70) {
        $sClass = 'bg-success';
    } elseif ($fRatio > 35) {
        $sClass ='bg-warning';
    } elseif ($fRatio > 0) {
        $sClass = 'bg-danger';
    } elseif ($fRatio <= 0) {
        $sClass = 'bg-dark';
    }
    return $sClass;
}