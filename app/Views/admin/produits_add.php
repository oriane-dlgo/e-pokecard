<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ADMIN - AJOUTER PRODUIT</title>
    <link rel="stylesheet" href="<?= base_url('css/style_admin.css') ?>">
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: yellow; }
        input[type="text"], input[type="number"], select, textarea {
            width: 100%;
            padding: 8px;
            background: #000080;
            color: white;
            border: 2px solid white;
            font-family: 'VT323', monospace;
            font-size: 18px;
        }
        textarea { height: 100px; resize: vertical; }
        .btn-save {
            background: #ffff00; color: black; font-weight: bold; font-size: 24px;
            padding: 10px 30px; border: 4px solid white; cursor: pointer;
            margin-top: 20px;
        }
        .btn-save:hover { background: white; }
    </style>
</head>
<body>

<div class="bios-container">
    <h1>NEW DATA ENTRY</h1>

    <a href="<?= base_url('admin/produits') ?>" style="color:white; text-decoration:none;">◄ ANNULER / RETOUR</a>

    <form action="<?= base_url('admin/produits/save') ?>" method="post" enctype="multipart/form-data" style="max-width: 600px; margin: 20px auto;">
        
        <div class="form-group">
            <label>NOM DU PRODUIT</label>
            <input type="text" name="nom" required placeholder="Ex: Dracaufeu Obscur">
        </div>

        <div class="form-group">
            <label>TYPE</label>
            <select name="type_produit" required>
                <option value="carte">Carte</option>
                <option value="booster">Booster</option>
                <option value="coffret">Coffret</option>
                <option value="accessoire">Accessoire</option>
            </select>
        </div>

        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex:1;">
                <label>PRIX ($)</label>
                <input type="number" step="0.01" name="prix" required placeholder="0.00">
            </div>
            <div class="form-group" style="flex:1;">
                <label>STOCK INITIAL</label>
                <input type="number" name="stock" value="1" required>
            </div>
        </div>

        <div class="form-group">
            <label>RARETÉ (Pour les cartes)</label>
            <select name="rarete">
                <option value="">--- Aucune ---</option>
                <option value="Commune">Commune</option>
                <option value="Peu Commune">Peu Commune</option>
                <option value="Rare">Rare</option>
                <option value="EX">EX / GX / V</option>
                <option value="FA">Full Art</option>
                <option value="SAR">SAR / Alt Art</option>
                <option value="Gold">Gold</option>
            </select>
        </div>

        <div class="form-group">
            <label>EXTENSION (Série)</label>
            <select name="id_extension">
                <option value="">--- Choisir une extension ---</option>
                <?php foreach ($extensions as $ext): ?>
                    <option value="<?= $ext->id ?>"><?= esc($ext->nom) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>DESCRIPTION</label>
            <textarea name="description" placeholder="Détails de la carte..."></textarea>
        </div>

        <div class="form-group">
            <label>IMAGE DU PRODUIT</label>
            <input type="file" name="image" accept="image/*" required>
            <small style="color: #ccc;">Formats acceptés : JPG, PNG, WEBP.</small>
        </div>

        <div style="text-align: center;">
            <button type="submit" class="btn-save">ENREGISTRER DANS LA BDD</button>
        </div>

    </form>
</div>

</body>
</html>