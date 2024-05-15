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

include '../views/view-updatetravel.php';
?>