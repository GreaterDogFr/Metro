<?php
require_once '../config.php';
require_once '../models/Utilisateur.php';
require_once '../models/travel.php';
//Récupération de la date, en français pour les jours de la semaine
$todaysdate = new DateTime('now', new DateTimeZone('Europe/Paris'));
$formatteddate = 
    IntlDateFormatter::formatObject( $todaysdate, 'eeee d MMMM y', 'fr' );

//Session
session_start();
if(!isset($_SESSION['user']))
{
    header("Location: ./controller-signin.php");
}
//On récupère toujours, au cas où il y a eu une modif précédemment
$userinfos = Utilisateur::getInfos($_SESSION['user']['USR_MAIL']);
$_SESSION['user'] = $userinfos;

//Si boutton disconnect
if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: ./controller-signin.php");
}

//boutton profil
if(isset($_POST['profile'])) {
    header("Location: ./controller-profile.php");
}

//boutton ajout trajet
if(isset($_POST['addtravel'])) {
    header("Location: ./controller-addtravel.php");
}
//bouton historique
if(isset($_POST['travelhistory'])) {
    header("Location: ./controller-travelhistory.php");
}

// !Debug bouton delete
if(isset($_POST['delete'])){
    Travel::deleteAllfromUser($_SESSION['user']['USR_ID']);
    Utilisateur::delete($_SESSION['user']['USR_ID']);
    session_destroy();
    Header('Location: ./controller-home.php');
}
include '../views/view-home.php';
?>