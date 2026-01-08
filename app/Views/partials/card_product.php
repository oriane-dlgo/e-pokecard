<?php
    // Calcul du prix promo
    $prixAffiche = $produit->prix;
    $hasPromo = !empty($produit->tauxPromo);
    
    if ($hasPromo) {
        $prixPromo = $produit->prix - ($produit->prix * $produit->tauxPromo);
    }

    // Logique pour le tag de droite (Code Extension OU Nom Série)
    $tagDroite = "SERIE INCONNUE";
    if (!empty($produit->code_extension)) {
        $tagDroite = $produit->code_extension; // Ex: EV08
    } elseif (!empty($produit->nom_serie)) {
        $tagDroite = $produit->nom_serie;      // Ex: Écarlate et Violet
    } elseif (!empty($produit->nom_extension)) {
        // Fallback : on coupe le nom de l'extension si trop long
        $tagDroite = substr($produit->nom_extension, 0, 15) . '...'; 
    }
?>

<div class="carte <?= $hasPromo ? 'carte-promo' : '' ?>">
<?php if ($hasPromo): ?>
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
        <?php if ($hasPromo): ?>
            <span class="prix-final blink-red">$<?= number_format($prixPromo, 2) ?></span>
            <span class="prix-sup">$<?= esc($produit->prix) ?></span>
        <?php else: ?>
            <span class="prix-final">$<?= esc($produit->prix) ?></span>
        <?php endif; ?>
    </div>
    
    <div class="card-actions">
        <a href="<?= base_url('detail/'.$produit->id) ?>" class="btn-inspect">INSPECT</a>
        
        <?php if ($produit->stock > 0): ?>
            <form action="<?= base_url('panier/ajouter') ?>" method="post" style="flex:1;">
                <input type="hidden" name="id_produit" value="<?= $produit->id ?>">
                <button class="btn-achat">ADD +</button>
            </form>
        <?php else: ?>
            <div class="btn-soldout">SOLD OUT</div>
        <?php endif; ?>
    </div>
</div>