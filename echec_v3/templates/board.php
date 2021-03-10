<?php
foreach ($oGame->getBoard() as $iY => $aLineY) : ?>
    <div class="row justify-content-center">
        <?php foreach ($aLineY as $iX => $mColX) : ?>
            <div class="col-auto border text-center cell" data-x="<?= $iX; ?>" data-y="<?= $iY; ?>">
                <?php
                if ($mColX instanceof \Model\Pawn) {
                    $bSelected = $aGameInfo && ($mColX === $aGameInfo['selected_pawn']);
                    echo '<span 
                                class="' . ($bSelected ? 'selected' : '') . '" 
                                style="color: ' . $mColX->getPlayer()->getTeam() . ';"
                            >';

                    /*
                        Solution 2
                        $sClass = '';
                        if ($aGameInfo && ($mColX === $aGameInfo['selected_pawn'])) {
                            $sClass = 'selected-pawn';
                        }
                        echo '<span 
                                class="'. $sClass .'" 
                                style="color: '. $mColX->getPlayer()->getTeam() .';"
                            >';
                        */
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