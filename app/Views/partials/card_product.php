<?php
    // Calcul du prix promo
    $prixAffiche = $produit->prix;
    $hasPromo = !empty($produit->tauxPromo);
    
    if ($hasPromo) {
        $prixPromo = $produit->prix - ($produit->prix * $produit->tauxPromo);
    }
?>

<div class="carte <?= (isset($isPromo) && $isPromo) ? 'carte-promo' : '' ?>">
    <?php if ($hasPromo): ?>
        <div class="badge-promo">-<?= $produit->tauxPromo * 100 ?>%</div>
    <?php endif; ?>

    <div class="carte-img-container">
        <img src="<?= base_url('assets/produits/' . esc($produit->image_url ?? 'default.png')) ?>" alt="<?= esc($produit->nom) ?>">
    </div>
    
    <h3><?= esc($produit->nom) ?></h3>
    
    <div class="carte-details">
        <span class="info-tag type-tag"><?= strtoupper(esc($produit->type_produit)) ?></span>
        
        <?php if (!empty($produit->nom_extension)): ?>
            <span class="info-tag ext-tag"><?= esc($produit->nom_extension) ?></span>
        <?php endif; ?>

        <?php if ($produit->type_produit == 'carte' && !empty($produit->rarete)): ?>
             <span class="info-tag rarete-tag"><?= esc($produit->rarete) ?></span>
        <?php endif; ?>
    </div>
    
    <div class="prix-container">
        <?php if ($hasPromo): ?>
            <span class="prix-barre">$<?= esc($produit->prix) ?></span>
            <span class="prix-final blink-red">$<?= number_format($prixPromo, 2) ?></span>
        <?php else: ?>
            <span class="prix-final">$<?= esc($produit->prix) ?></span>
        <?php endif; ?>
    </div>
    
    <div style="display: flex; gap: 10px; margin-top: 10px;">
        <a href="<?= base_url('detail/'.$produit->id) ?>" class="btn-achat btn-blue">INSPECT</a>
        
        <?php if ($produit->stock > 0): ?>
            <form action="<?= base_url('panier/ajouter') ?>" method="post" style="flex:1;">
                <input type="hidden" name="id_produit" value="<?= $produit->id ?>">
                <button class="btn-achat">ADD +</button>
            </form>
        <?php else: ?>
            <div class="btn-achat btn-soldout">SOLD OUT</div>
        <?php endif; ?>
    </div>
</div>