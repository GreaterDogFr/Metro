<?php
class Transport
{
    /**
     *
     */
    public static function getTransports(): string
    {
        try {
            // Création d'un objet $database selon la classe PDO
            $database = new PDO("mysql:host=localhost;dbname=" . DBNAME, DBUSERNAME, DBPASSWORD);

            // stockage de ma requete dans une variable
            $sql = "SELECT * FROM `transportation__tra`";

            // je prepare ma requête pour éviter les injections SQL
            $query = $database->prepare($sql);

            // on execute la requête
            $query->execute();

            // on récupère le résultat de la requête dans une variable
            $status = 'Success';
            $message = 'Transport recuperees avec succes';
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            $array = ["status" =>$status, "message" => $message, "data" => $data];

            $result = json_encode($array, JSON_PRETTY_PRINT);
            // on retourne le résultat
            return $result;
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }
}
