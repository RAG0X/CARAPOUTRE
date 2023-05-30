<?php
    // Inclusion du fichier de connexion à la base de données
    include "include/server-connect.php";

    // Création d'une connexion MySQLi
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    // Vérification de la connexion
    if (mysqli_connect_errno()) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Récupération des données du formulaire
    $username = $_POST["username"];
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];
    $statut = $_POST["statut"];
    $birthdate = $_POST["birthdate"];
    $height = $_POST["height"];
    $weight = $_POST["weight"];

    if($statut == 'athlete') 
    {
        $table = 'base_athlete';
        $stmt = mysqli_prepare($conn, "INSERT INTO $table (username, date_de_naissance, email, taille_cm, poids_kg, password) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $username, $birthdate, $email, $height, $weight, $password);
    } 
    elseif($statut == 'coach') 
    {
        $table = 'base_coach';
        $stmt = mysqli_prepare($conn, "INSERT INTO $table (username,  email, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
    }

    //Requête d'insertion des données dans la base de données
    mysqli_stmt_execute($stmt);

    // Vérification si la requête a été exécutée avec succès
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Inscription réussie !";
        header("Location: signupsuccess.html");
        exit();
    } else {
        echo "Erreur lors de l'inscription : " . mysqli_stmt_error($stmt);
        /*header("Location: signupfailed.html");*/
        exit();
    }

    // Fermeture de la connexion à la base de données
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
?>