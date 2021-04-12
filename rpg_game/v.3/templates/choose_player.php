<?php
//var_dump($oPlayer);
$oCharacter = $oPlayer->getCharacter();
$name="";
if($oCharacter instanceof Model\Character && $oCharacter->getName() !== null)
{
    $name = $oCharacter->getName();
}
// variable = Condition ? c'est vrai : c'est faux
?>

<div class="text-center w-50 mx-auto">
    <p>Nom du joueur: <?php echo $_GET['playername'] ?></p>
    <input id="CharacterName" class="form-control" placeholder="Nom du personnage" value="<?= $name ?>" />
</div>

<div class="row">
    <div class="col classcharac test" data-class="<?= \Model\Warrior::class; ?>">
        <span style="font-size: 4em; cursor: pointer;"><?= \Model\Warrior::SYMBOL; ?></span>
        <br />
        <em><?= \Model\Warrior::NAME; ?></em>

        <?php if (isset($_GET['classcharac']) && $_GET['classcharac'] == \Model\Warrior::class) {
            include('templates/character_info.php');
        } ?>
    </div>
    <div class="col classcharac" data-class="<?= \Model\Wizard::class; ?>">
        <span style="font-size: 4em; cursor: pointer;"><?= \Model\Wizard::SYMBOL; ?></span>
        <br />
        <em><?= \Model\Wizard::NAME; ?></em>

        <?php if (isset($_GET['classcharac']) && $_GET['classcharac'] == \Model\Wizard::class) {
            include('templates/character_info.php');
        } ?>
    </div>
</div>