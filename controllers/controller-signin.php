<?php
session_start();
require_once '../config.php';
require_once '../models/Utilisateur.php';
require_once '../models/Entreprise.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    if (isset($_POST['usermail'])) {
        if (empty($_POST['usermail'])) {
            $errors['usermail'] = 'Entre une adresse mail';
        }
    }

    if (isset($_POST['password'])) {
        if (empty($_POST['password'])) {
            $errors['password'] = 'Entrez votre Mot de passe';
        }
    }

    if (empty($errors)) {
        //Test des connexions
        if(!Utilisateur::checkMailExists($_POST['usermail'])) {
            $errors['usermail'] = 'utilisateur Inconnu';
        } else {
            //récupération des infos du profil utilisateur
            $userinfos = Utilisateur::getInfos($_POST['usermail']);
            //On vérifie si l'utilisateur est authorisé a se connecter
            if($userinfos['USR_VALID'] == 0){
                echo "Votre compte a été suspendu.";
            } else {
                if (password_verify($_POST['password'], $userinfos['USR_PASS'])){
                    // ? si le mdp est bon, on passe les toutesinfos dans la session
                    $_SESSION['user'] = $userinfos;
                    header("Location: ./controller-home.php");
                } else {
                    $errors['password'] = 'mauvais mdp';
                }
            }
        }
    }
}
include '../views/view-signin.php';
