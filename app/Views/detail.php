<?= $this->extend('layouts/base2') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url("css/detail.css") ?>">

<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="produit-page">
    <div class="produit-wrapper">

        <div class="produit-card">

        
                    <!-- Image -->
                    <div class="produit-img">
                        <img 
                            src="<?= base_url('assets/produits/' . $product->image_url) ?>"
                            class="img-fluid rounded"
                            alt="Image <?= esc($product->nom) ?>"
                        >
                    </div>

                    <!-- Infos produit -->
                    <div class="produit-info">
                       

                            <h1 class="card-title"><?= esc($product->nom) ?></h1>

                            <span>
                                <?= esc($product->type_produit) ?>
                            </span>

                            <?php if (!empty($product->rarete)): ?>
                                <span>
                                    Rareté : <?= esc($product->rarete) ?>
                                </span>
                            <?php endif; ?>

                            <p class="produit-description">
                                <?= esc($product->description) ?>
                            </p>

                            <h3 class="produit-prix">
                                <?= esc($product->prix) ?> €
                            </h3>

                            <p class = "produit-stock">
                                Stock :
                                <?php if ($product->stock > 0): ?>
                                    <span><?= esc($product->stock) ?></span>
                                <?php else: ?>
                                    <span>Rupture</span>
                                <?php endif; ?>
                            </p>

                            <p class = "produit-promo">
                                Promotion :
                                <?php if (!empty($product->promotion)): ?>
                                    <span>En promotion</span>
                                <?php else: ?>
                                    <span>Pas de promo</span>
                                <?php endif; ?>
                            </p>

                            <div class="bouton">
                                <a href="/" class="btn-retour">
                                    ← Retour
                                </a>

                                <?php if ($product->stock > 0): ?>
                                    <button class="btnajouter">
                                        Ajouter au panier
                                    </button>
                                <?php endif; ?>
                            </div>      
            </div>           
        </div>
    </div>
</div>
<?= $this->endSection() ?>
