<?php 
if ($oPlayer) :
    $oPlayer = $oGame->getPlayers()[0];
    $oCharacter = $oPlayer->getCharacter();

?>
<div class="card character-info" style="position: absolute; width: 200px;">
    <div class="card-header">
        <?= $oCharacter . ' '. $oCharacter->getName(); ?><br />
        <em><?= $oCharacter::NAME; ?></em>
    </div>
    <div class="card-body">
        <?php $iRatio = $oCharacter->isDead() ? 0 : $oCharacter->getHealth()/$oCharacter->getMaxHealth()*100; ?>
        <div class="mb-3">
            <strong>Santé</strong>
            <div class="progress">
                <div class="progress-bar progress-bar-striped bg-<?= getColorClass($iRatio); ?>" role="progressbar" style="width: <?= $iRatio; ?>%"
                    aria-valuenow="<?= $oCharacter->getHealth(); ?>" 
                    aria-valuemin="0" 
                    aria-valuemax="<?= $oCharacter->getMaxHealth(); ?>">
                <?= round($iRatio, 0); ?> %
                </div>
            </div>
            <em><?= $oCharacter->isDead() ? 0 : $oCharacter->getHealth(); ?> points de vie</em>
        </div>

        <div class="mb-3">
            <strong>Force</strong>
            <div class="progress">
                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 100%"
                    aria-valuenow="<?= $oCharacter->getStrength(); ?>" 
                    aria-valuemin="0" 
                    aria-valuemax="<?= $oCharacter->getStrength(); ?>">
                </div>
            </div>
            <em><?= $oCharacter->getStrength(); ?> points de force</em>
        </div>

        <?php if ($oCharacter instanceof Model\Wizard):
            $iRatio = $oCharacter->getMagic()/$oCharacter->getMaxMagic()*100; ?>
        <div class="mb-3">
            <strong>Magie</strong>
            <div class="progress">
                <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: <?= $iRatio; ?>%"
                    aria-valuenow="<?= $oCharacter->getMagic(); ?>" 
                    aria-valuemin="0" 
                    aria-valuemax="<?= $oCharacter->getMaxMagic(); ?>">
                <?= $iRatio; ?> %
                </div>
            </div>
            <em><?= $oCharacter->getMagic(); ?> points de magie</em>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php
    foreach ( $oGame->getBoard() as $iY => $aLineY ): ?>
    <div class="row justify-content-center">
        <?php foreach ( $aLineY as $iX => $mColX ):
            $bCellMovable = isset($aGameInfo['moves']) && in_array([$iX, $iY], $aGameInfo['moves']);
            $bCellCharacter = $mColX instanceof \Model\Character;

            $sClass = '';
            if ($mColX instanceof \Model\Monster) {
                $iRatio = $mColX->isDead() ? 0 : $mColX->getHealth()/$mColX::MAX_HEALTH*100;
                $sClass = 'bg-'.getColorClass($iRatio);
            }
            elseif ($mColX instanceof \Model\Character) {
                $iRatio = $mColX->isDead() ? 0 : $mColX->getHealth()/$mColX->getMaxHealth()*100;
                $sClass = 'bg-'.getColorClass($iRatio);
            }
            ?>
            <div    class="col-auto border text-center cell
                        <?= $bCellMovable ? 'movable-cell' : ''; ?>
                        <?= $bCellCharacter ? 'character-cell' : ''; ?>
                        <?= $sClass ?>" 
                    data-x="<?= $iX; ?>" data-y="<?= $iY; ?>">
                <?php
                    if ($mColX instanceof \Model\Pawn) {
                        echo '<span class="pawn">';
                    }
                    echo $mColX;
                    if ($mColX instanceof \Model\Pawn) {
                      echo '</span>';
                    }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>