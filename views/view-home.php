<?php
// Header
include '../views/templates/header.php';

?>
<div class="containerhome">
    <h2 class="pagetitle">Bienvenue <?=$_SESSION['user']['USR_FNAME']?> !</h2>
    <p class="date"><?=$formatteddate?></p>
    <?php if(empty($_SESSION['user']['USR_PIC'])) {?>
        <img src="../assets/img/placeholder.svg" alt="photo de profil" class="profilepicture">
    <?php } else {?>
        <img src="../assets/uploads/<?=$_SESSION['user']['USR_PIC']?>"  alt="photo de profil" class="profilepicture">
    <?php }?>
    <p class="userinfos"> <?=$_SESSION['user']['USR_FNAME'] . ' ' . $_SESSION['user']['USR_LNAME']?></p>
    <p class="userinfos"> <?=$_SESSION['user']['USR_UNAME']?></p>
    <p class="userinfos"> <?=!empty($_SESSION['user']['USR_DSC']) ? $_SESSION['user']['USR_DSC'] : 'C\'est vide ici. Rajoutez une description'?></p>
    <p class="userinfos">Travaille pour <?=$_SESSION['user']['ENT_NAME']?></p>
    <form action="../controllers/controller-home.php" method="POST" class="homebuttons">
        <button class="greenbutton" type="submit" name="profile" value="profile">Modifier votre profil</button>
        <button class="greenbutton" type="submit" name="addtravel" value="addtravel">Ajouter un nouveau trajet</button>
        <button class="greenbutton" type="submit" name="travelhistory" value="travelhistory">Historique des trajets</button>
        <button class="redbutton" onclick='return confirm("Voulez vous vraiment vous déconnecter ?")'  type="submit" name="logout" value="logout" >Se déconnecter</button>
        <button class="redbutton" onclick='return confirm("Attention, vous allez supprimer votre profil, ceci est définit. Continuer ?")'  type="submit" name="delete" value="delete" >Supprimer votre profil</button>
    </form>
</div>
<?php
// Footer
include '../views/templates/footer.php'
?>