<?php
    session_start();
    // Connexion à la base de données
    $db_host = "172.29.1.21"; // adresse IP du serveur MySQL
    $db_user = "root"; // nom d'utilisateur MySQL
    $db_pass = "1234"; // mot de passe MySQL
    $db_name = "carapoutre"; // nom de la base de données

    // Création d'une connexion MySQLi
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $_SESSION["connection"] = $conn;

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Récupération des données du formulaire
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];

    // Recherche de l'utilisateur dans la table "base_athlete"
    $stmt = $conn->prepare("SELECT * FROM base_athlete WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result_athlete = $stmt->get_result();

    // Recherche de l'utilisateur dans la table "base_coach"
    $stmt = $conn->prepare("SELECT * FROM base_coach WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result_coach = $stmt->get_result();

    // Vérification si l'utilisateur a été trouvé
    if ($result_athlete->num_rows > 0) {
        // Utilisateur trouvé dans la table "base_athlete"
        $row = $result_athlete->fetch_assoc();
        echo "Bonjour " . $row["username"] . ", vous êtes connecté en tant qu'athlète.";
        
        session_start();
        $_SESSION["username"] = $row["username"];

        header("Location: menu_athlete.php");
        exit();

    } elseif ($result_coach->num_rows > 0) {
        // Utilisateur trouvé dans la table "base_coach"
        $row = $result_coach->fetch_assoc();
        echo "Bonjour " . $row["username"] . ", vous êtes connecté en tant qu'entraîneur.";
    } else {
        // Utilisateur non trouvé
        echo "Adresse e-mail ou mot de passe incorrect.";
    }

    // Fermeture de la connexion à la base de données
    $stmt->close();
    $conn->close();
?>
