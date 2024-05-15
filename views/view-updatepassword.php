<?php
// Header
include '../views/templates/header.php';
?>
<div class="container">
    <h2 class="pagetitle">Modifier Mot de passe</h2>
    <form action="../controllers/controller-profiel.php" method="POST" class="form" enctype="multipart/form-data">
        <div class="formlines">
            <label for="oldpass">Ancien mot de passe</label>
            <input type="password" class="inputforms" name="olpassword">
            <p class="errortext"></p>
        </div>
        <div class="formlines">
            <label for="oldpass">Nouveau mot de passe</label>
        <input type="password" class="inputforms" name="newpassword">
        <p class="errortext"></p>
        </div>
        <div class="formlines">
            <label for="oldpass">Confirmet votre nouveau mot de passe</label>
            <input type="password" class="inputforms" name="confirmnewpassword">
            <p class="errortext"></p>
        </div>

        <div class="formbuttons">
                <button class="submitbutton" type="submit" name="validate" value="validate">Valider</button>
                <button class="submitbutton" type="submit" name="back">Revenir à l'accueil</button>
        
        </div>
    </form>
<?php
// Footer
include '../views/templates/footer.php'
?>