<?php 
session_start();
session_destroy(); 
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Index.css" />
    <link rel="stylesheet" href="~/lib/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="~/css/site.css" />
    <title>Connexion</title>
</head>
<body>
    <div id="box" style="width: 348px;margin-top: 243px;height: 275px;">
    <form method="post" action="/Epoka/GetIdentifiant.php">
            <div id="titreConnexion">
                <h1> Connexion </h1>
            </div>
            <div id="utilisateur">
                <input type="text" name="Login" id="Login" placeholder="Identifiant" />
            </div>
            <div id="motDePasse">
                <input type="password" name="Pwd" id="Pwd" placeholder="Mot de passe" required />
                <div class="password-icon">
                    <i data-feather="eye"></i>
                    <i data-feather="eye-off"></i>
                </div>
            </div>
            <div id="valider">
                <input class="submit" type="submit" value="Connexion" />
            </div>
            <?php
                if(isset($_GET['message'])){
                echo($_GET['message']);
                }
            ?>
        </form>
    </div>
</body>
</html>



    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
        const eye = document.querySelector(".feather-eye");
        const eyeoff = document.querySelector(".feather-eye-off");
        const passwordField = document.querySelector("input[type=password]");
        eye.addEventListener("click", () => {
            eye.style.display = "none";
            eyeoff.style.display = "block";
            passwordField.type = "text";
        });

        eyeoff.addEventListener("click", () => {
            eyeoff.style.display = "none";
            eye.style.display = "block";
            passwordField.type = "password";
        });


    </script>

