<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('model/Character.php');
include_once('model/Warrior.php');
include_once('model/Wizard.php');




$oHercule = new Warrior('Hercule');
echo $oHercule . PHP_EOL;
$oHercule->setHealth(150);
$oHercule->setStrength(50);
$oHercule -> display();


$oMerlin = new Wizard('Merlin');
echo $oMerlin . PHP_EOL;
$oMerlin->setHealth(70);
$oMerlin->setStrength(20);
$oMerlin->setMagic(200);
$oMerlin->display();



echo '=========================== Début du combat ===========================' . PHP_EOL;
echo '**************************** Tour numéro 1 ****************************' . PHP_EOL;

$oHercule->hit($oMerlin);
$oMerlin->display();
$oHercule->display();


$oMerlin -> fireball($oHercule);
$oMerlin->display();
$oHercule->display();

echo '**************************** Tour numéro 2 ****************************' . PHP_EOL;

$oMerlin -> heal();
$oMerlin->display();
$oHercule->display();

echo '=========================== Fin du combat ===========================' . PHP_EOL;