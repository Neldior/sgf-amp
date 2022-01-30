<?php
    //Définition des paramètres
    define("BD", "pgsql:host=localhost;port=5432;dbname=filrouge");
    define("USER", "stag");
    define("PWD", "stag");
    
    //Etablissement de la connexion
    try {
        function connectbd() {
            $con = new PDO(BD, USER, PWD);
            $con -> exec("SET NAMES 'UTF8'");
            $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        }
        /*if (connectbd()) echo "Connexion réussie !";
        else echo "Connexion échouée !";*/
        
    } catch (PDOException $e) {
        die($e->getMessage());
    } finally {
        //if ($con) $con = null;
    }


