<?php
// Header
include '../views/templates/header.php';
?>
<div class="container">
    <h2 class="pagetitle">Historique des Trajets</h2>
    <?php
foreach ($travelhistory as $travels) {
    ?>
    <div class="travel">
        <p class="traveltext">Trajet effectué le <span class="formatteddate"><?=$formatteddate?></span> en <?=$formattedhour?> </p>
        <p class="traveltext"><?=$travels['TRA_NAME']?></p>
        <p class="traveltext"><?=$travels['TVL_DISTANCE']?> Km parcourus</p>
        <form action="../controllers/controller-travelhistory.php" class="travelbuttons" method="POST">
            <input type="hidden" name="travelid" value=<?=$travels['TVL_ID']?> >
            <button onclick='return confirm("Supprimer le trajet en date du <?=$formatteddate?> ?")' class="deletetravelhistory" type="submit" id="delete" name="delete" value="delete">Supprimer</button>
        </form>
        <hr>
    </div>
    <?php }?>

    <form action="../controllers/controller-travelhistory.php" method="POST" class="formbuttons">
        <button class="submitbutton" type="submit" name="add" value="add">Ajouter un nouveau trajet</button>
        <button class="submitbutton" type="submit" name="back">Revenir à l'accueil</button>
    </form>
</div>
<?php
// Footer
include '../views/templates/footer.php';
?>