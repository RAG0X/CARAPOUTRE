<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["user_type"] !== "coach"){
    header("Location: login.html");
    exit();
}

// Connexion à la base de données
$db_host = "172.29.1.21"; // adresse IP du serveur MySQL
$db_user = "root"; // nom d'utilisateur MySQL
$db_pass = "1234"; // mot de passe MySQL
$db_name = "carapoutre"; // nom de la base de données

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
    while($row = mysqli_fetch_assoc($result)) {
        $email = $row["email"];
        $password = $row["password"];
    }
} else {
    echo "0 results";
}

$email_athlete1 = isset($_POST['email_athlete_1']) ? $_POST['email_athlete_1'] : '';
$sql = "SELECT ID FROM table_athlete WHERE email='$email_athlete1'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id_athlete1 = $row["ID"];

    $sql = "SELECT email FROM table_athlete WHERE ID='$id_athlete1'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email_athlete1 = $row["email"];
    }
} else {
    $id_athlete = null;
}

// Utilisation de $id_athlete en vérifiant qu'il est défini
if(isset($id_athlete1)) {
    $sql = "SELECT email FROM table_athlete WHERE ID='$id_athlete1'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email_athlete1 = $row["email"];
    }
}



if(isset($_POST["update-info"])){
    $username = $_SESSION["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Mettre à jour les informations dans la table base_coach
    $update_query = "UPDATE base_coach SET email='$email', password='$password', Id_athlete1='$id_athlete1' WHERE username='$username'";
    if(mysqli_query($conn, $update_query)){
        // Mettre à jour les informations de la session
        $_SESSION["email"] = $email;
        header("Location: menu_coach_parametres.php");
        exit();
    }
}    

if(isset($_POST["delete-account"])){
    $username = $_SESSION["username"];

    // Afficher une boîte de dialogue de confirmation avant de supprimer l'utilisateur
    echo "<script>
    var confirmation = confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');
    if(confirmation)
    {
        window.location.href='delete-account.php';
    }
    </script>";
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE-edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARAPOUTRE - Paramètres</title>
    <link rel="stylesheet" href="style.css"/>
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
                <h1 id="welcome-message">Besoin de changement <?php echo $_SESSION["username"]; ?> ?</h1>
            </div>
            <div class="contenu-menu">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="row">
                    <div class="column">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" value="<?php echo $email ?>" required>
                    </div>
                    <div class="column">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" value="<?php echo $password ?>" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="column">
                        <label for="athlete1">Athlete n°1</label>
                        <input type="email" id="email_athlete_1" name="email_athlete_1" value="<?php echo $email_athlete1 ?>">
                    </div>
                    <div class="column">
                        <label for="athlete2">Athlete n°2</label>
                        <input type="email" id="email_athlete_2" name="email" placeholder="L'email de votre athlete n°2">
                    </div>
                </div>

                <div class="row">
                    <div class="column">
                        <label for="athlete3">Athlete n°3</label>
                        <input type="email" id="email_athlete_3" name="email" placeholder="L'email de votre athlete n°3">
                    </div>
                    <div class="column">
                        <label for="athlete4">Athlete n°4</label>
                        <input type="email" id="email_athlete_4" name="email" placeholder="L'email de votre athlete n°4">
                    </div>
                </div>

                <div class="row">
                        <button id="update-btn" type="submit" name="update-info">Mettre à jour les informations</button>
                        <button id="delete-btn" type="submit" name="delete-account">Supprimer le compte</button>
                </div>
            </form>
                <button class="button2" id="retour-btn" onclick="history.back()">Retour</button>
            </div>
        </div>
    </div>

    <script>
        const menuHamburger = document.querySelector(".menu-hamburger");
        const navLinks = document.querySelector(".nav-links");

        menuHamburger.addEventListener('click',()=>{
            navLinks.classList.toggle('mobile-menu')
            document.body.classList.toggle('no-scroll')
            window.scrollTo(0,0)
        });
    </script>

    <script>
        const welcomeMessage = document.getElementById("welcome-message");
        welcomeMessage.innerHTML = "Besoin de changement " + "<?php echo $_SESSION['username']; ?>" + " ?";
    </script>
</body>
</html>
