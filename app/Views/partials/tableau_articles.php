<div class="inventory-list <?= $editable ? 'mode-editable' : 'mode-readOnly' ?>">
    
    <div class="inventory-header-row">
        <span class="col-item">ARTICLE</span>
        <span class="col-price">PRIX</span>
        <span class="col-qty">PROMO</span>
        <span class="col-qty">QTE</span>
        <span class="col-total">TVA</span>
        <span class="col-total">TOTAL</span>
        <span class="col-action"></span>
    </div>

    <?php foreach ($items as $item): ?>
        <?php 
            // Normalisation des données
            if ($editable) {
                // Mode PANIER
                $produit = $item['produit'];
                $quantite = $item['quantite'];
                $prixUnitaire = $produit->prix;
                $totalLigne = $item['total_ligne'];
                $tva = $item['tva'];
                $tauxPromo = $produit->tauxPromo;
                $stock = $produit->stock;
                $imageUrl = $produit->image_url;
                $nom = $produit->nom;
                $idProduit = $produit->id;
            } else {
                // Mode COMMANDE
                $quantite = $item->quantite;
                $prixUnitaire = $item->prix_unitaire;
                $totalLigne = $prixUnitaire * $quantite;
                $tva = number_format((($totalLigne) + 3) / 1.2 * 0.2, 2);
                $imageUrl = $item->image_url ?? 'default.png';
                $nom = $item->nom;
                $idProduit = $item->product_id;
            }
        ?>

        <div class="inventory-row">
            
            <div class="col-item item-info">
                <a href="<?= base_url('detail/' . $idProduit) ?>" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px; width: 100%;">
                    <img src="<?= base_url('assets/produits/' . esc($imageUrl ?? 'default.png')) ?>" class="pixel-img" style="width: 40px; height: 40px;">
                    <span><?= esc($nom) ?></span>
                </a>
            </div>

            <div class="col-price"><?= number_format($prixUnitaire, 2) ?>€</div>
            
                <div class="col-qty" style="font-weight: bold;">
                    <?php if(!empty($tauxPromo)): ?>
                        <span style="color: red; background: #ffeaea; border: 1px solid red; padding: 2px 5px; border-radius: 4px;">
                            -<?= intval($tauxPromo * 100) ?>%
                        </span>
                    <?php else: ?>
                        <span style="color: #999;">-</span>
                    <?php endif; ?>
                </div>

            <div class="col-qty" style='display: flex; align-items: center; justify-content: center; gap: 5px;'>
                <?php if ($editable): ?>
                    <form action="<?= base_url('panier/update') ?>" method="post" style="margin:0;">
                        <input type="hidden" name="id" value="<?= $idProduit ?>">
                        <input type="hidden" name="action" value="decrease">
                        <button type="submit" class="btn-retro" style="padding: 0 8px; font-size: 18px; min-width: 30px; line-height: 1;">-</button>
                    </form>

                    <span style="min-width: 20px; text-align: center;"><?= esc($quantite) ?></span>
                
                    <form action="<?= base_url('panier/update') ?>" method="post" style="margin:0;">
                        <input type="hidden" name="id" value="<?= $idProduit ?>">
                        <input type="hidden" name="action" value="increase">
                        
                        <?php $isMaxReached = ($quantite >= $stock); ?>

                        <button type="submit" class="btn-retro" 
                                style="padding: 0 8px; font-size: 18px; min-width: 30px; line-height: 1; 
                                       <?= $isMaxReached ? 'opacity: 0.5; cursor: not-allowed;' : '' ?>"
                                <?= $isMaxReached ? 'disabled' : '' ?>>
                            +
                        </button>
                    </form>

                <?php else: ?>
                    <?= esc($quantite) ?>
                <?php endif; ?>
            </div>

                <div class="col-total"><?= number_format($tva, 2) ?>€</div>
            

            <div class="col-total" style="<?= (!$editable) ? 'font-weight: bold;' : '' ?>">
                <?= number_format($totalLigne, 2) ?>€
            </div>
            
            <?php if ($editable): ?>
                <div class="col-action">
                    <a href="<?= base_url('panier/supprimer/' . $idProduit) ?>" class="btn-cross">X</a>
                </div>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>
</div>
