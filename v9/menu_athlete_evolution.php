<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["user_type"] !== "athlete") {
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
$sql = "SELECT * FROM base_athlete WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $email = $row["email"];
        $password = $row["password"];
        $birthdate = $row["date_de_naissance"];
        $height = $row["taille_cm"];
        $weight = $row["poids_kg"];
    }
} else {
    echo "0 results";
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
            <h1 id="welcome-message">Je vois que ça évolue <?php echo $_SESSION["username"]; ?> !</h1>
        </div>
        <div class="contenu-menu" id="contenu-menu-suivi">
            <div class="colonne-bloc-suivi">
                <div class="bloc-recap" id="bloc-recap">
                    <img src="img/stats-icon.png" alt="logo statistique" class="logo-stats">
                    <h2 class="titre-bloc-suivi-score">Votre score : 125 </h2>
                    <h2 class="titre-bloc-suivi-classifications">Elite</h2>
                </div>
                <div class="bloc-suivi-bestperfs" id="bloc-suivi-poids">
                    <h2 class="titre-bloc-suivi-rp">Votre poids</h2>
                    <img src="img/pese-personne.png" alt="pese personne" class="pese-personne">
                    <h2 class="titre-bloc-suivi-rptractionleste-valeurs">12.5<span style="font-size: 13.5px; font-weight: normal;">kg</span></h2>
                </div>
                <div class="bloc-suivi-bestperfs" id="bloc-suivi-force">
                    <h2 class="titre-bloc-suivi-rp">RP Traction lesté</h2>
                    <img src="img/pullup-icon.png" alt="logo pullup" class="logo-pullup">
                    <h2 class="titre-bloc-suivi-rptractionleste-valeurs"><span style="font-weight: normal;">+</span>12.5<span style="font-size: 13.5px; font-weight: normal;">kg</span></h2>
                </div>
                <div class="bloc-suivi-bestperfs" id="bloc-suivi-bestperfs-1">
                    <h2 class="titre-bloc-suivi-rp">RP Traction lesté</h2>
                    <img src="img/pullup-icon.png" alt="logo pullup" class="logo-pullup">
                    <h2 class="titre-bloc-suivi-rptractionleste-valeurs"><span style="font-weight: normal;">+</span>12.5<span style="font-size: 13.5px; font-weight: normal;">kg</span></h2>
                </div>
                <div class="bloc-suivi-bestperfs" id="bloc-suivi-bestperfs-2">
                    <h2 class="titre-bloc-suivi-rp">RP Traction lesté</h2>
                    <img src="img/pullup-icon.png" alt="logo pullup" class="logo-pullup">
                    <h2 class="titre-bloc-suivi-rptractionleste-valeurs"><span style="font-weight: normal;">+</span>12.5<span style="font-size: 13.5px; font-weight: normal;">kg</span></h2>
                </div>
            </div>
            <button class="button2" id="retour-btn" onclick="window.location.href='menu_athlete.php'">Retour</button>
        </div>
    </div>

    <!-- Ajout du code pour la fenêtre pop-up -->
    <div class="popup" id="popup1">
        <div class="popup-content">
            <span class="close" id="close">&times;</span>
            <div class="popup-chart">
                <canvas id="popup-chart1"></canvas>
            </div>
        </div>
    </div>

    <!-- Ajout du code pour la deuxième fenêtre pop-up -->
    <div class="popup" id="popup2">
        <div class="popup-content">
            <span class="close" id="close2">&times;</span>
            <div class="popup-chart">
                <canvas id="popup-chart2"></canvas>
            </div>
        </div>
    </div>

    <!-- Ajout du code pour la troisième fenêtre pop-up -->
    <div class="popup" id="popup3">
        <div class="popup-content">
            <span class="close" id="close3">&times;</span>
            <div class="popup-chart">
                <canvas id="popup-chart3"></canvas>
            </div>
        </div>
    </div>

    <!-- Ajout du code pour la quatrième fenêtre pop-up -->
    <div class="popup" id="popup4">
        <div class="popup-content">
            <span class="close" id="close4">&times;</span>
            <div class="popup-chart">
                <canvas id="popup-chart4"></canvas>
            </div>
        </div>
    </div>

    <script src="js/menu-hamburger.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.bundle.min.js"></script>
    <script src="js/athlete-parametres.js"></script>
</body>
</html>