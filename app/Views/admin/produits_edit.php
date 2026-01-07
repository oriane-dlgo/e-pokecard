<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ADMIN - EDIT PRODUIT</title>
    <link rel="stylesheet" href="<?= base_url('css/style_admin.css') ?>">
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: yellow; }
        input[type="text"], input[type="number"], select, textarea {
            width: 100%; padding: 8px; background: #000080; color: white;
            border: 2px solid white; font-family: 'VT323', monospace; font-size: 18px;
        }
        textarea { height: 100px; resize: vertical; }
        .btn-save {
            background: #008000; color: white; font-weight: bold; font-size: 24px;
            padding: 10px 30px; border: 4px solid white; cursor: pointer; margin-top: 20px;
        }
        .btn-save:hover { background: #00ff00; color: black; }
        
        .current-img { display: block; margin: 10px 0; border: 2px solid yellow; max-width: 150px; }
    </style>
</head>
<body>

<div class="bios-container">
    <h1>EDIT DATA: #<?= $p->id ?> - <?= esc($p->nom) ?></h1>

    <a href="<?= base_url('admin/produits') ?>" style="color:white; text-decoration:none;">◄ ANNULER</a>

    <form action="<?= base_url('admin/produits/update') ?>" method="post" enctype="multipart/form-data" style="max-width: 600px; margin: 20px auto;">
        
        <input type="hidden" name="id" value="<?= $p->id ?>">

        <div class="form-group">
            <label>NOM DU PRODUIT</label>
            <input type="text" name="nom" required value="<?= esc($p->nom) ?>">
        </div>

        <div class="form-group">
            <label>TYPE</label>
            <select name="type_produit" required>
                <option value="carte" <?= $p->type_produit == 'carte' ? 'selected' : '' ?>>Carte</option>
                <option value="booster" <?= $p->type_produit == 'booster' ? 'selected' : '' ?>>Booster</option>
                <option value="coffret" <?= $p->type_produit == 'coffret' ? 'selected' : '' ?>>Coffret</option>
                <option value="accessoire" <?= $p->type_produit == 'accessoire' ? 'selected' : '' ?>>Accessoire</option>
            </select>
        </div>

        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex:1;">
                <label>PRIX ($)</label>
                <input type="number" step="0.01" name="prix" required value="<?= esc($p->prix) ?>">
            </div>
            <div class="form-group" style="flex:1;">
                <label>STOCK</label>
                <input type="number" name="stock" required value="<?= esc($p->stock) ?>">
            </div>
        </div>

        <div class="form-group">
            <label>RARETÉ</label>
            <select name="rarete">
                <option value="">--- Aucune ---</option>
                <option value="Commune" <?= $p->rarete == 'Commune' ? 'selected' : '' ?>>Commune</option>
                <option value="Peu Commune" <?= $p->rarete == 'Peu Commune' ? 'selected' : '' ?>>Peu Commune</option>
                <option value="Rare" <?= $p->rarete == 'Rare' ? 'selected' : '' ?>>Rare</option>
                <option value="EX" <?= $p->rarete == 'EX' ? 'selected' : '' ?>>EX / GX / V</option>
                <option value="FA" <?= $p->rarete == 'FA' ? 'selected' : '' ?>>Full Art</option>
                <option value="SAR" <?= $p->rarete == 'SAR' ? 'selected' : '' ?>>SAR / Alt Art</option>
                <option value="Gold" <?= $p->rarete == 'Gold' ? 'selected' : '' ?>>Gold</option>
            </select>
        </div>

        <div class="form-group">
            <label>EXTENSION</label>
            <select name="id_extension">
                <option value="">--- Choisir ---</option>
                <?php foreach ($extensions as $ext): ?>
                    <option value="<?= $ext->id ?>" <?= $p->id_extension == $ext->id ? 'selected' : '' ?>>
                        <?= esc($ext->nom) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>DESCRIPTION</label>
            <textarea name="description"><?= esc($p->description) ?></textarea>
        </div>

        <div class="form-group">
            <label>IMAGE ACTUELLE</label>
            <img src="<?= base_url('assets/produits/'.$p->image_url) ?>" class="current-img">
            
            <label style="color: white; margin-top: 10px;">CHANGER L'IMAGE (Optionnel)</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <div style="text-align: center;">
            <button type="submit" class="btn-save">METTRE À JOUR</button>
        </div>

    </form>
</div>

</body>
</html>