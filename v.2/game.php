<?php
    error_reporting(E_ALL);
    ini_set('display_error',1);

    include_once 'functions.php';

    define('SIZE_X', 10);
    define('SIZE_Y', 10);

    define('TYPE_WARRIOR', [
        'name' => 'Warrior',
        'min_health' => 170,
        'max_health' => 300,
        'min_strength' => 70,
        'max_strength' => 100,
    ]);
    define('TYPE_WIZARD', [
        'name' => 'Wizard',
        'min_health' => 100,
        'max_health' => 200,
        'min_strength' => 25,
        'max_strength' => 50,
        'min_magic' => 150,
        'max_magic' => 250
    ]);




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
        'type' => TYPE_WARRIOR,
    ];

    

    $merlin = [
        'name'     => 'Merlin',
        'type' => TYPE_WIZARD,
    ];

    

    $amaterasu = [
        'name'     => 'Amaterasu',
        'type' => TYPE_WARRIOR,
    ];

    
    
    $zeus = [
        'name'     => 'Zeus',
        'type' => TYPE_WIZARD,
    ];


    

    $characters = [
        $hercule,
        $merlin,
        $amaterasu,
        $zeus,
    ];

    foreach ($characters as &$character) {
        buildStatsRef($character);
    }
    
    
    //3. Positionner (aléatoirement) nos joueurs dans le plateau
    // ex: $board[0][0] = $merlin

    unset ($character);
    foreach ($characters as $character) {
        $board[$character['position']['y']][$character['position']['x']] = $character;
        
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