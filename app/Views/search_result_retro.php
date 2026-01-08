<?= $this->extend('layouts/base_retro') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url("css/search_retro.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="search-page-container">
    
    <div class="search-header">
        <h1>RADAR DE RECHERCHE</h1>
        <p><?= count($results) ?> RESULTAT(S)</p>
    </div>

    <div class="search-layout">
        
        <aside class="search-sidebar">
            <div class="sidebar-title">CONFIG RADAR</div>
            
            <form action="<?= base_url('recherche') ?>" method="get">
                
                <div class="filter-group">
                    <label>MOT-CLÉ</label>
                    <input type="text" name="q" class="filter-input" value="<?= esc($filters['q']) ?>" placeholder="Ex: Dracaufeu...">
                </div>

                <div class="filter-accordion">
                    <input type="checkbox" id="toggle-type" class="accordion-toggle" <?= !empty($filters['type']) ? 'checked' : '' ?>>
                    <label for="toggle-type" class="accordion-header">
                        TYPE DE PRODUIT <span class="acc-icon"></span>
                    </label>
                    <div class="accordion-content">
                        <?php 
                            $typesList = ['carte', 'booster', 'coffret', 'display', 'ETB', 'accessoire'];
                            foreach($typesList as $t): 
                        ?>
                            <div class="checkbox-item">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="type[]" value="<?= $t ?>" <?= in_array($t, $filters['type']) ? 'checked' : '' ?>>
                                    <span class="checkmark"></span>
                                    <?= strtoupper($t) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="filter-accordion">
                    <input type="checkbox" id="toggle-series" class="accordion-toggle" 
                           <?= (!empty($filters['ext']) || !empty($filters['series_full'])) ? 'checked' : '' ?>> 
                    
                    <label for="toggle-series" class="accordion-header">
                        SÉRIES & EXTENSIONS <span class="acc-icon"></span>
                    </label>
                    
                    <div class="accordion-content" style="padding: 0;"> <?php foreach($seriesMap as $serieID => $data): ?>
                            <?php if(!empty($data['extensions'])): ?>
                                
                                <div class="sub-accordion">
                                    <input type="checkbox" id="toggle-serie-<?= $serieID ?>" class="sub-toggle"
                                           <?php 
                                               // Logique pour garder le sous-menu ouvert
                                               $isOpen = in_array($serieID, $filters['series_full']);
                                               if(!$isOpen) {
                                                   foreach($data['extensions'] as $ext) {
                                                       if(in_array($ext->id, $filters['ext'])) { $isOpen = true; break; }
                                                   }
                                               }
                                               echo $isOpen ? 'checked' : '';
                                           ?>
                                    >

                                    <label for="toggle-serie-<?= $serieID ?>" class="sub-header">
                                        <?= strtoupper($data['info']->nom) ?>
                                        <span class="sub-icon">▶</span>
                                    </label>

                                    <div class="sub-content">
                                        
                                        <div class="checkbox-item checkbox-indented series-full-label">
                                            <label class="checkbox-label">
                                                <input type="checkbox" name="series_full[]" value="<?= $serieID ?>"
                                                    <?= in_array($serieID, $filters['series_full']) ? 'checked' : '' ?>>
                                                
                                                <?php if(in_array($serieID, $filters['series_full'])): ?>
                                                    <input type="hidden" name="old_series_full[]" value="<?= $serieID ?>">
                                                <?php endif; ?>
                                                <span class="checkmark"></span>
                                                <span>TOUTE LA SÉRIE</span>
                                            </label>
                                        </div>

                                        <?php foreach($data['extensions'] as $ext): ?>
                                            <div class="checkbox-item checkbox-indented">
                                                <label class="checkbox-label">
                                                    <?php $isChecked = in_array($ext->id, $filters['ext']); ?>
                                                    <input type="checkbox" name="ext[]" value="<?= $ext->id ?>" <?= $isChecked ? 'checked' : '' ?>>
                                                    <span class="checkmark"></span>
                                                    
                                                    <div class="ext-container">
                                                        <span class="ext-name"><?= $ext->nom ?></span>
                                                        <span class="ext-code">(<?= $ext->code ?>)</span>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="filter-accordion">
                    <input type="checkbox" id="toggle-rarete" class="accordion-toggle" <?= !empty($filters['rarete']) ? 'checked' : '' ?>>
                    <label for="toggle-rarete" class="accordion-header">
                        RARETÉ (Cartes) <span class="acc-icon"></span>
                    </label>
                    <div class="accordion-content">
                        <?php 
                            $raretes = ['Commune', 'Unco', 'Holo', 'Double Rare', 'Illu. Rare', 'Ultra Rare', 'Alternative', 'Gold'];
                            foreach($raretes as $r): 
                        ?>
                            <div class="checkbox-item">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="rarete[]" value="<?= $r ?>" <?= in_array($r, $filters['rarete']) ? 'checked' : '' ?>>
                                    <span class="checkmark"></span>
                                    <?= strtoupper($r) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="filter-accordion promo-accordion">
                    <input type="checkbox" id="toggle-promo" class="accordion-toggle" 
                           <?= (!empty($filters['promo']) || !empty($filters['all_promos'])) ? 'checked' : '' ?>>
                    
                    <label for="toggle-promo" class="accordion-header promo-header-style">
                        OFFRES SPÉCIALES <span class="acc-icon"></span>
                    </label>
                    
                    <div class="accordion-content promo-content-style">
                        
                        <div class="checkbox-item checkbox-indented promo-full-label">
                            <label class="checkbox-label">
                                <input type="checkbox" name="all_promos" value="1"
                                    <?= !empty($filters['all_promos']) ? 'checked' : '' ?>>
                                
                                <?php if(!empty($filters['all_promos'])): ?>
                                    <input type="hidden" name="old_all_promos" value="1">
                                <?php endif; ?>

                                <span class="checkmark"></span>
                                <span>TOUT EN PROMO</span>
                            </label>
                        </div>

                        <?php 
                            $tauxList = [0.10, 0.20, 0.30, 0.40, 0.50, 0.70];
                            foreach($tauxList as $taux): 
                        ?>
                            <div class="checkbox-item">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="promo[]" value="<?= $taux ?>" <?= in_array((string)$taux, $filters['promo']) ? 'checked' : '' ?>>
                                    <span class="checkmark"></span>
                                    PROMO <span class="filter-badge-promo">-<?= $taux * 100 ?>%</span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="filter-accordion">
                    <input type="checkbox" id="toggle-tri" class="accordion-toggle" 
                           <?= !empty($filters['tri']) ? 'checked' : '' ?>>
                    
                    <label for="toggle-tri" class="accordion-header">
                        TRIER PAR <span class="acc-icon"></span>
                    </label>
                    
                    <div class="accordion-content">
                        
                        <div class="checkbox-item">
                            <label class="checkbox-label">
                                <input type="radio" name="tri" value="" 
                                       <?= empty($filters['tri']) ? 'checked' : '' ?>>
                                <span class="checkmark"></span>
                                NOUVEAUTÉS
                            </label>
                        </div>

                        <div class="checkbox-item">
                            <label class="checkbox-label">
                                <input type="radio" name="tri" value="promo_desc" 
                                       <?= $filters['tri'] == 'promo_desc' ? 'checked' : '' ?>>
                                <span class="checkmark"></span>
                                MEILLEURES RÉDUCTIONS 🔥
                            </label>
                        </div>

                        <div class="checkbox-item">
                            <label class="checkbox-label">
                                <input type="radio" name="tri" value="pop_desc" 
                                       <?= $filters['tri'] == 'pop_desc' ? 'checked' : '' ?>>
                                <span class="checkmark"></span>
                                BEST SELLERS
                            </label>
                        </div>

                        <div class="checkbox-item">
                            <label class="checkbox-label">
                                <input type="radio" name="tri" value="prix_asc" 
                                       <?= $filters['tri'] == 'prix_asc' ? 'checked' : '' ?>>
                                <span class="checkmark"></span>
                                PRIX CROISSANT
                            </label>
                        </div>

                        <div class="checkbox-item">
                            <label class="checkbox-label">
                                <input type="radio" name="tri" value="prix_desc" 
                                       <?= $filters['tri'] == 'prix_desc' ? 'checked' : '' ?>>
                                <span class="checkmark"></span>
                                PRIX DÉCROISSANT
                            </label>
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn-filter-apply">ACTUALISER</button>
                <a href="<?= base_url('recherche') ?>" class="btn-filter-reset">R.A.Z FILTRES</a>

            </form>
        </aside>

        <section class="search-results">
            <?php if (empty($results)): ?>
                <div class="no-results">
                    <p>AUCUN SIGNAL DÉTECTÉ...</p>
                </div>
            <?php else: ?>
                <div class="results-grid">
                    <?php foreach ($results as $p): ?>
                        <?php 
                            $isPromo = !empty($p->id_promo);
                            $prixFinal = $p->prix;
                            if ($isPromo && isset($p->tauxPromo)) {
                                $prixFinal = $p->prix * (1 - $p->tauxPromo);
                            }
                        ?>
                        <div class="carte <?= $isPromo ? 'carte-promo' : '' ?>">
                            <?php if($isPromo): ?>
                                <div class="badge-promo">-<?= $p->tauxPromo * 100 ?>%</div>
                            <?php endif; ?>

                            <div class="carte-img-container">
                                <img src="<?= base_url('assets/produits/' . $p->image_url) ?>" alt="<?= esc($p->nom) ?>">
                            </div>

                            <div class="tags-row">
                                <span class="tag-left"><?= strtoupper($p->type_produit) ?></span>
                                <span class="tag-right"><?= $p->rarete ? strtoupper($p->rarete) : '---' ?></span>
                            </div>
                            <hr class="separator">
                            <h3><?= esc($p->nom) ?></h3>

                            <div class="prix-container">
                                <?php if($isPromo): ?>
                                    <span class="prix-barre">$<?= number_format($p->prix, 2) ?></span>
                                    <span class="prix-final blink-red">$<?= number_format($prixFinal, 2) ?></span>
                                <?php else: ?>
                                    <span class="prix-final">$<?= number_format($p->prix, 2) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="card-actions">
                                <a href="<?= base_url('produit/detail/'.$p->id) ?>" class="btn-inspect">INSPECT</a>
                                <?php if($p->stock > 0): ?>
                                    <a href="<?= base_url('panier/ajouter/'.$p->id) ?>" class="btn-achat">ADD</a>
                                <?php else: ?>
                                    <span class="btn-soldout">OUT</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

    </div>
</div>
<?= $this->endSection() ?>