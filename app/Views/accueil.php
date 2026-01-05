<?= $this->extend('layouts/base') ?>

<?= $this->section('contenu') ?>

    <div class="bienvenue">
        <img src="<?= base_url("assets/perso.png")?>" alt="">
        <h1>Bienvenue dans la boutique !<i></i></h1>
    </div>

    <div class="catalogue">
        
        <div class="bestseller">
            <div class="section-title-container">
                <h2 class="main-title">Les plus populaires</h2>
                <div class="title-bar"></div>
            </div>
            
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

        </div>

<?= $this->endSection() ?>