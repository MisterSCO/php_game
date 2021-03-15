<?php
namespace Model\Chess;

final class Queen extends \Model\Pawn 
{
    /**@var string */
    protected const SYMBOL = '&#9813;';

    public function getMoves(): array
    {

        return [];
    }
}