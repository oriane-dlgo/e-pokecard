<?php
    // Note : On ne calcule plus le prix ici, c'est le Décorateur qui l'a fait !
    
    // On garde juste la logique cosmétique pour le Tag de droite (Série/Extension)
    $tagDroite = "SERIE INCONNUE";
    if (!empty($produit->code_extension)) {
        $tagDroite = $produit->code_extension; 
    } elseif (!empty($produit->nom_serie)) {
        $tagDroite = $produit->nom_serie;      
    } elseif (!empty($produit->nom_extension)) {
        $tagDroite = substr($produit->nom_extension, 0, 15) . '...'; 
    }
?>

<div class="carte <?= !empty($produit->tauxPromo) ? 'carte-promo' : '' ?>">

    <?php if (!empty($produit->tauxPromo)): ?>
        <div class="badge-promo">-<?= intval($produit->tauxPromo * 100) ?>%</div>
    <?php endif; ?>

    <div class="carte-img-container">
        <img src="<?= base_url('assets/produits/' . esc($produit->image_url ?? 'default.png')) ?>" alt="<?= esc($produit->nom) ?>">
    </div>
    
    <div class="tags-row">
        <span class="tag-left"><?= strtoupper(esc($produit->type_produit)) ?></span>
        <span class="tag-right"><?= strtoupper(esc($tagDroite)) ?></span>
    </div>

    <hr class="separator">

    <h3><?= esc($produit->nom) ?></h3>
    
    <div class="prix-container">
        <?= $produit->prix_html ?? ('<span class="prix-final">'.number_format($produit->prix, 2).'€</span>') ?>
    </div>
    
    <div class="card-actions">
        <a href="<?= base_url('detail/'.$produit->id) ?>" class="btn-inspect">Détails</a>
        
        <?php if ($produit->stock > 0): ?>
            <form action="<?= base_url('panier/ajouter') ?>" method="post">
                <input type="hidden" name="id_produit" value="<?= $produit->id ?>">
                <button class="btn-achat">Ajouter au panier</button>
            </form>
        <?php else: ?>
            <div class="btn-soldout" style="flex:1;">Rupture de stock</div>
        <?php endif; ?>
    </div>
</div>