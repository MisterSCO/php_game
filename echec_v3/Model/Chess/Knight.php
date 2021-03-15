<?php
namespace Model\Chess;

final class Knight extends \Model\Pawn 
{
    /**@var string */
    protected const SYMBOL = '&#9816;';

    public function getMoves(): array
    {

        return [];
    }
}