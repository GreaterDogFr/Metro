<?php
require_once '../config.php';
require_once '../models/Utilisateur.php';

//On récupère la session
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ./controller-signin.php");
}
// TODO: Vérifier ancien mdp = mdp session user
// TODO: créer nouvelle fonction updatePassword dans model utilisateur
// TODO: Vérifier que la fonctionnalité passe
// TODO: Refaire le css de l'application eco (Ne pas oublier que bootstrap est intégré dans l'appli)
include '../views/view-updatepassword.php';
?>