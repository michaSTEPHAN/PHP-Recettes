<?php
    //----------------------------------------------------------    
    // Connection à la BDD
    //----------------------------------------------------------
    try {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=recipes;charset=utf8',
            'root',
            '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
    catch (Exeption $e) {
        die('Erreur : '.$e->getMessage());
    }
?>