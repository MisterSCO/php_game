<?php
namespace Model;

// On aurait pu simplifier le code
//use \Entity\Player;

/**
 * Le but de la classe RpgGame est de centraliser au maximum tout ce qui concerne le jeu "Chess"
 * (dont le plateau de jeu)
 * final = empêche l'héritage de la classe (non obligatoire)
 */
final class RpgGame extends AbstractGame
{
    
    // On précise les équipes
    public const TEAMS = ['White', 'Black'];

    // On précise les dimensions
    protected const SIZE_X = 25;
    protected const SIZE_Y = 25;

    /** @var array */
    protected array $monsters;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * addPlayer
     *
     * @return void
     */
    public function addPlayer(\Entity\Player $oPlayer) : void
    {
        parent::addPlayer($oPlayer);

        $iRandX = rand(0, static::SIZE_X -1);
        $iRandY = rand(0, static::SIZE_Y -1);

        $oPlayer->getcharacter()->setPosition($iRandX, $iRandY);

        $this->setXY($iRandX, $iRandY, $oPlayer->getcharacter());
    }

    /**
     * selectCell
     *
     * @param  int $x
     * @param  int $y
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
        
        // Validation des déplacements par RpgGame
        $aData['moves'] = $this->getValidMoves($oCharacter);

        // Est-ce que je déplace un pion?
        if (in_array([$x, $y], $aData['moves']) ) {
            
            // Mémoriser la case de départ
            $aPosInit = $oCharacter->getPosition();


            // Déplacer le pion
            $this->setXY($x, $y, $oCharacter);
            $oCharacter->setPosition($x, $y);


            // Effacer l'ancien pion
            $this->board[$aPosInit['y']][$aPosInit['x']] = ' ';

            // Déplacement des monstres
            $this->moveMonsters();
            
            // Optention des déplacements valids ré-actualisés
            $aData['moves'] = $this->getValidMoves($oCharacter);
            

            return $aData;
        }

        return $aData;
    }

    

    public function fillBoard() : void
    {
        for ($i = 0; $i < Mob::NB_MONSTERS; $i++) {
            
            $oMob = new Mob();
            
            
            [$iX, $iY] = [rand(0, self::SIZE_X - 1), rand(0, self::SIZE_Y - 1)];

            $oMob->setPosition($iX, $iY);

            $this->setXY($iX, $iY, $oMob);

            $this->monsters[] = $oMob;
        }
        
    }


    public function moveMonsters(): void
    {
        //var_dump($this->monsters);
        foreach ($this->monsters as $monster) {

            // Obtenir les déplacements possibles/voulus et valides
            $aMoves=$this->getValidMoves($monster);
            
            $aCoords = $aMoves[array_rand($aMoves)];
            $x = $aCoords[0];
            $y = $aCoords[1];

            // Memoriser la case de départ
            $aPosInit = $monster->getPosition();

            // Déplacer le pion
            $this->setXY($x, $y, $monster);
            $monster->setPosition($x, $y);


            // Effacer l'ancien pion
            $this->board[$aPosInit['y']][$aPosInit['x']] = ' ';
            
        }
    }

    /**
     * getValidMoves
     *
     * @return array
     */
    private function getValidMoves($oPawn)
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
                if (
                    !$this->isValidXY($aCoords[0], $aCoords[1])
                    || (!$this->isEmptyXY($aCoords[0], $aCoords[1]))
                ) {
                    // On arrête le traitement de cette valeur = on passe à la valeur suivante
                    continue;
                }

                // Traitement standard, on autorise la coordonnée
                $aValidMoves[] = $aCoords;
            }
        } else {
            // Case "Coordonnées liées"

            // Pour chacune des directions
            foreach ($aMoves as $aDirections) {
                // Pour chaque coordonnées, tester si la position est valide (= libre et existante)
                foreach ($aDirections as $aCoords) {
                    // Condition de sortie : case invalide ou non vide
                    if (
                        !$this->isValidXY($aCoords[0], $aCoords[1])
                        || (!$this->isEmptyXY($aCoords[0], $aCoords[1]))
                    ) {
                        // On arrête le traitement de cette direction
                        break;
                    }

                    // Traitement standard, on autorise la coordonnée
                    $aValidMoves[] = $aCoords;

                    // Cas spécial : si pion ennemi on arrête le traitement de cette direction
                    if (
                        !$this->isEmptyXY($aCoords[0], $aCoords[1])
                        && ($this->getXY($aCoords[0], $aCoords[1])->getPlayer() !== $oPawn->getPlayer())
                    ) {
                        break;
                    }
                }
            }
        }

        // Retourner les positions valides
        return $aValidMoves;
    }

    /**
     * Get the value of monster
     */ 
    public function getMonster()
    {
        return $this->monster;
    }

    /**
     * Set the value of monster
     *
     * @return  self
     */ 
    public function setMonster($monster)
    {
        $this->monster = $monster;

        return $this;
    }
}