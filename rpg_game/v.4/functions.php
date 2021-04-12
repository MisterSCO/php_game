<?php
/**
 * @param float $fRatio
 *
 * @return string
 */
function getColorClass(float $fRatio): string
{
    $sClass = 'success';
    
    if ($fRatio >= 75) {
        $sClass = 'success';
    }
    elseif ($fRatio >= 25) {
        $sClass = 'warning';
    }
    elseif ($fRatio > 0) {
        $sClass = 'danger';
    }
    elseif ($fRatio <= 0) {
        $sClass = 'dark';
    }

    return $sClass;
}