<?php
if (isset($aGameInfo['current_player'])) {
    echo '<strong>A toi de jouer, ' . $aGameInfo['current_player'] . '!!!</strong>';
}

?>
<?php $aLetters = range('A', 'Z');  ?>
<div class="row justify-content-center">
    <div class="col-auto">&nbsp;&nbsp;&nbsp;&nbsp;</div>
    <?php for ($i = 0; $i < 8; $i++) {
        echo '<div class="col-auto border" style="width: 100px;"> ' . $aLetters[$i] . '<br> [' . $i . ']</div>';
    } ?>

</div>

<?php
foreach ($oGame->getBoard() as $iY => $aLineY) : ?>

    <div class="row justify-content-center">
        <div class="col-auto border"><?php echo count($aLineY) - $iY . '<br> [' . $iY . ']'; ?></div>
        <?php foreach ($aLineY as $iX => $mColX) : 
            $bCellMov =  $aGameInfo && in_array([$iX,$iY], $aGameInfo['moves']);
            ?>
        
            <div class="col-auto border text-center cell <?= $bCellMov ? 'cell-selected' : '' ?>" data-x="<?= $iX; ?>" data-y="<?= $iY; ?>">
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