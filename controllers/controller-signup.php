<?php
require_once('../config.php');
require_once('../models/Utilisateur.php');
require_once('../models/Entreprise.php');

$nonumberpatern = '/^[0-9]+$/';
$paternSpecChar = '/[\'\/^£$%&*()}{@#~?><>,|=_+¬]/';

//On récupère les noms d'entreprises
$getentreprises = json_decode(Entreprise::getInfos(),true);
$entreprises = $getentreprises['data'];
$showform = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $errors = [];

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
        } else if (Utilisateur::checkUsernameExists($_POST['username'])){
            $errors['username'] = 'Ce Pseudo déjà utilisé';
        }
    }

    if (isset($_POST['usermail'])) {
        if (!filter_var($_POST['usermail'], FILTER_VALIDATE_EMAIL)) {
            $errors['usermail'] = 'Adresse Mail non valide';
        } else if (empty($_POST['usermail'])) {
            $errors['usermail'] = 'Entre une adresse mail';
        } else if (Utilisateur::checkMailExists($_POST['usermail']) == true){
            $errors['usermail'] = "Cette adresse mail est déjà utilisée.";
        }
    }


    if ((isset($_POST['birthday'])) && empty($_POST['birthday'])) {
        $errors['birthday'] = 'Entrez une date';
    } else {
        $bday = $_POST["birthday"];
    }

    if (isset($_POST['enterprise']) && ($_POST['enterprise'])== "0")
    {
        $errors['enterprise'] = "Choisissez une entreprise";
    }

    if (isset($_POST['password'])) {
        if (empty($_POST['password'])) {
            $errors['password'] = 'Entrez votre Mot de passe';
        } else if (strlen($_POST['password']) < 8) {
            $errors['password'] = 'Plus de 8 charactères';
        }
    }

    if (isset($_POST['password']) && (isset($_POST['passwordconfirm']))) {
        if (empty($_POST['passwordconfirm'])) {
            $errors['passwordconfirm'] = 'Confirmez votre mot de passe';
        } else if ($_POST['password'] != $_POST['passwordconfirm']) {
            $errors['passwordconfirm'] = 'Veuillez entrer le même mot de passe';
        }
    }

    if ((!isset($_POST['cgu']))) {
        $errors['cgu'] = 'Veuillez accepter la CGU';
    }  

    // ? Si aucune erreur
    if (empty($errors)){
        $validate = 1;
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $usermail = $_POST['usermail'];
        $bday = $_POST['birthday'];
        $password = $_POST['password'];


        Utilisateur::create($validate, $firstname, $lastname, $username, $usermail, $bday, $password, $enterprise);
        $showform = false;
        header("Refresh:3; url=./controller-home.php");
        
    }
}
include '../views/view-signup.php';
