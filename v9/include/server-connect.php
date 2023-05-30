<?php
$db_host = "172.29.1.26"; // adresse IP du serveur MySQL
$db_user = "root"; // nom d'utilisateur MySQL
$db_pass = "1234"; // mot de passe MySQL
$db_name = "carapoutre"; // nom de la base de données

// Création d'une connexion mysqli
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Vérification de la connexion
if (mysqli_connect_errno()) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}
?>