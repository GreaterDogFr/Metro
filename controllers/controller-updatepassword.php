<?php
require_once '../config.php';
require_once '../models/Utilisateur.php';

//On récupère la session
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ./controller-signin.php");
}

// TODO: Refaire le css de l'application eco (Ne pas oublier que bootstrap est intégré dans l'appli)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = [];

    if(isset($_POST['back'])){
        header("Location: ./controller-home.php");
    }

    if(password_verify($_POST['oldpassword'],$_SESSION['user']['USR_PASS']) == false){
        $errors['oldpassword'] = "Mauvais Mot de passe";
    }

    if (isset($_POST['newpassword'])) {
        if (empty($_POST['newpassword'])) {
            $errors['newpassword'] = 'Entrez votre Mot de passe';
        } else if (strlen($_POST['newpassword']) < 8) {
            $errors['newpassword'] = 'Plus de 8 charactères';
        }
    }

    if (isset($_POST['newpassword']) && (isset($_POST['confirmnewpassword']))) {
        if (empty($_POST['confirmnewpassword'])) {
            $errors['confirmnewpassword'] = 'Confirmez votre mot de passe';
        } else if ($_POST['newpassword'] != $_POST['confirmnewpassword']) {
            $errors['confirmnewpassword'] = 'Veuillez entrer le même mot de passe';
        }
    }

    //?SI aucune erreur
    if (empty($errors)) {
        $userid = $_SESSION['user']['USR_ID'];
        $userpassword = $_POST['newpassword'];

        Utilisateur::updatePassword($userid,$userpassword);
        header("Location: url=./controller-home.php");
    }
}

include '../views/view-updatepassword.php';
?>