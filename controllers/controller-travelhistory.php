<?php
require_once '../config.php';
require_once '../models/Utilisateur.php';
require_once '../models/Travel.php';

//Session
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ./controller-signin.php");
}

$travelhistory = Travel::getInfosByUSRID($_SESSION['user']['USR_ID']);

foreach($travelhistory as $travels) {
    //Format Heure
    $travelhour = strtotime($travels['TVL_TIME']);
    $formattedhour = date("H\hi", $travelhour);
    //Format date
    $traveldate = $travels['TVL_DATE'];
    // Permet de transformer la string précédente en OBJET datetime
    $datetime = DateTime::createFromFormat('Y-m-d', $traveldate, new DateTimeZone('Europe/Paris'));
    // Formatte l'objet créé en français pour tout afficher avec jour de la semaine, jour num, mois, année.
    $formatteddate = IntlDateFormatter::formatObject( $datetime, 'eeee d MMMM y', 'fr' );

}

if(isset($_POST['delete'])){
    $travelid=$_POST['travelid'];
    Travel::delete($travelid);
    header("Refresh:0");
}

if(isset($_POST['add'])){
    header("Location: ./controller-addtravel.php");
}

if(isset($_POST['back'])){
    header("Location: ./controller-home.php");
}

include '../views/view-travelhistory.php';
?>