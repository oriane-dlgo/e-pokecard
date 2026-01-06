 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?= base_url("css/main.css") ?>">
        <?= $this->renderSection('css') ?>
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
                <a href="<?= base_url('connexion')?>"><img src="<?= base_url("assets/utilisateur_icone.png")?>" alt=""></a>
                <a href="<?= base_url('panier')?>"><img src="<?= base_url("assets/panier_icone.png")?>" alt=""></a>
            </div>
        </div>
        <div class = "bottom-bar">
            <nav class = "navbar">
                <ul>
                    <li><a href="<?= base_url('/')?>">HOME</a></li>
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
        <div class="msg">
            <p>
                !! ALERTE !! -- PROMOTION -50% SUR UNE GAMME DE PRODUITS
                DESIGNE SUR NOTRE SITE, PROFITEZ-EN JUSQU'AU 12/12/2026 --
            </p>
        </div>
    <?= $this->renderSection('contenu') ?>
  </main>
  <footer>
    
        <h2>Nous contacter</h2>
        <div class = "contact">
            <ul>
            <li>Téléphone : 02 34 54 56 89</li>
            <li>Email : e-pokecard@pokemon.com</li>
        </ul>
    </div>
  </footer>
 </body>
</html>