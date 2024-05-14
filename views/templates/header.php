<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <nav class="topnav">
        <a class="active" href="../controllers/controller-home.php">EcoChallenge</a>
        <!-- (hidden by default) -->
        <div id="myLinks">
            <!-- //TODO: Conditionner les liens selon l'état de la connection de l'utilisateur -->
            <a href="../controllers/controller-home.php" class="links">Accueil</a>
        </div>
        <!-- //? "javascript:void(0); permet d'éviter un rechargement de page sur le click. -->
        <a href="javascript:void(0);" class="icon" onclick="showMenu()">
            <i class="bi bi-three-dots-vertical"></i>
        </a>
    </nav>