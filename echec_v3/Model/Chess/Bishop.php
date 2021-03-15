<?php
namespace Model\Chess;

final class Bishop extends \Model\Pawn 
{
    /**@var string */
    protected const SYMBOL = '&#9815;';

    public function getMoves(): array
    {

        return [];
    }
}