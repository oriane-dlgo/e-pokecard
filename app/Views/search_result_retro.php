<?= $this->extend('layouts/base_retro') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url("css/search_retro.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="search-page-container">
    
    <div class="search-header">
        <h1>DATABASE SEARCH</h1>
        <p><?= count($results) ?> RESULT(S) FOUND</p>
    </div>

    <div class="search-layout">
        
        <aside class="search-sidebar">
            <div class="sidebar-title">FILTER CONFIG</div>
            
            <form action="<?= base_url('recherche') ?>" method="get">
                
                <div class="filter-group">
                    <label>KEYWORD</label>
                    <input type="text" name="q" class="filter-input" value="<?= esc($filters['q']) ?>">
                </div>

                <div class="filter-group">
                    <label>TYPE</label>
                    <select name="type" class="filter-select">
                        <option value="">ALL TYPES</option>
                        <option value="carte" <?= $filters['type'] == 'carte' ? 'selected' : '' ?>>CARTE</option>
                        <option value="booster" <?= $filters['type'] == 'booster' ? 'selected' : '' ?>>BOOSTER</option>
                        <option value="coffret" <?= $filters['type'] == 'coffret' ? 'selected' : '' ?>>COFFRET</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>RARITY</label>
                    <select name="rarete" class="filter-select">
                        <option value="">ANY RARITY</option>
                        <option value="Commune" <?= $filters['rarete'] == 'Commune' ? 'selected' : '' ?>>COMMUNE</option>
                        <option value="Rare" <?= $filters['rarete'] == 'Rare' ? 'selected' : '' ?>>RARE</option>
                        <option value="FA" <?= $filters['rarete'] == 'FA' ? 'selected' : '' ?>>FULL ART</option>
                        </select>
                </div>

                <div class="filter-group">
                    <label>SORT BY</label>
                    <select name="tri" class="filter-select">
                        <option value="">DEFAULT</option>
                        <option value="prix_asc" <?= $filters['tri'] == 'prix_asc' ? 'selected' : '' ?>>PRICE: LOW -> HIGH</option>
                        <option value="prix_desc" <?= $filters['tri'] == 'prix_desc' ? 'selected' : '' ?>>PRICE: HIGH -> LOW</option>
                    </select>
                </div>

                <button type="submit" class="btn-filter-apply">UPDATE RADAR</button>
                <a href="<?= base_url('recherche') ?>" class="btn-filter-reset">RESET</a>

            </form>
        </aside>

        <section class="search-results">
            
            <?php if (empty($results)): ?>
                <div class="no-results">
                    <p>NO DATA FOUND...</p>
                    <p>TRY ANOTHER QUERY.</p>
                </div>
            <?php else: ?>
                
                <div class="results-grid">
                    <?php foreach ($results as $produit): ?>
                        <div class="mini-card">
                            <div class="mini-card-img">
                                <img src="<?= base_url('assets/produits/' . esc($produit->image_url ?? 'default.png')) ?>">
                            </div>
                            <div class="mini-card-info">
                                <h4><?= esc($produit->nom) ?></h4>
                                <div class="price-badge">$<?= esc($produit->prix) ?></div>
                                
                                <div class="mini-actions">
                                    <a href="<?= base_url('detail/'.$produit->id) ?>" class="btn-mini btn-blue">VIEW</a>
                                    
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