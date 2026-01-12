<?= $this->extend('layouts/front_admin') ?>

<?= $this->section('title') ?>
    ADMIN - NOUVEAU PRODUIT
<?= $this->endSection() ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/admin/forms.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="bios-container">
    
    <div class="admin-header">
        <h1>NOUVEAU PRODUIT
            <a href="<?= base_url('admin/produits') ?>" class="btn-back">✖ ANNULER</a>
        </h1>
        
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="flash-error">
             <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/produits/save') ?>" method="post" enctype="multipart/form-data">
        
        <div class="admin-grid">
            
            <div class="data-column">
                <h3 class="column-title title-cyan">DETAILS</h3>
                
                <div class="form-group">
                    <label>NOM</label>
                    <input type="text" name="nom" required placeholder="Ex: Dracaufeu Ex" value="<?= old('nom') ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>TYPE</label>
                        <select name="type_produit" required>
                            <option value="carte">Carte</option>
                            <option value="booster">Booster</option>
                            <option value="coffret">Coffret</option>
                            <option value="accessoire">Accessoire</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>RARETÉ</label>
                        <select name="rarete">
                            <option value="">--- Aucune ---</option>
                            <?php foreach(['Commune','Unco','Holo','Double Rare','Illu. Rare','Ultra Rare','Alternative','Gold'] as $r): ?>
                                <option value="<?= $r ?>"><?= $r ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>PRIX ($)</label>
                        <input type="number" step="0.01" name="prix" required placeholder="0.00" value="<?= old('prix') ?>">
                    </div>
                    <div class="form-group">
                        <label>STOCK</label>
                        <input type="number" name="stock" required value="<?= old('stock', 10) ?>" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label>EXTENSION</label>
                    <select name="id_extension">
                        <option value="">--- Choisir ---</option>
                        <?php foreach ($extensions as $ext): ?>
                            <option value="<?= $ext->id ?>">
                                <?= esc($ext->nom_serie ?? '') ?> - <?= esc($ext->nom) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group promo-box">
                    <label>PROMOTION</label>
                    <select name="id_promo">
                        <option value="">--- AUCUNE ---</option>
                        <?php foreach ($promotions as $promo): ?>
                            <option value="<?= $promo->idPromo ?>">
                                -<?= $promo->tauxPromo * 100 ?>%
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>DESCRIPTION</label>
                    <textarea name="description"><?= old('description') ?></textarea>
                </div>
            </div>

            <div class="media-column">
                <h3 class="column-title title-yellow">VISUEL</h3>

                <div class="preview-box">
                    <div class="preview-left">
                        <img id="main-preview" src="<?= base_url('assets/produits/default.png') ?>">
                        <div id="preview-name">Aucune sélection</div>
                    </div>
                    <div class="preview-right">
                        <label class="label-yellow label-small">TELECHARGER :</label>
                        <input type="file" name="image" accept="image/*" onchange="previewUpload(this)" class="input-file-custom">
                    </div>
                </div>

                <label class="label-yellow">OU BIBLIOTHÈQUE :</label>
                <div class="gallery-wrapper">
                    <?php foreach ($existing_images as $img): ?>
                        <div class="gallery-item">
                            <input type="radio" name="existing_image" id="img_<?= md5($img) ?>" value="<?= $img ?>"
                                   onclick="updatePreview('<?= base_url('assets/produits/'.$img) ?>', '<?= $img ?>')">
                            <label for="img_<?= md5($img) ?>">
                                <img src="<?= base_url('assets/produits/'.$img) ?>" loading="lazy">
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <div class="btn-save-wrapper">
            <button type="submit" class="btn-save">✚ CRÉER PRODUIT</button>
        </div>

    </form>
</div>

<script>
    function updatePreview(url, name) {
        document.getElementById('main-preview').src = url;
        const nameEl = document.getElementById('preview-name');
        nameEl.innerText = name;
        nameEl.style.color = "lime"; // Le style dynamique reste en JS
        document.querySelector('input[type="file"]').value = '';
    }

    function previewUpload(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('main-preview').src = e.target.result;
                const nameEl = document.getElementById('preview-name');
                nameEl.innerText = "NOUVEAU FICHIER";
                nameEl.style.color = "orange";
                
                var radios = document.getElementsByName('existing_image');
                for(var i=0; i<radios.length; i++) radios[i].checked = false;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?= $this->endSection() ?>