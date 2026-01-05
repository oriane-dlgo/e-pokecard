<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?= base_url("css/accueil.css") ?>">
    <title>Document</title>
</head>
<body>
    <header>
        <div class = "top-bar">
            <div class = "titre">
                <img src="<?= base_url("assets/pokeball.png")?>" alt="">
                <h1>E-POKECARD</h1>
            </div>
            
            <div class = "img">
                <a href="<?= base_url("connexion.php")?>"><img src="<?= base_url("assets/utilisateur_icone.png")?>" alt=""></a>
                <img src="<?= base_url("assets/panier_icone.png")?>" alt="">
            </div>
        </div>
        <div class = "bottom-bar">
            <nav class = "navbar">
                <ul>
                    <li><a href="<?= base_url("accueil2.php")?>">HOME</a></li>
                    <li><a href="">CARTE</a></li>
                    <li><a href="">BOOSTER</a></li>
                    <li><a href="">DISPLAY</a></li>
                </ul>
            </nav>
            <div class="recherche">
                <form class="search" action="" method="GET">
                    <input type="text" class="searchbar" placeholder="Recherche...">
                </form>
            </div>
        </div>

    </header>
    <main>
        <div class = "msg">
            <p>!! ALERTE !! -- PROMOTION -50% SUR UNE GAMME DE PRODUITS DESIGNE SUR NOTRE SITE, PROFITEZ-EN JUSQU'AU 12/12/2026 --</p>
        </div>
        <div class = "bienvenue">
            <img src="<?= base_url("assets/perso.png")?>" alt="">
            <h1>Bienvenue dans la boutique !<i></i></h1>
        </div>
        
        <div class = ""></div>


    </main>
    <footer>


    </footer>
</body>
</html>