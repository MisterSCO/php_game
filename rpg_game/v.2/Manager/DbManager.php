<?php
namespace Manager;

class DbManager
{
    /** @var \Pdo */
    private static $pdo = null;

    /** 
     * @return \Pdo
     */
    public static function getDb()
    {
        if (is_null(static::$pdo)) {
            try {
                static::$pdo = new \PDO('mysql:host=localhost;dbname=poo', 'root', '');

                // Affichage des erreurs PDO (à ne pas faire en production)
                static::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            catch (\Exception $e) {
              echo $e->getMessage() . PHP_EOL;
              die;
            }
        }

        return static::$pdo;
    }
}
