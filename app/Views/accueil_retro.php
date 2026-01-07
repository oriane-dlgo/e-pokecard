<?= $this->extend('layouts/base_retro') ?>

<?= $this->section('contenu') ?>

    <div class="catalogue-grid">
        
        <div style="grid-column: 1 / -1; margin-bottom: 10px;">
            <h2 style="margin:0; text-transform:uppercase; border-bottom: 4px solid black;">Top Traders / Bestsellers</h2>
        </div>

        <?php if (!empty($lesProduits) && is_array($lesProduits)): ?>
            <?php foreach ($lesProduits as $produit): ?>
                
                <div class="carte">
                    <div class="carte-img-container">
                        <img src="<?= base_url('assets/produits/' . esc($produit->image_url ?? 'default.png')) ?>" alt="<?= esc($produit->nom) ?>">
                    </div>
                    
                    <h3><?= esc($produit->nom) ?></h3>
                    
                    <?php if ($produit->type_produit == 'carte'): ?>
                         <p style="font-size:14px; margin:0;">(<?= esc($produit->rarete) ?>)</p>
                    <?php endif; ?>
                    
                    <p class="prix">$<?= esc($produit->prix) ?></p>
                    
                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                        
                        <a href="<?= base_url('detail/'.$produit->id) ?>" 
                           class="btn-achat" 
                           style="background: #3498db; border-color: #85c1e9 #1f618d #1f618d #85c1e9; color:white; flex:1; font-size:18px;">
                           INSPECT
                        </a>
                        
                        <?php if ($produit->stock > 0): ?>
                            
                            <form action="<?= base_url('panier/ajouter') ?>" method="post" style="flex:1;">
                                <input type="hidden" name="id_produit" value="<?= $produit->id ?>">
                                <button class="btn-achat" style="width:100%; font-size:18px; border-width:4px;">
                                    ADD +
                                </button>
                            </form>

                        <?php else: ?>

                            <div class="btn-achat" 
                                 style="background: #555; border-color: #777 #333 #333 #777; color:#999; flex:1; font-size:18px; text-align:center; padding-top: 8px;">
                                SOLD OUT
                            </div>

                        <?php endif; ?>

                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p style="grid-column: 1/-1; text-align:center;">Loading data...</p>
        <?php endif; ?>

    </div>

<?= $this->endSection() ?>