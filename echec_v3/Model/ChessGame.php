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

    protected ?Pawn $selectedPawn = null;

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
            $bReplay = 
                !$this->isValidXY($x, $y) 
                || $this->isEmptyXY($x, $y) 
                || ($this->board[$y][$x]->getPlayer() !== $oPlayer
            );


            if ($bReplay) {
                echo 'Case vide, les coordonnées sont invalides ou vous essayer de jouer les pions adverse'.PHP_EOL;
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
    

        
    /**
     * getValidMoves
     *
     * @return array
     */
    private function getValidMoves(Pawn $oPawn) : array
    {
        $aValidMoves = [];

        // Récupérer les positions "envisagées" par le pion
        $aMoves = $oPawn->getMoves();

        // Pour chacune, tester si la position est valide (=libre)
        if (is_int($aMoves[0][0])) {
            foreach ($aMoves as $aCoords) {
                if(!$this->isValidXY($aCoords[0], $aCoords[1]) || (!$this->isEmptyXY($aCoords[0], $aCoords[1])) && $this->getXY($aCoords[0], $aCoords[1])->getPlayer() === $oPawn->getPlayer()) {
                    continue;
                }
                $aValidMoves[] = $aCoords;

                if (
                    !$this->isEmptyXY($aCoords[0], $aCoords[1])
                    && ($this->getXY($aCoords[0], $aCoords[1])->getPlayer() !== $oPawn->getPlayer())
                ) {
                    break;
                }
            }
        }
        else {
            foreach ($aMoves as $aDirections) {
                foreach ($aDirections as $aCoords) {
                    if (!$this->isValidXY($aCoords[0], $aCoords[1]) || (!$this->isEmptyXY($aCoords[0], $aCoords[1])) && $this->getXY($aCoords[0], $aCoords[1])->getPlayer() === $oPawn->getPlayer()) {
                        break;
                    }
                    $aValidMoves[] = $aCoords;

                    if (
                        !$this->isEmptyXY($aCoords[0], $aCoords[1])
                        && ($this->getXY($aCoords[0], $aCoords[1])->getPlayer() !== $oPawn->getPlayer())
                    ) {
                        break;
                    }
                }
            }
        }
        // Retourner la positions valides        
        return $aValidMoves;
    }

    
    /**
     * selectCell
     *
     * @param  int $x
     * @param  int $y
     * @return bool
     */
    public function selectCell(int $x, int $y): array
    {

        $aData = [
            'selected_pawn'  => $this->selectedPawn,
            'current_player' => $this->currentPlayer,
            'is_win'         => $this->isWin(),
            'moves'           => [],

        ];
        // Coordonnées invalides, on sort
        if (!$this->isValidXY($x, $y)) {
            return $aData;
        }

        // Est-ce que je séléctionne un pion?
        $oPawn = $this->board[$y][$x];
        if ($oPawn instanceof Pawn) {
            if ($oPawn->getPlayer() === $this->currentPlayer) {
                $this->selectedPawn = $oPawn;
                // On actualise le tableau des données à retourner
                $aData['selected_pawn'] = $this->selectedPawn;

                //$aData['moves'] = $oPawn->getMoves();

                $aData['moves'] = $this->getValidMoves($this->selectedPawn);
                

                return $aData;
            }
        }

        // Est-ce que je déplace un pion?
        if ($this->selectedPawn && (in_array([$x, $y], $this->getValidMoves($this ->selectedPawn))) ) {
            
            // Mémoriser la case de départ
            $aPosInit = $this->selectedPawn->getPosition();


            // Déplacer le pion
            $this->setXY($x, $y, $this->selectedPawn);
            $this->selectedPawn->setPosition($x, $y);


            // Effacer l'ancien pion
            $this->board[$aPosInit['y']][$aPosInit['x']] = ' ';
            $this->selectedPawn = null;

            
            // Joueur suivant
            $this->nextPlayer();
            // On actualise le tableau des données à retourner
            $aData['current_player'] = $this->currentPlayer;
            return $aData;
        }

        return $aData;
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
            0 => $this->players[1],
            7 => $this->players[0],
        ];
        foreach ($a as $i => $oPlayer) {
            $this->board[$i][0]              = (new Chess\Rook())   ->setPlayer( $oPlayer )->setPosition( 0, $i);
            $this->board[$i][1]              = (new Chess\Knight()) ->setPlayer( $oPlayer )->setPosition( 1, $i);
            $this->board[$i][2]              = (new Chess\Bishop()) ->setPlayer( $oPlayer )->setPosition( 2, $i);
            $this->board[$i][3]              = (new Chess\Queen())  ->setPlayer( $oPlayer )->setPosition( 3, $i);
            $this->board[$i][4]              = (new Chess\King())   ->setPlayer( $oPlayer )->setPosition( 4, $i);
            $this->board[$i][5]              = (new Chess\Bishop()) ->setPlayer( $oPlayer )->setPosition( 5, $i);
            $this->board[$i][6]              = (new Chess\Knight()) ->setPlayer( $oPlayer )->setPosition( 6, $i);
            $this->board[$i][self::SIZE_X-1] = (new Chess\Rook())   ->setPlayer( $oPlayer )->setPosition( 7, $i);
        }

        // Peons
        for ($i = 0 ; $i < self::SIZE_X ; $i++) {
            $this->board[1][$i] = (new Chess\Peon())->setPlayer( $this->players[1] )->setPosition($i , 1);
            $this->board[6][$i] = (new Chess\Peon())->setPlayer( $this->players[0] )->setPosition($i , 6);
        }

        // On défini le premier joueur
        $this->currentPlayer = $this->players[0];
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