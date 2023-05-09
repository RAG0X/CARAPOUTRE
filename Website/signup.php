<?php
    // Connexion à la base de données
    $db_host = "172.29.1.21"; // adresse IP du serveur MySQL
    $db_user = "root"; // nom d'utilisateur MySQL
    $db_pass = "1234"; // mot de passe MySQL
    $db_name = "carapoutre"; // nom de la base de données

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$conn) {
        die("La connexion à la base de données a échoué: " . mysqli_connect_error());
    }

    // Traitement du formulaire
    if(isset($_POST['submit'])) {
        // récupération des données
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        
        // convertir la date de naissance dans le bon format
        $birthdate = date_create_from_format("d/m/Y", $_POST["birthdate"]);
        $birthdate_formatted = date_format($birthdate, "Y-m-d");

        $height = mysqli_real_escape_string($conn, $_POST["height"]);
        $weight = mysqli_real_escape_string($conn, $_POST["weight"]);
        $statut = mysqli_real_escape_string($conn, $_POST["statut"]);

        // Insertion des données dans la base de données
        if($statut == 'athlete') {
            $table = 'base_athlete';
        } elseif($statut == 'coach') {
            $table = 'base_coach';
        }

        // Requête d'insertion dans la base de données
$sql = "INSERT INTO base_athlete (username, date_de_naissance, email, taille_cm, poids_kg, password) VALUES ('$username', '$birthdate', '$email', '$height', '$weight', '$password')";

if (mysqli_query($conn, $sql)) {
    echo "Inscription réussie !";
} else {
    echo "Erreur: " . mysqli_error($conn);
}

mysqli_close($conn);
    }

    mysqli_close($conn);
?>
