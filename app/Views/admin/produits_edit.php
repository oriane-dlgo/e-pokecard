<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ADMIN - EDIT PRODUIT</title>
    <link rel="stylesheet" href="<?= base_url('css/style_admin.css') ?>">
<style>
        /* Règle Magique : Inclut les bordures et le padding dans la taille totale */
        * { box-sizing: border-box; }

        .form-group { margin-bottom: 15px; }
        
        label { display: block; margin-bottom: 5px; color: yellow; }
        
        /* On cible TOUS les inputs, selects et textareas pour qu'ils aient exactement le même style */
        input[type="text"], 
        input[type="number"], 
        input[type="file"], 
        select, 
        textarea {
            width: 100%; 
            padding: 8px; 
            background: #000080; 
            color: white;
            border: 2px solid white; 
            font-family: 'VT323', monospace; 
            font-size: 18px;
            outline: none; /* Enlève le contour bleu par défaut du navigateur */
        }

        /* Petit ajustement pour le champ fichier pour qu'il soit plus joli */
        input[type="file"] {
            padding: 5px; /* Un peu moins de padding pour le fichier */
            cursor: pointer;
        }

        /* Focus : Changement de couleur quand on clique dedans (Optionnel mais sympa) */
        input:focus, select:focus, textarea:focus {
            background: #0000AA;
            border-color: yellow;
        }

        textarea { height: 100px; resize: vertical; }
        
        .btn-save {
            background: #008000; color: white; font-weight: bold; font-size: 24px;
            padding: 10px 30px; border: 4px solid white; cursor: pointer; margin-top: 20px;
        }
        .btn-save:hover { background: #00ff00; color: black; }
        
        .current-img { display: block; margin: 10px 0; border: 2px solid yellow; max-width: 150px; }
        
        .bios-container { padding-bottom: 50px; overflow: auto; }
    </style>
</head>
<body>

<div class="bios-container">
    <h1>EDIT DATA: #<?= $p->id ?> - <?= esc($p->nom) ?></h1>

    <a href="<?= base_url('admin/produits') ?>" style="color:white; text-decoration:none;">◄ ANNULER</a>

    <?php if(session()->getFlashdata('error')): ?>
        <div style="background: red; color: white; padding: 10px; text-align: center; border: 2px solid white; margin-top: 20px; font-weight: bold;">
            ⚠️ <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

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
                <option value="display" <?= $p->type_produit == 'display' ? 'selected' : '' ?>>Display</option>
                <option value="ETB" <?= $p->type_produit == 'ETB' ? 'selected' : '' ?>>ETB</option>
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
            <label>RARETÉ (Uniquement pour Type 'Carte')</label>
            <select name="rarete">
                <option value="">--- Aucune ---</option>
                <?php 
                    $raretes = ['Commune', 'Unco', 'Holo', 'Double Rare', 'Illu. Rare', 'Ultra Rare', 'Alternative', 'Gold'];
                    foreach($raretes as $r): 
                ?>
                    <option value="<?= $r ?>" <?= $p->rarete == $r ? 'selected' : '' ?>><?= $r ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>EXTENSION</label>
            <select name="id_extension">
                <option value="">--- Choisir ---</option>
                <?php foreach ($extensions as $ext): ?>
                    <option value="<?= $ext->id ?>" <?= $p->id_extension == $ext->id ? 'selected' : '' ?>>
                        <?= esc($ext->nom_serie) ?> - <?= esc($ext->nom) ?> <?= !empty($ext->code) ? '('.esc($ext->code).')' : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group" style="background: #220000; padding: 10px; border: 1px dashed red;">
            <label style="color: #ff5555;">APPLIQUER UNE PROMOTION</label>
            <select name="id_promo">
                <option value="">--- AUCUNE PROMO ---</option>
                <?php foreach ($promotions as $promo): ?>
                    <option value="<?= $promo->idPromo ?>" <?= $p->id_promo == $promo->idPromo ? 'selected' : '' ?>>
                        -<?= $promo->tauxPromo * 100 ?>% (Fin : <?= date('d/m', strtotime($promo->dateFin)) ?>)
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