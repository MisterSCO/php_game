<?php

echo '<div class="card card-abso">
    <div class="card-head bg-secondary text-white">'. $oPlayer->getCharacter()->getName()  .'</div>
    <div class="card-body">
        Santé
        <div class="progress">
            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <br>
        Force
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <br>
        Mana
        <div class="progress">
            <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</div>';

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