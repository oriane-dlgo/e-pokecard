<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url("css/pages/panier.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="cart-retro-container">
    <div class="trainer-header">
        <h1>PANIER</h1>
    </div>

    <?php if(session()->getFlashdata('msg')):?>
        <div class="alert alert-error">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif;?>

    <?php if (empty($articles)): ?>
        <div class="empty-cart-retro">
            <p>VOTRE PANIER EST VIDE !</p>
            <a href="<?= base_url('/') ?>" class="btn-retro btn-edit">RETOUR À LA BOUTIQUE</a>
        </div>
    <?php else: ?>

        <div class="inventory-list">
            <div class="inventory-header-row">
                <span class="col-item">ARTICLE</span>
                <span class="col-price">PRIX</span>
                <span class="col-qty">QTE</span>
                <span class="col-total">TOTAL</span>
                <span class="col-action"></span>
            </div>

            <?php foreach ($articles as $item): ?>
            <div class="inventory-row">
                <div class="col-item item-info">
                    <img src="<?= base_url('assets/produits/' . esc($item['produit']->image_url ?? 'default.png')) ?>" class="pixel-img">
                    <span><?= esc($item['produit']->nom) ?></span>
                </div>
                <div class="col-price"><?= esc($item['produit']->prix) ?>€</div>
                <div class="col-qty">x<?= esc($item['quantite']) ?></div>
                <div class="col-total"><?= esc($item['total_ligne']) ?>€</div>
                <div class="col-action">
                    <a href="<?= base_url('panier/supprimer/' . $item['produit']->id) ?>" class="btn-cross">X</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            
            <div class="menu-box">
                <a href="<?= base_url('panier/vider') ?>" class="btn-retro btn-logout">VIDER TOUT</a>
                <a href="<?= base_url('panier/valider') ?>" class="btn-retro btn-save">VALIDER</a>
            </div>

            <div class="total-display">
                TOTAL: $<?= $total_global ?> 
            </div>
            
        </div>

    <?php endif; ?>
</div>

<?= $this->endSection() ?>