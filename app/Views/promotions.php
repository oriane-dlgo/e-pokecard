<?= $this->extend('layouts/base_retro') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url("css/search_retro.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="search-page-container">

    <!-- HEADER -->
    <div class="search-header">
        <h1>PROMO DATABASE</h1>
        <p><?= count($results) ?> PROMOTION(S) FOUND</p>
    </div>

    <div class="search-layout">

        <!-- SIDEBAR FILTERS -->
        <aside class="search-sidebar">
            <div class="sidebar-title">PROMO FILTERS</div>

            <form action="<?= base_url('promotions') ?>" method="get">

                <!-- TYPE -->
                <div class="filter-group">
                    <label>TYPE</label>
                    <select name="type" class="filter-select">
                        <option value="">ALL</option>
                        <option value="carte" <?= ($filters['type'] ?? '') === 'carte' ? 'selected' : '' ?>>CARTE</option>
                        <option value="booster" <?= ($filters['type'] ?? '') === 'booster' ? 'selected' : '' ?>>BOOSTER</option>
                        <option value="coffret" <?= ($filters['type'] ?? '') === 'coffret' ? 'selected' : '' ?>>COFFRET</option>
                    </select>
                </div>

                <!-- TRI -->
                <div class="filter-group">
                    <label>SORT BY</label>
                    <select name="tri" class="filter-select">
                        <option value="">DEFAULT</option>
                        <option value="prix_asc" <?= ($filters['tri'] ?? '') === 'prix_asc' ? 'selected' : '' ?>>
                            PRICE LOW → HIGH
                        </option>
                        <option value="prix_desc" <?= ($filters['tri'] ?? '') === 'prix_desc' ? 'selected' : '' ?>>
                            PRICE HIGH → LOW
                        </option>
                        <option value="promo_desc" <?= ($filters['tri'] ?? '') === 'promo_desc' ? 'selected' : '' ?>>
                            BIGGEST PROMO
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn-filter-apply">SCAN PROMOS</button>
                <a href="<?= base_url('promotions') ?>" class="btn-filter-reset">RESET</a>

            </form>
        </aside>

        <!-- RESULTS -->
        <section class="search-results">

            <?php if (empty($results)): ?>
                <div class="no-results">
                    <p>NO PROMO FOUND...</p>
                </div>
            <?php else: ?>

                <div class="results-grid">

                    <?php foreach ($results as $produit): ?>

                        <?php
                        $prixPromo = $produit->prix * (1 - $produit->promo / 100);
                        ?>

                        <div class="mini-card promo-card">

                            <div class="mini-card-img">
                                <img src="<?= base_url(
                                    'assets/produits/' . esc($produit->image_url ?? 'default.png')
                                ) ?>">
                            </div>

                            <div class="mini-card-info">
                                <h4><?= esc($produit->nom) ?></h4>

                                <div class="price-badge">
                                    <span style="text-decoration: line-through; opacity:.6;">
                                        $<?= esc($produit->prix) ?>
                                    </span><br>
                                    <strong style="color:#ff004c;">
                                        $<?= number_format($prixPromo, 2) ?>
                                    </strong>
                                </div>

                                <div class="mini-actions">
                                    <a href="<?= base_url('detail/'.$produit->id) ?>"
                                       class="btn-mini btn-blue">
                                        VIEW
                                    </a>

                                    <?php if ($produit->stock > 0): ?>
                                        <form action="<?= base_url('panier/ajouter') ?>" method="post">
                                            <input type="hidden" name="id_produit" value="<?= $produit->id ?>">
                                            <button class="btn-mini btn-yellow">ADD</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="btn-mini btn-gray">OUT</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>

    </div>
</div>

<?= $this->endSection() ?>
