const welcomeMessage = document.getElementById("welcome-message");
welcomeMessage.innerHTML = "Besoin de changement " + "<?php echo $_SESSION['username']; ?>" + " ?";