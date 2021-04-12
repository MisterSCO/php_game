<?php
$oCharacter = $oPlayer->getCharacter();
$aCharacters = $oPlayer->getCharacters();

$bCreatePlayer = true;
if ($aCharacters) {?>
    <strong>Personnages existants</strong>
    <div class="row">
        <?php foreach ($aCharacters as $oChar): ?>
            <div class="col-4">
                <span class="player-type <?= ($oCharacter === $oChar) ? 'active' : ''; ?>"
                      data-class="<?= get_class($oChar); ?>" data-id="<?= $oChar->getId(); ?>">
                    <?= $oChar::SYMBOL; ?>
                </span>
                <br />
                <em><?= $oChar->getName() ?></em>

                <?php
                if ($oCharacter === $oChar) {
                    $bCreatePlayer = false;
                    include ('templates/character_info.php');
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>

    <hr class="w-50 mx-auto"/>
<?php } ?>

<strong>Créer un nouveau personnage</strong>
<div class="text-center w-50 mx-auto my-3">
    <input id="CharacterName" class="form-control" placeholder="Nom du personnage"
           required value="<?= $oCharacter ? $oCharacter->getName() : ''; ?>" />
</div>

<div class="row">
    <div class="col">
        <span class="player-type <?= ($bCreatePlayer && $oCharacter instanceof \Model\Warrior) ? 'active' : ''; ?>"
              data-class="<?= \Model\Warrior::class; ?>" data-id="">
            <?= \Model\Warrior::SYMBOL; ?>
        </span>
        <br />
        <em><?= \Model\Warrior::NAME; ?></em>

        <?php
            if ($bCreatePlayer && $oCharacter instanceof \Model\Warrior) {
                include ('templates/character_info.php');
            }
        ?>
    </div>
    <div class="col">
        <span class="player-type <?= ($bCreatePlayer && $oCharacter instanceof \Model\Wizard) ? 'active' : ''; ?>"
              data-class="<?= \Model\Wizard::class; ?>" data-id="">
            <?= \Model\Wizard::SYMBOL; ?>
        </span>
        <br />
        <em><?= \Model\Wizard::NAME; ?></em>

        <?php
            if ($bCreatePlayer && $oCharacter instanceof \Model\Wizard) {
                include ('templates/character_info.php');
            }
        ?>
    </div>
</div>
