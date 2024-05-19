<?php
// Header
include '../views/templates/header.php';
?>
<div class="container">
    <h2 class="pagetitle">Modifier <span class="welcomeyellow">Profil</span></h2>
    <form action="../controllers/controller-profile.php" method="POST" class="form" enctype="multipart/form-data">

        <div class="formlines">
            <label class="formalabels" for="profilepicture">Photo de profil :</label>
            <input type="file" name="profilepic" value="profilepic" accept="image/jpeg, image/jpg, image/png">
            <ul>
                <li>N'accepte pas que les fichiers en .jpeg, .jpg, .png.</li>
                <li>Taille max: 2MB.</li>
            </ul>
        </div>
        <div class="formlines">
            <button onclick='return confirm("Voulez vous vraiment supprimer votre photo de profil?")' class="btnupdateprofil" type="submit" name="deleteprofilepicture" value="deleteprofilepicture">Supprimer la photo de profil</button>
        </div>
        <div class="formlines">
            <label class="formlabels" for="firstname">Prénom :</label>
            <input type="text" class="inputforms" name="firstname" placeholder="Ex: John" value="<?= $_SESSION['user']['USR_FNAME']  ?>">
            <p class="errorText">
                    <?= isset($errors['firstname']) ? $errors['firstname'] : "";?>
            </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="lastname">Nom :</label>
            <input type="text" class="inputforms" name="lastname" placeholder="Ex: Doe" value="<?= $_SESSION['user']['USR_LNAME']?>">
            <p class="errorText">
                    <?= isset($errors['lastname']) ? $errors['lastname'] : "";?>
            </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="username">Pseudo :</label>
            <input type="text" class="inputforms" name="username"  placeholder="Ex: Usual_Suspect" value="<?= $_SESSION['user']['USR_UNAME']?>">
            <p class="errorText">
                    <?= isset($errors['username']) ? $errors['username'] : "";?>
            </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="email">Adresse mail :</label>
            <input type="email" class="inputforms"  name="usermail" placeholder="Ex: Doe@gmail.com" value="<?= $_SESSION['user']['USR_MAIL'] ?>">
            <p class="errorText">
                    <?= isset($errors['usermail']) ? $errors['usermail'] : "";?>
            </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="birthday">Date de naissance :</label>
            <input type="date" class="inputforms" name="birthday" value="<?= $_SESSION['user']['USR_BDAY'] ?>">
            <p class="errorText">
                    <?= isset($errors['birthday']) ? $errors['birthday'] : "";?>
            </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="entreprise">Entreprise :</label>
            <select class="selectinput" name="enterprise">
                <option value=0>Choississez votre entreprise</option>
                <?php 
                foreach ($entreprises as $entreprise){?>
                    <option <?php if($_SESSION['user']['ENT_ID'] == $entreprise['ENT_ID']) echo "selected";?> value=<?=$entreprise['ENT_ID']?>><?=$entreprise['ENT_NAME']?></option>;
                <?php }?>
        </select>

        <p class="errorText">
                <?= isset($errors['enterprise']) ? $errors['enterprise'] : "";?>
        </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="description">Description :</label>
            <textarea type="textarea" class="inputdescription" name="description" maxlength="1000" ><?= $_SESSION['user']['USR_DSC'] ?></textarea>
        </div>
        <div class="formlines">
            <button class="btnupdateprofil" type="submit" name="updatepassword" value="updatepassword">Modifier Mot de passe </button>
        </div>
        
        <div class="formbuttons">
            <button class="submitbutton" type="submit" name="validate" value="validate">Valider</button>
            <button class="submitbutton" type="submit" name="back">Revenir à l'accueil</button>
        </div>
    </form>
</div>
<?php
// Footer
include '../views/templates/footer.php'
?>