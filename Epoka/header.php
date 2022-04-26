<header class="header">
    <nav class="navbar navbar-expand-lg fixed-top py-3">
        <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
            
        <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="/Projet_Epoka/Epoka" class="nav-link text-uppercase font-weight-bold">Déconnexion <span class="sr-only">(current)</span></a></li>
                <li class="nav-item"><a href="resp.php" class="nav-link text-uppercase font-weight-bold">Valider des missions</a></li>
                <li class="nav-item"><a href="PaiementDesFrais.php" class="nav-link text-uppercase font-weight-bold">Paiement des frais</a></li>
                <li class="nav-item"><a href="Parametrage.php" class="nav-link text-uppercase font-weight-bold">Paramétrage</a></li>
            </ul>
        </div>

        <div>
            <h1 class="titre"> <?php if (!empty($_SESSION["nom"]) || isset($_SESSION["nom"]) || !empty($_SESSION["prenom"]) || isset($_SESSION["prenom"]) || !empty($_SESSION["identifiant"]) || isset($_SESSION["identifiant"]) || !empty($_SESSION["comptable"]) || isset($_SESSION["comptable"])) { 
                echo("Bienvenue " . $_SESSION["nom"] . " " . $_SESSION["prenom"]."</h1>"); 
                }else{
                    echo ("Erreur d'identification ! <a href='/Projet_Epoka/Epoka'> Retour</a></h1>");
                    die();
                } ?>
        </div>
    </nav>
</header>