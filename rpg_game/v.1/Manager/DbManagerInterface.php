<?php
namespace Manager;

interface DbManagerInterface
{
    /**
     * static = fonction rattachée au référentiel
     */
    public static function loadAll () : array;
    public static function get (int $iId) : ?object;

    /**
     * Fonctions classiques (rattachées à l'instance)
     */
    public function save () : void;
    public function delete () : void;
}