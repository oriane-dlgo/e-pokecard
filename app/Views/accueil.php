<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Boutique Pokémon</title>
    <link rel="stylesheet" href="<?= base_url("css/header.css") ?>">

</head>

<body>
    <header>

        <div class="top-bar">
            <a href="accueil.php" class="logo">
                <img src="<?= base_url("assets/logo.png") ?>" alt="logo du site">
            </a>
            <div class="img_bar">
                <a href="inscription.html">
                    <img src="<?= base_url("assets/utilisateur_icone.png") ?>" alt="image utilisateur">
                </a>
                <a href="panier.html">
                    <img src="<?= base_url("assets/panier_icone.png") ?>" alt="image panier">
                </a>
            </div>
        </div>
        <div class="bottom-bar">
            <nav class="navbar">
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="">Coffrets</a></li>
                    <li><a href="">Booster</a></li>
                    <li><a href="">Cartes</a></li>
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

        <h1>Bienvenue dans la boutique !</h1>

        <div class="catalogue">
            <!-- TODO : catégorie bestseller et en fonction des types de produits // faire carroussel avec produits -->
            <?php if (!empty($lesProduits) && is_array($lesProduits)): ?>
                <?php foreach ($lesProduits as $produit): ?>
                    <div class="carte">
                        <h3><?= esc($produit->nom) ?></h3>
                        <p><?= esc($produit->type_produit) ?></p>

                        <?php if ($produit->type_produit == 'carte'): ?>
                            <p>Rareté : <?= esc($produit->rarete) ?></p>
                        <?php endif; ?>

                        <p class="prix"><?= esc($produit->prix) ?> €</p>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <p>Aucun produit Pokémon trouvé.</p>
            <?php endif; ?>
        </div>

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