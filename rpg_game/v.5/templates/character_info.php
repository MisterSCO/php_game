<?php $iRatio = $oCharacter->getHealth()/$oCharacter::MAX_HEALTH*100; ?>
<div class="mb-3">
    <strong>Santé</strong>
    <div class="progress my-3">
        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?= $iRatio; ?>%"
                    aria-valuenow="<?= $oCharacter->getHealth(); ?>" 
                    aria-valuemin="0" 
                    aria-valuemax="<?= $oCharacter::MAX_HEALTH; ?>">
        </div>
    </div>
    <em><?= $oCharacter->isDead() ? 0 : $oCharacter->getHealth(); ?> points de vie</em>
</div>

<?php $iRatio = $oCharacter->getStrength()/$oCharacter::MAX_STRENGTH*100; ?>
<div class="mb-3">
    <strong>Force</strong>
    <div class="progress my-3">
        <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: <?= $iRatio; ?>%"
                    aria-valuenow="<?= $oCharacter->getStrength(); ?>" 
                    aria-valuemin="0" 
                    aria-valuemax="<?= $oCharacter::MAX_STRENGTH; ?>">
        </div>
    </div>
    <em><?= $oCharacter->getStrength(); ?> points de force</em>
</div>

<?php if ($oCharacter instanceof \Model\Wizard):
    $iRatio = $oCharacter->getMagic()/$oCharacter::MAX_MAGIC*100; ?>
    <div class="mb-3">
        <strong>Magie</strong>
        <div class="progress my-3">
            <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: <?= $iRatio; ?>%"
                    aria-valuenow="<?= $oCharacter->getMagic(); ?>" 
                    aria-valuemin="0" 
                    aria-valuemax="<?= $oCharacter::MAX_MAGIC; ?>">
            </div>
        </div>
        <em><?= $oCharacter->getMagic(); ?> points de magie</em>
    </div>
<?php endif; ?>