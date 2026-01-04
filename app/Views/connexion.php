<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url("css/connexion.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/header.css") ?>">
</head>
<body>
    <header>
        <div class="top-bar">
            <a href="accueil.html" class="logo">
            <img src="assets/logo.png" alt="logo du site">
            </a>
            <div class="img_bar">
                <a href="inscription.html">
                <img src="assets/utilisateur_icone.png" alt="image utilisateur">
                </a>

                <a href="panier.html">
                <img src="assets/panier_icone.png" alt="image panier">
                </a>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
        <div class="form_area">
        <p class="title">Connexion</p>
        <form action="authenticate.php" method="post">
            <div class="group_form">
                <label class="sub_title" for="username">Identifiant</label>
                <input type="text" placeholder="Entrez votre identifiant" id="username" class="form_style">
            </div>
            <div class="group_form">
                <label class="sub_title" for="password">Mot de passe</label>
                <input type="text" placeholder="Entrez votre mot de passe" id="password" class="form_style">
            </div>
            <div>
                <button class="submit">Se connecter</button>
                <p>Vous n'avez pas de compte ? <a class="link" href="inscription.html">Inscrivez vous ici !</a></p>
            </div>
        </form>
    </main>

    <footer>
    </footer>
</body>


</html> 