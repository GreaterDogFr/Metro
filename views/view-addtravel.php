<?php
// Header
include '../views/templates/header.php';
?>
<div class="container">

    <h2 class="pagetitle">Ajouter un trajet</h2>
    <form action="../controllers/controller-addtravel.php" method="POST" class="form">
    <div class="formlines">
        <label class="formlabels" for="traveldate">Date du voyage</label>
        <input type="date" name="traveldate" class="traveldate"  value="<?= isset($_POST['traveldate']) ? $_POST['traveldate'] : ''; ?>">
        <p class="errorText">
            <?= isset($errors['traveldate']) ? $errors['traveldate'] : "";?>
        </p>
    </div>

    <div class="formlines">
        <label class="formlabels" for="traveltime">Durée du voyage (heures:minutes)</label>
        <input type="time" name="traveltime" class="traveltime" value="<?= isset($_POST['traveltime']) ? $_POST['traveltime'] : ''; ?>">
        <p class="errorText">
            <?= isset($errors['traveltime']) ? $errors['traveltime'] : ""; ?>
        </p>
    </div>
    
    <div class="formlines">
        <label class="formlabels" for="traveldistance">Distance parcourue(en km)</label>
        <input type="number" name="traveldistance"  class="traveldistance"  value="<?= isset($_POST['traveldistance']) ? $_POST['traveldistance'] : ''; ?>"">
        <p class="errorText">
            <?= isset($errors['traveldistance']) ? $errors['traveldistance'] : ""; ?>
        </p>
    </div>
    
    <div class="formlines">
        <label class="formlabels" for="traveltype">Moyen de transport</label>
        <select name="traveltype" class="selectinput">
            <option value="0">Choississez votre moyen de transport</option>
            <!-- Permet de garder un select séléctionné -->
            <?php
            foreach($transports as $transport){
                ?>
                <option <?php if(isset($_POST['traveltype']) && $_POST['traveltype'] == $transport['TRA_ID']) echo "selected" ?> class="traveltime" value=<?=$transport['TRA_ID']?>><?=$transport['TRA_NAME']?></option>
            <?php }?>
        </select>
        <p class="errorText">
                <?= isset($errors['traveltype']) ? $errors['traveltype'] : ""; ?>
            </p>
        </div>

        <div class="formbuttons">
            <button class="submitbutton" type="submit">Valider</button>
            <button class="submitbutton" type="submit" name="back">Revenir à l'accueil</button>
        </div>
</form>
</div>
<?php
// Footer
include '../views/templates/footer.php'
?>