<?php
//var_dump($oPlayer);
$oCharacter = $oPlayer->getCharacter();
?>

<div class="text-center w-50 mx-auto">
    <input id="CharacterName" class="form-control" placeholder="Nom du personnage" 
           required value="<?= $oCharacter ? $oCharacter->getName() : ''; ?>" />
</div>

<div class="row">
    <div class="col">
        <span class="player-type <?= ($oCharacter instanceof \Model\Warrior) ? 'active' : ''; ?>" 
              data-class="<?= \Model\Warrior::class; ?>"><?= \Model\Warrior::SYMBOL; ?></span>
        <br />
        <em><?= \Model\Warrior::NAME; ?></em>

        <?php
            if ($oCharacter instanceof \Model\Warrior) {
                include ('templates/character_info.php');
            }
        ?>
    </div>
    <div class="col">
        <span class="player-type <?= ($oCharacter instanceof \Model\Wizard) ? 'active' : ''; ?>"
              data-class="<?= \Model\Wizard::class; ?>"><?= \Model\Wizard::SYMBOL; ?></span>
        <br />
        <em><?= \Model\Wizard::NAME; ?></em>

        <?php
            if ($oCharacter instanceof \Model\Wizard) {
                include ('templates/character_info.php');
            }
        ?>
    </div>
</div>