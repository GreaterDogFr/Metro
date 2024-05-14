<?php
// Header
include '../views/templates/header.php';
?>
<div class="container" id="#container">
    <h2 class="pagetitle">Inscription</h2>
    <?php if($showform == true){ ?>
        <form action="../controllers/controller-signup.php" method="POST" class="form">
            <div class="formlines">
            <label class="formlabels" for="firstname">Prénom :</label>
            <input type="text" class="inputforms" name="firstname" placeholder="Ex: John" value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>">
            <p class="errorText">
                    <?= isset($errors['firstname']) ? $errors['firstname'] : "";?>
            </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="lastname">Nom :</label>
            <input type="text" class="inputforms" name="lastname" placeholder="Ex: Doe" value="<?= isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>">
            <p class="errorText">
                    <?= isset($errors['lastname']) ? $errors['lastname'] : "";?>
            </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="username">Pseudo :</label>
            <input type="text" class="inputforms" name="username"  placeholder="Ex: Usual_Suspect" value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>">
            <p class="errorText">
                    <?= isset($errors['username']) ? $errors['username'] : "";?>
            </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="email">Adresse mail :</label>
            <input type="email" class="inputforms"  name="usermail" placeholder="Ex: Doe@gmail.com" value="<?= isset($_POST['usermail']) ? $_POST['usermail'] : ''; ?>">
            <p class="errorText">
                    <?= isset($errors['usermail']) ? $errors['usermail'] : "";?>
            </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="birthday">Date de naissance :</label>
            <input type="date" class="inputforms" name="birthday" value="<?= isset($_POST['birthday']) ? $_POST['birthday'] : ''; ?>">
            <p class="errorText">
                    <?= isset($errors['birthday']) ? $errors['birthday'] : "";?>
            </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="entreprise">Entreprise :</label>
            <select class="selectinput" name="enterprise"  >
                <option value=0>Choississez votre entreprise</option>
                <!-- Permet de garder un select séléctionné -->
                <?php 
                foreach ($entreprises as $entreprise){?>
                        <option <?php if(isset($_POST['enterprise']) && ($_POST['enterprise']== $entreprise['ENT_ID'])) echo "selected";?> value=<?=$entreprise['ENT_ID']?>><?=$entreprise['ENT_NAME']?></option>;
                <?php }?>
                
            </select>
            <p class="errorText">
                    <?= isset($errors['enterprise']) ? $errors['enterprise'] : "";?>
                </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="password">Mot de passe :</label>
            <input type="password" class="inputforms" name="password">
            <p class="errorText">
                <?= isset($errors['password']) ? $errors['password'] : "";?>
            </p>
        </div>
        <div class="formlines">
            <label class="formlabels" for="passwordconfirm">Confirmation de mot de passe :</label>
            <input type="password" class="inputforms" name="passwordconfirm">
            <p class="errorText">
                <?= isset($errors['passwordconfirm']) ? $errors['passwordconfirm'] : "";?>
            </p>
        </div>
        <div class="formlinescgu">
            <label class="formlabels" for="cgu">J'accepte les CGU</label>
            <input type="checkbox" name="cgu" <?php if(isset($_POST['cgu'])) echo "checked='checked'"; ?>>
            <p class="errorText">
                <?= isset($errors['cgu']) ? $errors['cgu'] : "";?>
            </p>
        </div>
        
        <button class="submitbutton" type="submit">Valider</button>
    </form>
    
    <div class="signlink">
        <p>Déjà Inscrit ? <a class="signlink" href="../controllers/controller-signin.php"> Connectez-vous !</a></p>
    </div>

    <?php }else{ ?>
        <p>Inscription Réussie, redirection vers l'accueil</p>
    <?php } ?>
</div>
<?php
// Footer
include '../views/templates/footer.php'
?>