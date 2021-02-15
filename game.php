<?php
    error_reporting(E_ALL);
    ini_set('display_error',1);

    include_once 'functions.php';

    define('SIZE_X', 10);
    define('SIZE_Y', 10);



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
        'health'   => '100',
        'strength' => '50'
    ];

    $merlin = [
        'name'     => 'Merlin',
        'health'   => '80',
        'strength' => '50',
        'magic'    => '200'
    ];

    $amaterasu = [
        'name'     => 'Amaterasu',
        'health'   => '90',
        'strength' => '40',
    ];
    
    $zeus = [
        'name'     => 'Zeus',
        'health'   => '60',
        'strength' => '20',
        'magic'    => '230'
    ];

    $sobek = [
        'name'     => 'Sobek',
        'health'   => '200',
        'strength' => '10',
        'magic'    => '20'
    ];


    $characters = [
        $hercule,
        $merlin,
        $amaterasu,
        $zeus,
        $sobek
    ];

    
    
    
    //3. Positionner (aléatoirement) nos joueurs dans le plateau
    // ex: $board[0][0] = $merlin

    foreach ($characters as $character) {
        $board[rand(0, 4)][rand(0, 4)] = $character;
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