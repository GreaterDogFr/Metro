<?php
require_once '../config.php';
require_once '../models/Utilisateur.php';
require_once '../models/Travel.php';
require_once '../models/Transport.php';

//Session
session_start();
if(!isset($_SESSION['user']))
{
    header("Location: ./controller-signin.php");
}

$gettransports = json_decode(Transport::getTransports(),true);
$transports = $gettransports['data'];

$todaysdate = date('Y-m-d');

$travelid = $_GET['tvl'];
$travelinfos = Travel::getTravelInfoById($travelid);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $errors = [];
    
    if ((isset($_POST['traveldate'])) && empty($_POST['traveldate'])) {
        $errors['traveldate'] = 'Entrez une date';
    }

    if ((isset($_POST['traveltime'])) && empty($_POST['traveltime'])) {
        $errors['traveltime'] = 'Entrez une durée de voyage';
    }

    if ((isset($_POST['traveldistance'])) && empty($_POST['traveldistance'])) {
        $errors['traveldistance'] = 'Entrez une distance de voyage';
    }

    if ((isset($_POST['traveltype'])) && $_POST['traveltype']=="0" ) {
        $errors['traveltype'] = 'Sélectionnez un moyen de transport';
    }
    if(isset($_POST['back'])){
        header("Location: ./controller-home.php");
    }
    
    
    //? Si aucune erreur
    if (empty($errors)){
        $traveldate = $_POST['traveldate'];
        $traveltime = $_POST['traveltime'];
        $traveldistance = $_POST['traveldistance'];
        $traveltype = $_POST['traveltype'];
        $travelid = $_GET['tvl'];
        
        Travel::update($travelid,$traveldate,$traveltime,$traveldistance,$traveltype);
        header("Location: ./controller-travelhistory.php");
    }
}
include '../views/view-updatetravel.php';
?>