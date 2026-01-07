<?= $this->extend('layouts/base_retro') ?>

<?= $this->section('contenu') ?>

    <div class="catalogue-section">
        <div class="section-title">
            <h2>🔥 NEW ARRIVALS / NOUVEAUTÉS</h2>
        </div>

        <div class="catalogue-grid">
            <?php foreach ($nouveautes as $produit): ?>
                <?= view('partials/card_product', ['produit' => $produit]) ?>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (!empty($promotions)): ?>
        <div class="promo-banner-container">
            <div class="promo-header">
                <span class="blink">★ SPECIAL DEALS ★</span> - FLASH SALES - <span class="blink">★ LIMITED TIME ★</span>
            </div>

            <div class="promo-grid">
                <?php foreach ($promotions as $produit): ?>
                    <?= view('partials/card_product', ['produit' => $produit, 'isPromo' => true]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="catalogue-section">
        <div class="section-title">
            <h2>🏆 TOP TRADERS / BESTSELLERS</h2>
        </div>

        <div class="catalogue-grid">
            <?php foreach ($bestsellers as $produit): ?>
                <?= view('partials/card_product', ['produit' => $produit]) ?>
            <?php endforeach; ?>
        </div>
    </div>

<?= $this->endSection() ?>