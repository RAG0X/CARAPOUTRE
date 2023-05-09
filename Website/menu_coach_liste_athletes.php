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
        $id_athlete1 = $row["Id_athlete1"];
        $id_athlete2 = $row["Id_athlete2"];
        $id_athlete3 = $row["Id_athlete3"];
        $id_athlete4 = $row["Id_athlete4"];
        }
    } else {
        echo "0 results";
    }

    // Récupération des mails des athlètes correspondants aux IDs stockés dans les variables $id_athlete1, $id_athlete2, $id_athlete3, $id_athlete4
    $mail_athlete1 = "";
    $mail_athlete2 = "";
    $mail_athlete3 = "";
    $mail_athlete4 = "";

    if ($id_athlete1 != "") {
        $sql = "SELECT email FROM base_athlete WHERE id='$id_athlete1'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $mail_athlete1 = $row["email"];
        }
    }

    if ($id_athlete2 != "") {
        $sql = "SELECT email FROM base_athlete WHERE id='$id_athlete2'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $mail_athlete2 = $row["email"];
       }
    }

    if ($id_athlete3 != "") {
        $sql = "SELECT email FROM base_athlete WHERE id='$id_athlete3'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $mail_athlete3 = $row["email"];
        }
    }

    if ($id_athlete4 != "") {
        $sql = "SELECT email FROM base_athlete WHERE id='$id_athlete4'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $mail_athlete4 = $row["email"];
        }
    }
    
    if(isset($_POST["update-info"])){
        
        $username = $_SESSION["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $id_athlete1 = '';
        $id_athlete2 = '';
        $id_athlete3 = '';
        $id_athlete4 = '';

        // Vérifier si le champ email_athlete_1 est rempli
        if (!empty($_POST["email_athlete_1"])) {
            $email_athlete_1 = $_POST["email_athlete_1"];

            // Effectuer une requête SQL pour récupérer l'ID de l'athlète correspondant à l'email donné
            $sql = "SELECT id FROM base_athlete WHERE email='$email_athlete_1'";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {

                // Vérifier si un ID a été trouvé
                $row = mysqli_fetch_assoc($result);
                $id_athlete1 = $row["id"];
            }
            else{
                $id_athlete1 = null;
            }
        }

        // Répéter pour les champs email_athlete_2, email_athlete_3 et email_athlete_4
        if (!empty($_POST["email_athlete_2"])) {
            $email_athlete_2 = $_POST["email_athlete_2"];
            $sql = "SELECT id FROM base_athlete WHERE email='$email_athlete_2'";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $id_athlete2 = $row["id"];
            }
            else{
                $id_athlete2 = null;
            }
        }

        if (!empty($_POST["email_athlete_3"])) {
            $email_athlete_3 = $_POST["email_athlete_3"];
            $sql = "SELECT id FROM base_athlete WHERE email='$email_athlete_3'";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $id_athlete3 = $row["id"];
            }
            else{
                $id_athlete3 = null;
            }
        }

        if (!empty($_POST["email_athlete_4"])) {
            $email_athlete_4 = $_POST["email_athlete_4"];
            $sql = "SELECT id FROM base_athlete WHERE email='$email_athlete_4'";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $id_athlete4 = $row["id"];
            }
            else{
                $id_athlete4 = null;
            }
        }

        // Mettre à jour les informations dans la table base_coach et base_athlete
        $update_query = "UPDATE base_coach SET email=?, password=?, Id_athlete1=?, Id_athlete2=?, Id_athlete3=?, Id_athlete4=? WHERE username=?";
        $stmt = mysqli_prepare($conn, $update_query);

        // Vérifier si $id_athlete2 est vide ou nulle, et le remplacer par NULL si c'est le cas
        if ($id_athlete1 == "") {
            $id_athlete1 = NULL;
        }


        if ($id_athlete2 == "") {
            $id_athlete2 = NULL;
        }

        if ($id_athlete3 == "") {
            $id_athlete3 = NULL;
        }


        if ($id_athlete4 == "") {
            $id_athlete4 = NULL;
        }

        mysqli_stmt_bind_param($stmt, "sssssss", $email, $password, $id_athlete1, $id_athlete2, $id_athlete3, $id_athlete4, $username);


        // Exécuter la requête préparée
        if(mysqli_stmt_execute($stmt)){
            // Mettre à jour les informations de la session
            $_SESSION["email"] = $email;

            // Mettre à jour les ID des athlètes dans la table base_athlete
            if ($id_athlete1 != "") {
                $sql = "UPDATE base_athlete SET id_coach='$username' WHERE id='$id_athlete1'";
                mysqli_query($conn, $sql);
            }
            if ($id_athlete2 != "") {
                $sql = "UPDATE base_athlete SET id_coach='$username' WHERE id='$id_athlete2'";
                mysqli_query($conn, $sql);
            }
            if ($id_athlete3 != "") {
                $sql = "UPDATE base_athlete SET id_coach='$username' WHERE id='$id_athlete3'";
                mysqli_query($conn, $sql);
            }
            if ($id_athlete4 != "") {
                $sql = "UPDATE base_athlete SET id_coach='$username' WHERE id='$id_athlete4'";
                mysqli_query($conn, $sql);
            }

            // Rediriger vers la page de paramètres du coach après la mise à jour
            header("Location: menu_coach_parametres.php");
            exit();
        } else {
            // Gérer l'erreur de la requête
            echo "Erreur de mise à jour : " . mysqli_error($conn);
        }

        // Fermer la requête préparée et la connexion
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
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
            <h1 id="welcome-message">Prêt à faire suer tes athlètes <?php echo $_SESSION["username"]; ?> ?</h1>
        </div>
        <div class="contenu-menu">
            <div class="bloc-athlete">
                <!-- Contenu du bloc-athlete -->
                <h2 class="titre">[USERNAME]</h2>
                <button class="button3" id="access-page-athlete-btn">Accéder à son profil</button>
            </div>
            <button class="button2" id="retour-btn" onclick="window.location.href='menu_coach.php'">Retour</button>
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
</body>
</html>