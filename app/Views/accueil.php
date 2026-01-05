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
            <a href="<?= base_url('/') ?>" class="logo">
                <img src="<?= base_url("assets/logo.png") ?>" alt="logo du site">
            </a>
            <div class="img_bar">
                <a href="<?= base_url('connexion') ?>">
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
        <?= $this->extend('layouts/base') ?>

        <?= $this->section('contenu') ?>
        <div class="bienvenue">
            <img src="<?= base_url("assets/perso.png") ?>" alt="">
            <h1>Bienvenue dans la boutique !<i></i></h1>
        </div>


        <!-- <div class="catalogue"> -->

            <!-- <div class = "bestseller">
                <h2>Nos Bestsellers</h2>
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
            <?php endif; ?> -->




            <div class="catalogue">

                <div class="bestseller">
                    <div class="section-title-container">
                        <h2 class="main-title">Les plus populaires</h2>
                        <div class="title-bar"></div>
                    </div>

                    <div class="coffrets">
                        <h2><a href="">Nos Coffrets</a></h2>
                        <?php if (!empty($lesCoffrets) && is_array($lesCoffrets)): ?>
                            <?php foreach ($lesCoffrets as $produit): ?>
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

                    <div class="booster">
                        <h2><a href="">Nos Booster</a></h2>
                        <?php if (!empty($lesBoosters) && is_array($lesBoosters)): ?>
                            <?php foreach ($lesBoosters as $produit): ?>
                                <div class="carte">
                                    <h3><?= esc($produit->nom) ?></h3>
                                    <p><?= esc($produit->type_produit) ?></p>

                                    <?php if ($produit->type_produit == 'carte'): ?>
                                        <p>Rareté : <?= esc($produit->rarete) ?></p>
                                    <?php endif; ?>

                                    <p class="prix"><?= esc($produit->prix) ?> €</p>
                                    <a href="/detail/<?= $produit->id ?>" >Voir les détails</a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucun produit Pokémon trouvé.</p>
                        <?php endif; ?>
                    </div>

                    <div class="cartes">
                        <h2><a href="">Nos Cartes</a></h2>
                        <?php if (!empty($lesCartes) && is_array($lesCartes)): ?>
                            <?php foreach ($lesCartes as $produit): ?>
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
                </div>
            </div>
                <?= $this->endSection() ?>