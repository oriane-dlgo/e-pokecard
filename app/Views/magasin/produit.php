<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url("css/pages/produit.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="produit-wrapper">
    
    <div class="pokedex-container">
        
        <div class="left-screen">
            <img src="<?= base_url('assets/produits/' . ($product->image_url ?? 'default.png')) ?>" 
                 alt="<?= esc($product->nom) ?>">
        </div>

        <div class="right-screen">
            
            <div class="data-display">
                <div class="product-title"><?= esc($product->nom) ?></div>
                
                <div class="stat-row">
                    <span>TYPE:</span>
                    <span><?= esc($product->type_produit) ?></span>
                </div>

                <?php if (!empty($product->rarete)): ?>
                <div class="stat-row">
                    <span>RARETE:</span>
                    <span><?= esc($product->rarete) ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($product->numero_carte)): ?>
                <div class="stat-row">
                    <span>NO. CARTE:</span>
                    <span><?= esc($product->numero_carte) ?></span>
                </div>
                <?php endif; ?>

                <div class="description-box">
                    DESCRIPTION:<br>
                    <?= esc($product->description) ?>
                </div>

                <div class="price-tag">
                    PRIX: $<?= esc($product->prix) ?>
                </div>

                <div style="text-align: right; font-size: 18px; margin-top: 5px;">
                    STATUS: 
                    <?php if ($product->stock > 0): ?>
                        <span style="color: #0f380f; font-weight: bold;">EN STOCK (<?= $product->stock ?>)</span>
                    <?php else: ?>
                        <span style="color: red; font-weight: bold; background:black; padding:0 5px;">RUPTURE DE STOCK</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="action-pad">
                <a href="<?= base_url('/') ?>" class="btn-pokedex btn-back">
                    ◄ RETOUR
                </a>

                <?php if ($product->stock > 0): ?>
                    <form action="<?= base_url('panier/ajouter') ?>" method="post" style="flex:1;">
                        <input type="hidden" name="id_produit" value="<?= $product->id ?>">
                        <button class="btn-pokedex btn-add" style="width:100%;">
                            AJOUTER AU PANIER
                        </button>
                    </form>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>