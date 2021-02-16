<?php
    error_reporting(E_ALL);
    ini_set('display_error',1);

    include_once 'functions.php';

    define('SIZE_X', 10);
    define('SIZE_Y', 10);

    define('WARRIOR', array(
    'classe' => 'Warrior',
    'health'   => '100',
    'strength' => '50') );

    define('WIZZARD', array(
    'classe' => 'Wizzard',
    'health'   => '80',
    'strength' => '50',
    'magic'    => '200'));



    echo '============== Début du programme =============='.PHP_EOL;

    //Initialisation d'un tableau "5x5"
    $board =[];


    // 1.a Initialisation des lignes
    // -- Pour toutes les lignes, j'attribue un tableau vide
    // for..

    for ($y=0; $y < SIZE_Y ; $y++) { 
        $board[$y]=[];
        for ($x=0; $x < SIZE_X ; $x++) {
            $board[$y][$x] = '.';
        }
    }

    $hercule = [
        'name'     => 'Hercule',
        'type' => WARRIOR,
        'position' => array(
            'y' => 0,
            'x' => 0,
        )
    ];

    $merlin = [
        'name'     => 'Merlin',
        'type' => WIZZARD,
        'position' => array(
            'y' => 0,
            'x' => 1,
        )
    ];

    $amaterasu = [
        'name'     => 'Amaterasu',
        'type' => WARRIOR,
        'position' => array(
            'y' => 0,
            'x' => 2,
        )
    ];
    
    $zeus = [
        'name'     => 'Zeus',
        'type' => WIZZARD,
        'position' => array(
            'y' => 0, 
            'x' => 3, 
        )
    ];


    $characters = [
        $hercule,
        $merlin,
        $amaterasu,
        $zeus
    ];




    //3. Positionner (aléatoirement) nos joueurs dans le plateau
    // ex: $board[0][0] = $merlin

    foreach ($characters as $character) {
        /* $y = rand(0,(SIZE_Y - 1));
            $x = rand(0,(SIZE_X - 1)); */

        $y = $character['position']['y'];
        $x = $character['position']['x']; 

        $board[$y][$x] = $character;
        echo '['. $x .'/' . $y .']'. $character['name']. PHP_EOL;
    }

    //4. Afficher le plateau de jeu proprement
    // [.] [.] [.] [.] [.]
    // [.] [.] [.] [.] [.]
    // [.] [.] [.] [.] [.]
    // [.] [.] [.] [.] [.]
    // [.] [.] [.] [.] [.]

    displayBoard($board);

    displayPlayers($characters);

    echo '============== Fin du programme =============='. "\n";

?>