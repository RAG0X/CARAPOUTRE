<?php

session_start();

// Inclusion du fichier de connexion à la base de données
include "include/server-connect.php";

// Création d'une connexion mysqli
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Vérification de la connexion
if (mysqli_connect_errno()) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

// Récupération des données du formulaire
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = $_POST["password"];

// Recherche de l'utilisateur dans la table "base_athlete"
$stmt = mysqli_prepare($conn, "SELECT * FROM base_athlete WHERE email = ? AND password = ?");
mysqli_stmt_bind_param($stmt, "ss", $email, $password);
mysqli_stmt_execute($stmt);
$result_athlete = mysqli_stmt_get_result($stmt);

// Recherche de l'utilisateur dans la table "base_coach"
$stmt = mysqli_prepare($conn, "SELECT * FROM base_coach WHERE email = ? AND password = ?");
mysqli_stmt_bind_param($stmt, "ss", $email, $password);
mysqli_stmt_execute($stmt);
$result_coach = mysqli_stmt_get_result($stmt);

// Vérification si l'utilisateur a été trouvé
if (mysqli_num_rows($result_athlete) > 0) {
    // Utilisateur trouvé dans la table "base_athlete"
    $row = mysqli_fetch_assoc($result_athlete);
    $_SESSION["username"] = $row["username"];
    $_SESSION["user_type"] = "athlete";
    header("Location: menu_athlete.php");
    exit();

} elseif (mysqli_num_rows($result_coach) > 0) {
    // Utilisateur trouvé dans la table "base_coach"
    $row = mysqli_fetch_assoc($result_coach);
    $_SESSION["username"] = $row["username"];
    $_SESSION["user_type"] = "coach";
    header("Location: menu_coach.php");
    exit();

} else {
    // Utilisateur non trouvé
    header("Location: loginfailed.html");
}

// Fermeture de la connexion à la base de données
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
