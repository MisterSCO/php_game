<?php
    foreach ( $oGame->getBoard() as $iY => $aLineY ): ?>
    <div class="row justify-content-center">
        <?php foreach ( $aLineY as $iX => $mColX ):
            $bCellMovable = $aGameInfo && in_array([$iX, $iY], $aGameInfo['moves']);
            $bCellCharacter = $mColX instanceof \Model\Character;
            ?>
            <div    class="col-auto border text-center cell
                        <?= $bCellMovable ? 'movable-cell' : ''; ?>
                        <?= $bCellCharacter ? 'character-cell' : ''; ?>" 
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