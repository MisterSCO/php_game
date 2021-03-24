<div class="card card-abso">
    <div class="card-head bg-secondary text-white" style="padding: 1rem 0;">
        <?php echo $oPlayer->getCharacter()->getSymbol();
        echo $oPlayer->getCharacter()->getName();
        $pourcentCharac = ($oPlayer->getCharacter()->getHealth() / $oPlayer->getCharacter()->getMaxHealth()) * 100;
        ?>
    </div>
    <div class="card-body">
        <strong>Santé</strong>
        <div class="progress">
            <div class="progress-bar <?php echo getColorClass($pourcentCharac) ?>" role="progressbar" style="width: <?php echo round($pourcentCharac) ?>%" aria-valuenow="<?php echo $oPlayer->getCharacter()->getHealth() ?>" aria-valuemin="0" aria-valuemax="<?php echo $oPlayer->getCharacter()->getMaxHealth() ?>"><?php echo round($pourcentCharac) ?>%</div>
        </div>
        Point de vie actuel : <?php echo $oPlayer->getCharacter()->getHealth() ?>
        <br>
        <strong>Force</strong>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="<?php echo $oPlayer->getCharacter()->getStrength() ?>" aria-valuemin="0" aria-valuemax="<?php echo $oPlayer->getCharacter()->getStrength() ?>"></div>
        </div>
        Point de force actuel : <?php echo $oPlayer->getCharacter()->getStrength() ?>
        <?php if ($oPlayer->getCharacter() instanceof Model\Wizard) : ?>
            <br>
            <strong>Mana</strong>
            <div class="progress">
                <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="<?php echo $oPlayer->getCharacter()->getMagic() ?>" aria-valuemin="0" aria-valuemax="<?php echo $oPlayer->getCharacter()->getMagic() ?>">100%</div>
            </div>
            Point de mana actuel : <?php echo $oPlayer->getCharacter()->getMagic() ?>
        <?php endif ?>
    </div>
</div>

<?php

foreach ($oGame->getBoard() as $iY => $aLineY) : ?>
    <div class="row justify-content-center">
        <?php foreach ($aLineY as $iX => $mColX) :
            $bCellMovable = isset($aGameInfo['moves']) && in_array([$iX, $iY], $aGameInfo['moves']);
            $bCellCharacter = $mColX instanceof \Model\Character;
        ?>
            <div class="col-auto border text-center cell
                        
                        <?= $bCellMovable ? 'movable-cell' : ''; ?>
                        <?= $bCellCharacter ? 'character-cell' : ''; ?>" data-x="<?= $iX; ?>" data-y="<?= $iY; ?>">
                <?php

                if ($mColX instanceof \Model\Pawn) {
                    echo '<span class="pawn '. getColorClass($pourcentCharac) .'">';
                }

                

                if ($mColX instanceof \Model\Monster) {
                    $pourcentMonsters = ($oGame->getMonsters()->getHealth() / $oGame->getMonsters()::MAXHEALTH) * 100;
                    echo '<span class="monster ' . getColorClass($pourcentMonsters) . ' ">';
                }

                echo $mColX . '</span>';

                ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>