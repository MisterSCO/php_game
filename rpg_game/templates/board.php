<?php 
foreach ($oGame->getBoard() as $iY => $aLineY) : ?>

    <div class="row justify-content-center">
        <?php foreach ($aLineY as $iX => $mColX) : 
            $bCellMov =  $aGameInfo && in_array([$iX,$iY], $aGameInfo['moves']);
            ?>
        
            <div class="col-auto border text-center cell <?= $bCellMov ? 'cell-selected' : '' ?>" data-x="<?= $iX; ?>" data-y="<?= $iY; ?>">
                <?php
                if ($mColX instanceof \Model\Pawn) {
                    $bSelected = false;
                    echo '<span class="' . ($bSelected ? 'selected' : '') . '">';
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