<?= $this->extend('layouts/base2') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url("css/accueil.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>
    

    <div class="bienvenue">
        <img src="<?= base_url('assets/perso.png') ?>" alt="">
        <h1>Bienvenue dans la boutique !<i></i></h1> 
    </div>
    <div class="catalogue">

        <div class="bestseller">
            <div class="section-title-container">
                <h2 class="main-title">Les plus populaires</h2>
                <div class="title-bar"></div>
            </div>

            <div class="coffrets">
                <h2><a href="">Nos Display</a></h2>
                <div class = "produit">
                    <?php if (!empty($lesCoffrets) && is_array($lesCoffrets)): ?>
                    <?php foreach ($lesCoffrets as $produit): ?>
                        <div class="carte">
                            <?php if (!empty($produit->image_url)): ?>
                                <img 
                                    src="<?= base_url('assets/produits/' . $produit->image_url) ?>" 
                                    alt="<?= esc($produit->nom) ?>" 
                                    class="img-produit"
                                >
                            <?php else: ?>
                                <img 
                                    src="<?= base_url('assets/produits/default.png') ?>" 
                                    alt="Image par défaut" 
                                    class="img-produit"
                                >
                            <?php endif; ?>

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
            </div>

            <div class="booster">
                <h2><a href="">Nos Booster</a></h2>
                <div class = "produit">
                    <?php if (!empty($lesBoosters) && is_array($lesBoosters)): ?>
                    <?php foreach ($lesBoosters as $produit): ?>
                        <div class="carte">
                            <?php if (!empty($produit->image_url)): ?>
                                <img 
                                    src="<?= base_url('assets/produits/' . $produit->image_url) ?>" 
                                    alt="<?= esc($produit->nom) ?>" 
                                    class="img-produit"
                                >
                            <?php else: ?>
                                <img 
                                    src="<?= base_url('assets/produits/default.png') ?>" 
                                    alt="Image par défaut" 
                                    class="img-produit"
                                >
                            <?php endif; ?>
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
            </div>

            <div class="cartes">
                <h2><a href="">Nos Cartes</a></h2>
                <div class = "produit">
                    <?php if (!empty($lesCartes) && is_array($lesCartes)): ?>
                    <?php foreach ($lesCartes as $produit): ?>
                        <div class="carte">
                            <?php if (!empty($produit->image_url)): ?>
                                <img 
                                    src="<?= base_url('assets/produits/' . $produit->image_url) ?>" 
                                    alt="<?= esc($produit->nom) ?>" 
                                    class="img-produit"
                                >
                            <?php else: ?>
                                <img 
                                    src="<?= base_url('assets/produits/default.png') ?>" 
                                    alt="Image par défaut" 
                                    class="img-produit"
                                >
                            <?php endif; ?>
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
            </div>
        </div>
    </div>



<?= $this->endSection() ?>