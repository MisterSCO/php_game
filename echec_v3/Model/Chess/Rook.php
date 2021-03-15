<?php
namespace Model\Chess;

final class Rook extends \Model\Pawn 
{
    /**@var string */
    protected const SYMBOL = '&#9814;';

    public function getMoves(): array
    {

        return [];
    }
}