<?php
namespace Model;

// On aurait pu simplifier le code
//use \Entity\Player;

/**
 * Le but de la classe RpgGame est de centraliser au maximum tout ce qui concerne le jeu "RPG"
 * (dont le plateau de jeu)
 * final = empêche l'héritage de la classe (non obligatoire)
 * extends = hérite des propriétés publics/protégées (UN SEUL HERITAGE POSSIBLE)
 */
final class RpgGame extends AbstractGame
{
    // On précise les dimensions
    protected const SIZE_X = 25;
    protected const SIZE_Y = 25;

    /** @var array */
    private array $monsters = [];
    
    public function __construct()
    {
        parent::__construct();

        $this->fillBoard();
    }

    /**
     * @param  Player $player
     * @return void
     */
    public function addPlayer(\Entity\Player $oPlayer) : void
    {
        parent::addPlayer($oPlayer);

        // Positionnement aléatoire du pion du joueur
        $iRandX = rand(0, self::SIZE_X - 1);
        $iRandY = rand(0, self::SIZE_Y - 1);

        $oPlayer->getCharacter()->setPosition($iRandX, $iRandY);
        $this->setXY($iRandX, $iRandY, $oPlayer->getCharacter());
        //$this->board[$iRandY][$iRandX] = $oPlayer->getCharacter();
    }

    public function lifetime(): void
    {
        $this->moveMonsters();
    }

    /**
     * @param Player $oPlayer
     * @param int $x
     * @param int $y
     *
     * @return array
     */
    public function selectCell(\Entity\Player $oPlayer, int $x, int $y): array
    {
        $aData = [
            'moves' => [],
        ];

        // Coordonnées invalides, on sort
        if (!$this->isValidXY($x, $y)) {
            return $aData;
        }

        // On récupère le "pion" du joueur
        $oCharacter = $oPlayer->getCharacter();

        // Obtention des déplacements valides
        $aData['moves'] = $this->getValidMoves($oCharacter);

        // Déplacement autorisé ?
        if (in_array([$x, $y], $aData['moves'])) {
            if (!$oCharacter->isDead()) {
                $this->moveXY($x, $y, $oCharacter);
            }

            // Obtention des déplacements valides ré-actualisés
            $aData['moves'] = $this->getValidMoves($oCharacter);

            return $aData;
        }

        return $aData;
    }

    /**
     * @param Player $oPlayer
     * @param int $x
     * @param int $y
     *
     * @return bool
     */
    public function attack(\Entity\Player $oPlayer): bool
    {
        // On récupère le "pion" du joueur
        $oCharacter = $oPlayer->getCharacter();
        
        // Obtention de la zone d'attaque
        $aCoords = $oCharacter->getAttacks();
        foreach ($aCoords as $aCoord) {
            if (!$this->isValidXY($aCoord[0], $aCoord[1]) || $this->isEmptyXY($aCoord[0], $aCoord[1])) {
                continue;
            }

            $oMonster = $this->getXY($aCoord[0], $aCoord[1]);
            if ($oMonster instanceof Monster) {
                $oCharacter->hit($oMonster);
            }
        }

        return true;
    }

    private function fillBoard() : void
    {
        for ($i = 0 ; $i < Spider::NB_MONSTERS ; $i++) {
            $oMonster = new Spider();

            $this->moveXY(rand(0, self::SIZE_X - 1), rand(0, self::SIZE_Y - 1), $oMonster);

            // On mémorise le monstre pour les récupérer plus tard
            $this->monsters[] = $oMonster;
        }

        for ($i = 0 ; $i < SpiderQueen::NB_MONSTERS ; $i++) {
            $oMonster = new SpiderQueen();

            $this->moveXY(rand(0, self::SIZE_X - 1), rand(0, self::SIZE_Y - 1), $oMonster);

            // On mémorise le monstre pour les récupérer plus tard
            $this->monsters[] = $oMonster;
        }

        for ($i = 0 ; $i < Dragon::NB_MONSTERS ; $i++) {
            $oMonster = new Dragon();

            $this->moveXY(rand(0, self::SIZE_X - 1), rand(0, self::SIZE_Y - 1), $oMonster);

            // On mémorise le monstre pour les récupérer plus tard
            $this->monsters[] = $oMonster;
        }
    }
    
    /**
     * @return void
     */
    private function moveMonsters() : void
    {
        // Pour chaque monstre
        foreach ($this->monsters as $iIdx => $oMonster) {
            if ($oMonster->isDead()) {
                unset($this->monsters[$iIdx]);
                continue;
            }

            // Obtenir les déplacements possibles/voulus et valides
            $aMoves = $this->getValidMoves($oMonster);
            if ($aMoves) {
                // Choisir un déplacement de manière aléatoire
                $aCoords = $aMoves[ array_rand($aMoves) ];
                $x = $aCoords[0];
                $y = $aCoords[1];
    
                // Déplacer le monstre
                $this->moveXY($x, $y, $oMonster);
            }
            
            // Obtention de la zone d'attaque
            $aCells = $oMonster->getAttackCells();
            foreach ($aCells as $aCell) {
                if (!$this->isValidXY($aCell[0], $aCell[1]) || $this->isEmptyXY($aCell[0], $aCell[1])) {
                    continue;
                }

                $oCharacter = $this->getXY($aCell[0], $aCell[1]);
                if ($oCharacter instanceof Character) {
                    $oMonster->hit($oCharacter);
                }
            }
        }
    }
        
    /**
     * @param Pawn $oPawn
     *
     * @return array
     */
    private function getValidMoves($oPawn): array
    {
        $aValidMoves = [];

        // Récupèrer les positions "envisagées" par le pion
        $aMoves = $oPawn->getMoves();
        if (!$aMoves) {
            return [];
        }

        if (is_int($aMoves[0][0])) {
            // Cas "Coordonnées séparées"
            // Pour chaque coordonnées, tester si la position est valide (= libre et existante)
            foreach ($aMoves as $aCoords) {
                // Condition de sortie : case invalide ou non vide
                if (!$this->isValidXY($aCoords[0], $aCoords[1]) || !$this->isEmptyXY($aCoords[0], $aCoords[1])) {
                    // On arrête le traitement de cette valeur = on passe à la valeur suivante
                    continue;
                }

                // Traitement standard, on autorise la coordonnée
                $aValidMoves[] = $aCoords;
            }
        }
        else {
            // Case "Coordonnées liées"

            // Pour chacune des directions
            foreach ($aMoves as $aDirections) {
                // Pour chaque coordonnées, tester si la position est valide (= libre et existante)
                foreach ($aDirections as $aCoords) {
                    // Condition de sortie : case invalide ou non vide
                    if (!$this->isValidXY($aCoords[0], $aCoords[1]) || !$this->isEmptyXY($aCoords[0], $aCoords[1])) {
                        // On arrête le traitement de cette direction
                        break;
                    }

                    // Traitement standard, on autorise la coordonnée
                    $aValidMoves[] = $aCoords;

                    // Cas spécial : si pion ennemi on arrête le traitement de cette direction
                    if (!$this->isEmptyXY($aCoords[0], $aCoords[1]) 
                                && ($this->getXY($aCoords[0], $aCoords[1])->getPlayer() !== $oPawn->getPlayer())) {
                        break;
                    }

                }
            }
        }

        // Retourner les positions valides
        return $aValidMoves;
    }
}