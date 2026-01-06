<?= $this->extend('layouts/base2') ?>

<?= $this->section('contenu') ?>

<main>
    <div class="msg">
        <p>
            !! ALERTE !! -- PROMOTION -50% SUR UNE GAMME DE PRODUITS
            DESIGNE SUR NOTRE SITE, PROFITEZ-EN JUSQU'AU 12/12/2026 --
        </p>
    </div>

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
                            <a href="/detail/<?= $produit->id ?>" >Voir les détails</a>
    

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
                            <a href="/detail/<?= $produit->id ?>" >Voir les détails</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun produit Pokémon trouvé.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</main>

<?= $this->endSection() ?>