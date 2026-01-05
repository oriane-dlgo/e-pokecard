<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique Pokémon</title>
    
    <link rel="stylesheet" href="<?= base_url("css/header.css") ?>">
    
    <?= $this->renderSection('css') ?>
</head>

<body>

    <header>
        <div class="top-bar">
            <a href="<?= base_url('/') ?>" class="logo">
                <img src="<?= base_url("assets/logo.png") ?>" alt="logo du site">
            </a>

            <div class="img_bar">
                
                <?php if (session()->get('isLoggedIn')): ?>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        
                        <a href="<?= base_url('profil') ?>">
                            <img src="<?= base_url("assets/utilisateur_icone.png") ?>" alt="MonProfil">
                            <span><?= esc(session()->get('user_name')) ?> </span>
                        </a>
                        <a href="<?= base_url('deconnexion') ?>" style="color: red; font-weight: bold;">(Déconnexion)</a>
                    </div>

                <?php else: ?>

                    <a href="<?= base_url('connexion') ?>">
                        <img src="<?= base_url("assets/utilisateur_icone.png") ?>" alt="Connexion">
                    </a>

                <?php endif; ?>

                <a href="<?= base_url('panier') ?>">
                    <img src="<?= base_url("assets/panier_icone.png") ?>" alt="Panier">
                </a>
            </div>

        </div>

        <div class="bottom-bar">
            <nav class="navbar">
                <ul>
                    <li><a href="<?= base_url('/') ?>">Home</a></li>
                    <li><a href="#">Coffrets</a></li>
                    <li><a href="#">Booster</a></li>
                    <li><a href="#">Cartes</a></li>
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
        <?= $this->renderSection('contenu') ?>
    </main>

    <footer>
        <div class="contact">
            <ul>
                <li>tel : 999999999999</li>
                <li>mail : haiohfe@fjz.com</li>
            </ul>
        </div>
    </footer>

</body>
</html>