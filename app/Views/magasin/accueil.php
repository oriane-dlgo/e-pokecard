<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('contenu') ?>

    <div class="catalogue-section">
        <div class="section-title">
            <h2>🔥 -- RETROUVE NOS NOUVEAUTÉES</h2>
        </div>

        <div class="catalogue-grid">
            <?php foreach ($nouveautes as $produit): ?>
                <?= view('partials/carte_produit', ['produit' => $produit]) ?>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (!empty($promotions)): ?>
        <div class="promo-banner-container">
            <div class="promo-header">
                <span class="neon-text-gold">
                    ★ --- ★
                </span> 
                - OUBLIE PAS NOS PROMOTIONS A TEMPS LIMITÉ - 
                <span class="neon-text-gold">
                    ★ --- ★
                </span>
            </div>

            <div class="promo-grid">
                <?php foreach ($promotions as $produit): ?>
                    <?= view('partials/carte_produit', ['produit' => $produit, 'isPromo' => true]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="catalogue-section">

        <div class="section-title">
            <h2>🏆 -- NOS PLUS POPULAIRES </h2>
                    
            <div class="filter-buttons">
                <a href="<?= base_url('/?filter=all') ?>" 
                   class="btn-filter <?= ($current_filter != 'week') ? 'active' : '' ?>">
                   TOUS LES TEMPS
                </a>
                <a href="<?= base_url('/?filter=week') ?>" 
                   class="btn-filter <?= ($current_filter == 'week') ? 'active' : '' ?>">
                   CETTE SEMAINE
                </a>
            </div>
        </div>

        <div class="catalogue-grid">
            <?php if(empty($bestsellers)): ?>
                <p style="grid-column: 1/-1; text-align: center; color: white;">Pas de ventes cette semaine...</p>
            <?php else: ?>
                <?php foreach ($bestsellers as $produit): ?>
                    <?= view('partials/carte_produit', ['produit' => $produit]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>      
                
    </div>

<?= $this->endSection() ?>