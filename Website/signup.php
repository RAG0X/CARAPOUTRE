<?php
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
    } 
    elseif($statut == 'coach') 
    {
        $table = 'base_coach';
    }

    // Requête d'insertion des données dans la base de données
    $stmt = $conn->prepare("INSERT INTO $table (username, date_de_naissance, email, taille_cm, poids_kg, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $birthdate, $email, $height, $weight, $password);
    $stmt->execute();

    // Vérification si la requête a été exécutée avec succès
    if ($stmt->affected_rows > 0) {
        echo "Inscription réussie !";
        header("Location: signupsuccess.html");
        exit();
    } else {
        echo "Erreur lors de l'inscription : " . $stmt->error;
        header("Location: signupfailed.html");
        exit();
    }

    // Fermeture de la connexion à la base de données
    $stmt->close();
    $conn->close();
?>
