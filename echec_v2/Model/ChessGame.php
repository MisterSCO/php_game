<?php
namespace Model;

// On aurait pu simplifier le code
//use \Entity\Player;

/**
 * Le but de la classe ChessGame est de centraliser au maximum tout ce qui concerne le jeu "Chess"
 * (dont le plateau de jeu)
 * final = empêche l'héritage de la classe (non obligatoire)
 */
final class ChessGame extends AbstractGame
{
    // On précise les équipes
    public const TEAMS = ['White', 'Black'];

    // On précise les dimensions
    protected const SIZE_X = 8;
    protected const SIZE_Y = 8;

    public function __construct()
    {
        parent::__construct();

        $this->fillBoard();
    }

    protected function playerAction (\Entity\Player $oPlayer) : void 
    {
        // Joueur, quel pion veux-tu déplacer??  (ex : 1,1)
        // TEST: pion présent?

        // Joueur, où veux-te le déplacer? (ex : 1,2)

        
            
        do {
            // Obtenir les coordonnées saisies désirées par le joueur
            // readline permet de récupérer une saisie utilisateur
            // explode : permet de scinder une chaîne de caractère en un tableau (plusieurs morceaux)
            $sResponse = readline($oPlayer->getName() . ', quel pion veux-tu déplacer ? ');
            list($x, $y) = explode(',',  $sResponse);

            // On teste si la case est vide ET si les coordonnées sont valides
            $bReplay = !$this->isValidXY($x, $y) || $this->isEmptyXY($x, $y);
            
            if ($bReplay) {
                echo "Il n'y a pas de pion ici ou les coordonnées ne sont pas valide" . PHP_EOL;
            }
            // Condition de "reboucle" : pas valide ou pas vide
        } while ($bReplay);

        do {
            $sResponse = readline($oPlayer->getName() . ', où veux-tu le déplacer? ');
            list($newX, $newY) = explode(',',  $sResponse);

            $bReplay = !$this->isValidXY($newX, $newY);

            if ($bReplay) {
                echo "Les coordonnées ne sont pas valide" . PHP_EOL;
            }
        } while ($bReplay);

        $oPawn = $this->board[$y][$x];
        $this->board[$newY][$newX] = $oPawn;
        $this->board[$y][$x] = ' ';

        readline('STOP');
    }

    protected function isWin () : bool 
    {
        // TODO
        
        return false;
    }

    private function fillBoard() : void
    {
        // Others pawns
        $a = [0, 7];
        foreach ($a as $i) {
            $this->board[$i][0] = new Chess\Rook();
            $this->board[$i][1] = new Chess\Knight();
            $this->board[$i][2] = new Chess\Bishop();
            $this->board[$i][3] = new Chess\Queen();
            $this->board[$i][4] = new Chess\King();
            $this->board[$i][5] = new Chess\Bishop();
            $this->board[$i][6] = new Chess\Knight();
            $this->board[$i][self::SIZE_X-1] = new Chess\Rook(); 
        }

        // Peons
        for ($i = 0 ; $i < self::SIZE_X ; $i++) {
            $this->board[1][$i] = new Chess\Peon();
            $this->board[6][$i] = new Chess\Peon();
        }
    }

    /**
     * Solution optimisée qui défini les coordonnées pour chaque type de pion
     * Mais la version 3 est meilleure (plus optimisée)
     */
    private function fillBoardVersion2() : void
    {
        $aRocks = [ [0,0], [0,7], [7,0], [7,7]  ];
        foreach ($aRocks as $aCoords) {
            $this->board[ $aCoords[0] ][ $aCoords[1] ] = new Chess\Rook();
        }

        $aQueens = [ [0,3], [7,3] ];
        foreach ($aRocks as $aCoords) {
            $this->board[ $aCoords[0] ][ $aCoords[1] ] = new Chess\Rook();
        }

        // ...
    }

    /**
     * Solution optimisée (++) qui défini les coordonnées pour chaque type de pion
     */
    private function fillBoardVersion3() : void
    {
        $aPawns = [
            Chess\Rook::class => [ [0,0], [0,7], [7,0], [7,7]  ],
            Chess\Queen::class => [ [0,3], [7,3]  ],
            // ...
        ];
        foreach ($aPawns as $sClass => $aListCoords) {
            foreach ($aListCoords as $aCoords) {
                $this->board[ $aCoords[0] ][ $aCoords[1] ] = new $sClass();
            }
        }
    }
}