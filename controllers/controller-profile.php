<?php
require_once '../config.php';
require_once '../models/Utilisateur.php';
require_once('../models/Entreprise.php');

//On récupère la session
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ./controller-signin.php");
}
// $nonumberpatern = "/[a-zA-ZÀ-ÿ\-]+$/";
$paternSpecChar = '/[\'\/^£$%&*()}{@#~?><>,|=_+¬-]/';

//On récupère les noms d'entreprises
$getentreprises = json_decode(Entreprise::getInfos(),true);
$entreprises = $getentreprises['data'];

$userprofilepicture = $_SESSION['user']['USR_PIC'];
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $errors =  [];
    
    //gérer l'upload des fichiers
    $upploaddir ='../assets/uploads/';
    $targetfile = $upploaddir . basename($_FILES['profilepic']['name']);

    //? Permet de vérifier l'extension de fichier
    $imageFileType = strtolower(pathinfo($targetfile,PATHINFO_EXTENSION));
    $uploadOk= 1;

    if(isset($_POST['back'])){
        header("Location: ./controller-home.php");
    }

    if(isset($_POST['updatepassword'])) {
        header("Location: ./controller-updatepassword.php");
    }


    if (isset($_POST['deleteprofilepicture'])) {
        unlink("../assets/uploads/$userprofilepicture");
        Utilisateur::deleteProfilePicture($_SESSION['user']['USR_ID']) ;
        header("Location: ./controller-home.php");
    }

    if (isset($_POST['firstname'])) { 
        if (preg_match($paternSpecChar, $_POST['firstname'])) {
            $errors['firstname'] = 'Pas de charactère spéciaux';
        } else if (empty($_POST['firstname'])) {
            $errors['firstname'] = 'Entrez votre nom';
        }
    }

    if (isset($_POST['lastname'])) {
        if (preg_match($paternSpecChar, $_POST['lastname'])) {
            $errors['lastname'] = 'Pas de charactère spéciaux';
        } else if (empty($_POST['lastname'])) {
            $errors['lastname'] = 'Entrez votre prénom';
        }
    }

    if (isset($_POST['username'])) {
        if (strlen($_POST['username'])>50) {
            $errors['username'] = 'Maximum 50 charactères';
        } else if (strlen($_POST['username'])<3){
            $errors['username'] = 'Minimum 3 charactères';
        } else if ($_POST['username'] != $_SESSION['user']['USR_UNAME'] && Utilisateur::checkUsernameExists($_POST['username'])){
            $errors['username'] = 'Ce pseudo est déjà utilisée';
        }
    }

    if (isset($_POST['usermail'])) {
        if (!filter_var($_POST['usermail'], FILTER_VALIDATE_EMAIL)) {
            $errors['usermail'] = 'Adresse Mail non valide';
        } else if (empty($_POST['usermail'])) {
            $errors['usermail'] = 'Entre une adresse mail';
        } else if ($_POST['usermail'] != $_SESSION['user']['USR_MAIL'] && Utilisateur::checkMailExists($_POST['usermail'])){
            $errors['usermail'] = 'Cette adresse mail est déjà utilisée';
        }
    }

    if ((isset($_POST['birthday'])) && empty($_POST['birthday'])) {
        $errors['birthday'] = 'Entrez une date';
    } else {
        $userbday = $_POST["birthday"];
    }

    if (isset($_POST['enterprise']) && ($_POST['enterprise'])== "0")
    {
        $errors['enterprise'] = "Choisissez une entreprise";
    }
    
    if (empty($errors) && isset($_POST['validate'])){
        if (isset($_FILES['profilepic']) && $_FILES['profilepic']['size'] > 0) {
            $check = getimagesize($_FILES['profilepic']['tmp_name']);
            if($check !== false) {
                //L'image est dans le bon format
                $uploadOk = 1;
            } else {
                //Le fichier n'est pas une image
                $uploadOk = 0;
            }
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $uploadOk = 0;
        }

        $userid = $_SESSION['user']['USR_ID'];
        $userfname = $_POST['firstname'];
        $userlname = $_POST['lastname'];
        $useruname = $_POST['username'];
        $userbday = $_POST['birthday'];
        $usermail = $_POST['usermail'];
        $userdesc = $_POST['description'];
        
        //Si erreur d'upload, on récupère l'ancien statut de photo de profil
        if ($uploadOk == 0) {
            $userpicture = $_SESSION['user']['USR_PIC'];
        } else {
            // Sinon, upload dans le projet, et on continue normalement notre requête SQL
            move_uploaded_file($_FILES['profilepic']['tmp_name'], $targetfile);
            $userpicture = $_FILES['profilepic']['name'];
        }
        $entid = $_POST['enterprise'];

        Utilisateur::update($userid,$userfname,$userlname, $useruname,$userbday,$usermail,$userdesc,$userpicture, $entid);
        Header("Location: ./controller-home.php");
    }
}

include '../views/view-profile.php';
?>