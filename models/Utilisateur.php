<?php

class Utilisateur
{
    /**
         * Methode permettant de crée un utilisateur
         * @param int $validate Permet à l'admin de valider l'utilisateur par default 1
         * @param string $firstname Nom de l'utilisateur
         * @param string $lastname prenom de l'utilisateur
         * @param string $username Pseudo de l'utilisateur
         * @param string $usermail Email de l'utilisateur
         * @param string $password Password de l'utilisateur
         * @param string $birthday DDN de l'utilisateur
         * @param string $password Password de l'utilisateur
         * @param string $enterprise entreprise de l'utilisateur
         *
         * @return void
         */

    public static function create($validate, $firstname, $lastname, $username, $usermail, $bday, $password, $enterprise)
    {
        $database = new PDO('mysql:host=localhost;dbname=' . DBNAME . ';charset=utf8', DBUSERNAME, DBPASSWORD);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         //  value (:value = marqueur nominatif)
        $sql = 'INSERT INTO `user__usr` (`USR_VALID`, `USR_FNAME`, `USR_LNAME`, `USR_UNAME`, `USR_MAIL`, `USR_BDAY`, `USR_PASS`, `ENT_ID`) 
        VALUES (:VALID, :FNAME, :LNAME, :UNAME, :UMAIL, :BDAY, :PASS , :ENT_ID)';
        //je prepare ma requete pour eviter les injection sql,  $bdd appelle la methode prepare 
        $query = $database->prepare($sql);
         //avec bindValue permet de mettre directement des valeurs sans crée de variable 
        $query->bindValue(':VALID',1, PDO::PARAM_INT); 
        $query->bindValue(':FNAME', htmlspecialchars($_POST['firstname']), PDO::PARAM_STR);
        $query->bindValue(':LNAME', htmlspecialchars($_POST['lastname']),PDO::PARAM_STR);
        $query->bindValue(':UNAME', htmlspecialchars($_POST['username']),PDO::PARAM_STR);
        $query->bindValue(':UMAIL', $_POST['usermail'], PDO::PARAM_STR);
        $query->bindValue(':BDAY', $bday);
        $query->bindValue(':PASS', password_hash($_POST['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
        $query->bindValue(':ENT_ID',$_POST['enterprise'], PDO::PARAM_INT); 

        try {
            $query->execute();
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    /**
     * Methode permettant de récupérer les informations d'un utilisateur avec son mail comme paramètre
     * 
     * @param string $usermail Adresse mail de l'utilisateur
     * 
     * @return bool
     */

    public static function checkMailExists(string $usermail): bool
    {
        // le try and catch permet de gérer les erreurs, nous allons l'utiliser pour gérer les erreurs liées à la base de données
        try {
            // Création d'un objet $database selon la classe PDO
            $database = new PDO("mysql:host=localhost;dbname=" . DBNAME, DBUSERNAME, DBPASSWORD);

            // stockage de ma requete dans une variable
            $sql = "SELECT * FROM `user__usr` WHERE `USR_MAIL` = :mail";

            // je prepare ma requête pour éviter les injections SQL
            $query = $database->prepare($sql);

            // on relie les paramètres à nos marqueurs nominatifs à l'aide d'un bindValue
            $query->bindValue(':mail', $usermail, PDO::PARAM_STR);

            // on execute la requête
            $query->execute();

            // on récupère le résultat de la requête dans une variable
            $result = $query->fetch(PDO::FETCH_ASSOC);

            // on vérifie si le résultat est vide car si c'est le cas, cela veut dire que le mail n'existe pas
            if (empty($result)) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }

    /**
     * Méthode permettant de vérifier que l'username existe déjà
     * 
     * @param string $username Pseudo de l'utilisateur
     * 
     * @return bool
     */
    public static function checkUsernameExists(string $username): bool
    {
        try{
            $database = new PDO("mysql:host=localhost;dbname=" . DBNAME, DBUSERNAME, DBPASSWORD);
            $sql = "SELECT * FROM `user__usr` WHERE `USR_UNAME` = :uname";
            $query = $database->prepare($sql);
            $query->bindValue(':uname', $username, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }

    /**
     * Methode permettant de récupérer les infos d'un utilisateur avec son mail comme paramètre
     * 
     * @param string $usermail Adresse mail de l'utilisateur
     * 
     * @return array Tableau associatif contenant les infos de l'utilisateur
     */

    public static function getInfos(string $usermail): array
    {
        try {
            // Création d'un objet $database selon la classe PDO
            $database = new PDO("mysql:host=localhost;dbname=" . DBNAME, DBUSERNAME, DBPASSWORD);

            // stockage de ma requete dans une variable
            $sql = "SELECT * FROM `user__usr` NATURAL JOIN `enterprise__ent` WHERE `USR_MAIL` = :mail";

            // je prepare ma requête pour éviter les injections SQL
            $query = $database->prepare($sql);

            // on relie les paramètres à nos marqueurs nominatifs à l'aide d'un bindValue
            $query->bindValue(':mail', $usermail, PDO::PARAM_STR);

            // on execute la requête
            $query->execute();

            // on récupère le résultat de la requête dans une variable
            $result = $query->fetch(PDO::FETCH_ASSOC);

            // on retourne le résultat
            return $result;
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }

    /**
     * Méhode permettant de modifier un user
     * 
     *@param int $userid id de l'utilisateur
     *@param string $userfname prénom de l'utilisateur
     *@param string $userlname nom de famille de l'utilisateur
     *@param string $useruname pseudo de l'utilisateur
     *@param string $usermail date de naissance de l'utilisateur
     *@param string $userdesc description de l'utilisateur
     *@param string $userpass mot de passe de l'utilisateur
     *@param string $userpicture photo de profil de l'utilisateur
     *@param int $entid id de l'entreprise lié à l'utilisateur 
     * 
     * @return void
     */
    public static function update($userid,$userfname,$userlname, $useruname,$userbday,$usermail ,$userdesc,$userpass,$userpicture, $entid)
    {
        $database = new PDO('mysql:host=localhost;dbname=' . DBNAME . ';charset=utf8', DBUSERNAME, DBPASSWORD);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'UPDATE `user__usr` SET USR_FNAME = :USR_FNAME, USR_LNAME = :USR_LNAME, USR_UNAME =:USR_UNAME, USR_BDAY = :USR_BDAY , 
        USR_MAIL = :USR_MAIL ,USR_PASS = :USR_PASS , USR_PIC = :USR_PIC ,USR_DSC = :USR_DSC, ENT_ID = :ENT_ID
        WHERE USR_ID = :USR_ID';

        $query = $database->prepare($sql);

        $query->bindValue(':USR_ID', $userid, PDO::PARAM_INT);
        $query->bindValue(':USR_FNAME', htmlspecialchars($userfname), PDO::PARAM_STR);
        $query->bindValue(':USR_LNAME', htmlspecialchars($userlname), PDO::PARAM_STR );
        $query->bindValue(':USR_UNAME', htmlspecialchars($useruname), PDO::PARAM_STR );
        $query->bindValue(':USR_BDAY', $userbday);
        $query->bindValue(':USR_MAIL', $usermail, PDO::PARAM_STR );
        $query->bindValue(':USR_DSC', $userdesc, PDO::PARAM_STR );
        $query->bindValue(':USR_PASS', password_hash($userpass,PASSWORD_DEFAULT), PDO::PARAM_STR );
        $query->bindValue(':USR_PIC', $userpicture, PDO::PARAM_STR );
        $query->bindValue(':ENT_ID', $entid, PDO::PARAM_INT);

        try {
            $query->execute();
            echo 'user modifié avec succès !';
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    /**
     * Méthode visant a supprimer l'utilisateur de la base de données
     * 
     * @param int $userid
     */
    public static function delete($userid)
    {
        try {
            $database = new PDO('mysql:host=localhost;dbname=' . DBNAME . ';charset=utf8', DBUSERNAME, DBPASSWORD);
            $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $sql = 'DELETE FROM `user__usr` WHERE USR_ID = :USR_ID ';
    
            $query = $database->prepare($sql);
    
            $query->bindValue(':USR_ID', $userid, PDO::PARAM_INT);
    
            $query->execute();
    
            } catch (PDOException $e) {
                echo 'Erreur : ' . $e->getMessage();
            }
    }
    /**
     * Méthode permettant de supprimer de la base de donnée la photo de profil de l'utilisateur et de la remplacer par null
     * @param int $userid ID de l'utilisateur
     * 
     * @return void
     */
    public static function deleteProfilePicture(int $userid)
    {
            $database = new PDO('mysql:host=localhost;dbname=' . DBNAME . ';charset=utf8', DBUSERNAME, DBPASSWORD);
            $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = 'UPDATE `user__usr` SET USR_PIC = NULL WHERE USR_ID = :USR_ID';
            $query = $database->prepare($sql);
            $query->bindValue(':USR_ID', $userid, PDO::PARAM_INT);
            try {
                $query->execute();
                echo 'photo de profil supprimé avec succès';
            }catch (PDOException $e) {
                echo 'Erreur : ' . $e->getMessage();
            }
    }
}
