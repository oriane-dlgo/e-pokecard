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
        <div class="alert alert-error" style="color: red; background: #ffe6e6; padding: 10px; border: 2px solid red; margin-bottom: 20px;">
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
                <span class="col-qty">PROMO</span> <span class="col-qty">QTE</span>
                 <span class="col-total">TVA</span>
                <span class="col-total">TOTAL</span>
                <span class="col-action"></span>
            </div>

            <?php foreach ($articles as $item): ?>
            <div class="inventory-row">
                
                <div class="col-item item-info">
                    <a href="<?= base_url('detail/' . $item['produit']->id) ?>" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px; width: 100%;">
                        <img src="<?= base_url('assets/produits/' . esc($item['produit']->image_url ?? 'default.png')) ?>" class="pixel-img">
                        <span><?= esc($item['produit']->nom) ?></span>
                    </a>
                </div>

                <div class="col-price"><?= number_format($item['produit']->prix, 2) ?>€</div>
                
                <div class="col-qty" style="font-weight: bold;">
                    <?php if(!empty($item['produit']->tauxPromo)): ?>
                        <span style="color: red; background: #ffeaea; border: 1px solid red; padding: 2px 5px; border-radius: 4px;">
                            -<?= intval($item['produit']->tauxPromo * 100) ?>%
                        </span>
                    <?php else: ?>
                        <span style="color: #999;">-</span>
                    <?php endif; ?>
                </div>

                <div class="col-qty" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                    <form action="<?= base_url('panier/update') ?>" method="post" style="margin:0;">
                        <input type="hidden" name="id" value="<?= $item['produit']->id ?>">
                        <input type="hidden" name="action" value="decrease">
                        <button type="submit" class="btn-retro" style="padding: 0 8px; font-size: 18px; min-width: 30px; line-height: 1;">-</button>
                    </form>

                    <span style="min-width: 20px; text-align: center;"><?= esc($item['quantite']) ?></span>

                    <form action="<?= base_url('panier/update') ?>" method="post" style="margin:0;">
                        <input type="hidden" name="id" value="<?= $item['produit']->id ?>">
                        <input type="hidden" name="action" value="increase">
                        
                        <?php 
                            // On vérifie si le max est atteint
                            $isMaxReached = ($item['quantite'] >= $item['produit']->stock);
                        ?>

                        <button type="submit" class="btn-retro" 
                                style="padding: 0 8px; font-size: 18px; min-width: 30px; line-height: 1; 
                                       <?= $isMaxReached ? 'opacity: 0.5; cursor: not-allowed;' : '' ?>">
                            
                            +
                        </button>
                    </form>
                </div>

                <div class="col-total"><?= number_format($item['tva'], 2) ?>€</div>
                <div class="col-total"><?= number_format($item['total_ligne'], 2) ?>€</div>
                
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
                TOTAL: <?= number_format($total_global, 2) ?>€ 
            </div>
        </div>

    <?php endif; ?>
</div>

<?= $this->endSection() ?>