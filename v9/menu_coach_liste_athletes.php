<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["user_type"] !== "coach") {
    header("Location: login.html");
    exit();
}

// Inclusion du fichier de connexion à la base de données
include "include/server-connect.php";

// Création d'une connexion MySQLi
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Vérification de la connexion
if (!$conn) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

$username = $_SESSION["username"];
$sql = "SELECT * FROM base_coach WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $email = $row["email"];
    $password = $row["password"];
    $id_athlete1 = $row["Id_athlete1"];
    $id_athlete2 = $row["Id_athlete2"];
    $id_athlete3 = $row["Id_athlete3"];
    $id_athlete4 = $row["Id_athlete4"];
} else {
    echo "0 results";
}

// Récupération des usernames des athlètes correspondants aux IDs stockés dans les variables $id_athlete1, $id_athlete2, $id_athlete3, $id_athlete4
$username_athlete1 = getUsernameByAthleteId($conn, $id_athlete1);
$username_athlete2 = getUsernameByAthleteId($conn, $id_athlete2);
$username_athlete3 = getUsernameByAthleteId($conn, $id_athlete3);
$username_athlete4 = getUsernameByAthleteId($conn, $id_athlete4);

function getUsernameByAthleteId($conn, $athleteId)
{
    if (!empty($athleteId)) {
        $sql = "SELECT username FROM base_athlete WHERE id='$athleteId'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row["username"];
        }
    }
    return "";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARAPOUTRE - Paramètres</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar">
        <a href="index.html"><img src="img/logo-carapoutre.png" alt="logo Carapoutre" class="logo"></a>
        <div class="nav-links">
            <ul>
                <li><a href="index.html">Déconnexion</a></li>
            </ul>
        </div>
        <img src="img/menu-btn.png" alt="menu hamburger" class="menu-hamburger">
    </nav>
    <div class="menu">
        <div class="wrap-menu">
            <h1 id="welcome-message">Prêt à faire suer tes athlètes <?php echo $_SESSION["username"]; ?> ?</h1>
        </div>
        <div class="contenu-menu">
            <div class="colonne-bloc-athlete">
                <?php if (!empty($username_athlete1)): ?>
                    <div class="bloc-athlete" id="bloc-athlete1">
                        <!-- Contenu du bloc-athlete1-->
                        <h2 class="titre-bloc-athlete"><?php echo $username_athlete1 ?></h2>
                        <button class="button2" id="access-page-athlete-btn">Accéder à son profil</button>
                    </div>
                <?php endif; ?>
                <?php if (!empty($username_athlete2)): ?>
                    <div class="bloc-athlete" id="bloc-athlete2">
                        <!-- Contenu du bloc-athlete2-->
                        <h2 class="titre-bloc-athlete"><?php echo $username_athlete2 ?></h2>
                        <button class="button2" id="access-page-athlete-btn">Accéder à son profil</button>
                    </div>
                <?php endif; ?>
                <?php if (!empty($username_athlete3)): ?>
                    <div class="bloc-athlete" id="bloc-athlete3">
                        <!-- Contenu du bloc-athlete3-->
                        <h2 class="titre-bloc-athlete"><?php echo $username_athlete3 ?></h2>
                        <button class="button2" id="access-page-athlete-btn">Accéder à son profil</button>
                    </div>
                <?php endif; ?>
                <?php if (!empty($username_athlete4)): ?>
                    <div class="bloc-athlete" id="bloc-athlete4">
                        <!-- Contenu du bloc-athlete4-->
                        <h2 class="titre-bloc-athlete"><?php echo $username_athlete4 ?></h2>
                        <button class="button2" id="access-page-athlete-btn">Accéder à son profil</button>
                    </div>
                <?php endif; ?>
            </div>
            <button class="button2" id="retour-btn" onclick="window.location.href='menu_coach.php'">Retour</button>
        </div>
    </div>

    <script src="js/menu-hamburger.js"></script>
</body>
</html>