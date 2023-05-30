<?php
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: login.html");
        exit();
    }
    
    // Inclusion du fichier de connexion à la base de données
    include "include/server-connect.php";

    // Création d'une connexion MySQLi
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }
    
    $username = $_SESSION["username"];

        // Supprimer l'utilisateur de la table base_athlete
        $delete_query = "DELETE FROM base_athlete WHERE username='$username'";
        if(mysqli_query($conn, $delete_query)){
            // Déconnexion de l'utilisateur
            session_destroy();
            header("Location: delete-account.html");
            exit();
        }
?>