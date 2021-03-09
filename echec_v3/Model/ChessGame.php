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
    }
    
    /**
     * @param \Entity\Player $oPlayer
     *
     * @return void
     */
    protected function playerAction (\Entity\Player $oPlayer) : void 
    {
        // Joueur, quel pion veux-tu déplacer ? (ex : 1,1)
        do {
            list($x, $y) = explode(',', readline('Quel pion ? '));

            // TEST : case non vide? et coordonnées valides ?
            $bReplay = !$this->isValidXY($x, $y) || $this->isEmptyXY($x, $y);
            if ($bReplay) {
                echo 'Case vide OU coordonnées invalides'.PHP_EOL;
            }
        } while ($bReplay);

        // Joueur, où veux-tu le déplacer ? (ex : 1,2)
        do {
            list($newX, $newY) = explode(',', readline('Quelle destination ? '));

            // TEST : coordonnées valides ?
            $bReplay = !$this->isValidXY($newX, $newY);
            if ($bReplay) {
                echo 'Coordonnées invalides'.PHP_EOL;
            }
        } while ($bReplay);

        // Tout est OK, on effectue le déplacement
        // 1. Je récupère le pion en $x, $y
        $oPawn = $this->board[$y][$x];
        // 2. Je le duplique dans $newX, $newY
        $this->setXY($newX, $newY, $oPawn);
        // 3. On l'efface dans $x, $y
        $this->board[$y][$x] = ' ';
    }

    protected function isWin () : bool 
    {
        // TODO
        
        return false;
    }

    public function fillBoard() : void
    {
        // Others pawns
        $a = [
            0 => $this->players[0],
            7 => $this->players[1],
        ];
        foreach ($a as $i => $oPlayer) {
            $this->board[$i][0] = (new Chess\Rook())->setPlayer( $oPlayer );
            $this->board[$i][1] = (new Chess\Knight())->setPlayer( $oPlayer );
            $this->board[$i][2] = (new Chess\Bishop())->setPlayer( $oPlayer );
            $this->board[$i][3] = (new Chess\Queen())->setPlayer( $oPlayer );
            $this->board[$i][4] = (new Chess\King())->setPlayer( $oPlayer );
            $this->board[$i][5] = (new Chess\Bishop())->setPlayer( $oPlayer );
            $this->board[$i][6] = (new Chess\Knight())->setPlayer( $oPlayer );
            $this->board[$i][self::SIZE_X-1] = (new Chess\Rook())->setPlayer( $oPlayer ); 
        }

        // Peons
        for ($i = 0 ; $i < self::SIZE_X ; $i++) {
            $this->board[1][$i] = (new Chess\Peon())->setPlayer( $this->players[0] );
            $this->board[6][$i] = (new Chess\Peon())->setPlayer( $this->players[1] );
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