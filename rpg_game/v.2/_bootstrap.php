<?php

// Gestion (et démarrage) des sessions PHP
session_start();
//session_destroy();

// Affichage des erreurs PHP (à ne pas faire en production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Auto-chargement des classes
// > on défini une fonction anonyme à appeler en cas d'erreur
spl_autoload_register(function ($sNamespaceClass) {
$sConvertedClass = str_replace('\\', '/', $sNamespaceClass);
include_once($sConvertedClass . '.php');
include_once('functions.php');
});