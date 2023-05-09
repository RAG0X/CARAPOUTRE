<?php
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: login.html");
        exit();
    }
    
    // Connexion à la base de données
    $db_host = "172.29.1.21"; // adresse IP du serveur MySQL
    $db_user = "root"; // nom d'utilisateur MySQL
    $db_pass = "1234"; // mot de passe MySQL
    $db_name = "carapoutre"; // nom de la base de données

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