<?= $this->extend('layouts/front_admin') ?>
<?= $this->section('title') ?>ADMIN - ÉDITER PRODUIT<?= $this->endSection() ?>
<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/admin/forms.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>
<div class="bios-container">
    <div class="admin-header header-flex-container">
        <div class="header-item-fixed"><h1>MODIFIER #<?= $p->id ?></h1></div>
        <div class="header-item-fluid">
            <div class="product-name-container"><span class="product-name-text"><?= esc($p->nom) ?></span></div>
        </div>
        <div class="header-item-fixed"><a href="<?= base_url('admin/produits') ?>" class="btn-back">✖ ANNULER</a></div>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="flash-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('admin/produits/update') ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $p->id ?>">

        <div class="admin-grid">
            <div class="data-column">
                <h3 class="column-title title-cyan">INFORMATIONS PRODUIT</h3>
                <div class="form-group"><label>NOM DU PRODUIT</label><input type="text" name="nom" required value="<?= esc($p->nom) ?>"></div>
                
                <div class="form-row">
                    <div class="form-group"><label>TYPE</label>
                        <select name="type_produit" required>
                            <?php foreach(['carte','booster','coffret','display','ETB','accessoire'] as $t): ?>
                                <option value="<?= $t ?>" <?= $p->type_produit == $t ? 'selected' : '' ?>><?= strtoupper($t) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group"><label>RARETÉ (Cartes)</label>
                        <select name="rarete">
                            <option value="">--- Aucune ---</option>
                            <?php foreach(['Commune','Unco','Holo','Double Rare','Illu. Rare','Ultra Rare','Alternative','Gold'] as $r): ?>
                                <option value="<?= $r ?>" <?= $p->rarete == $r ? 'selected' : '' ?>><?= $r ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group"><label>PRIX (€)</label><input type="number" step="0.01" name="prix" required value="<?= esc($p->prix) ?>"min="0"></div>
                    <div class="form-group"><label>STOCK</label><input type="number" name="stock" required value="<?= esc($p->stock) ?>" min="0"></div>
                </div>
                <div class="form-group">
                    <label>EXTENSION / SÉRIE</label>
                    <select name="id_extension">
                        <option value="">--- Choisir ---</option>
                        <?php foreach ($extensions as $ext): ?>
                            <option value="<?= $ext->id ?>" <?= $p->id_extension == $ext->id ? 'selected' : '' ?>>
                                <?= esc($ext->nom_serie) ?> - <?= esc($ext->nom) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group promo-box">
                    <label>PROMOTION ACTIVE</label>
                    <select name="id_promo">
                        <option value="">--- AUCUNE PROMO ---</option>
                        <?php foreach ($promotions as $promo): ?>
                            <option value="<?= $promo->idPromo ?>" <?= $p->id_promo == $promo->idPromo ? 'selected' : '' ?>>
                                -<?= $promo->tauxPromo * 100 ?>% (Fin : <?= date('d/m', strtotime($promo->dateFin)) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group"><label>DESCRIPTION</label><textarea name="description"><?= esc($p->description) ?></textarea></div>
            </div>

            <div class="media-column">
                <h3 class="column-title title-yellow">GESTION MEDIA</h3>
                <div class="preview-box">
                    <div class="preview-left">
                        <img id="main-preview" src="<?= base_url('assets/produits/'.$p->image_url) ?>">
                        <div id="preview-name">IMAGE ACTUELLE</div>
                    </div>
                    <div class="preview-right">
                        <label class="label-yellow label-small">TELECHARGER :</label>
                        <input type="file" name="image" accept="image/*" onchange="previewUpload(this)" class="input-file-custom">
                    </div>
                </div>

                <label class="label-yellow">OU SÉLECTIONNER DANS LA BIBLIOTHÈQUE :</label>
                <div class="gallery-wrapper">
                    <div class="gallery-item">
                        <input type="radio" name="existing_image" id="keep_current" value="" checked onclick="updatePreview('<?= base_url('assets/produits/'.$p->image_url) ?>', 'ACTUELLE')">
                        <label for="keep_current" title="Garder l'actuelle">
                            <img src="<?= base_url('assets/produits/'.$p->image_url) ?>" class="img-current-selection">
                        </label>
                    </div>
                    <?php foreach ($existing_images as $img): ?>
                        <?php if($img == $p->image_url) continue; ?>
                        <div class="gallery-item">
                            <input type="radio" name="existing_image" id="img_<?= md5($img) ?>" value="<?= $img ?>" onclick="updatePreview('<?= base_url('assets/produits/'.$img) ?>', '<?= $img ?>')">
                            <label for="img_<?= md5($img) ?>"><img src="<?= base_url('assets/produits/'.$img) ?>" loading="lazy"></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div> 
        <div class="btn-save-wrapper"><button type="submit" class="btn-save"> METTRE À JOUR</button></div>
    </form>
</div>
<script>
    function updatePreview(url, name) {
        document.getElementById('main-preview').src = url;
        const nameEl = document.getElementById('preview-name');
        nameEl.innerText = name;
        nameEl.style.color = "lime";
        document.querySelector('input[type="file"]').value = '';
    }
    function previewUpload(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('main-preview').src = e.target.result;
                const nameEl = document.getElementById('preview-name');
                nameEl.innerText = "NOUVEAU FICHIER (Non sauvegardé)";
                nameEl.style.color = "orange";
                var radios = document.getElementsByName('existing_image');
                for(var i=0; i<radios.length; i++) radios[i].checked = false;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>
