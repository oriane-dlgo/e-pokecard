<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ADMIN - ORDER #<?= $c->id ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style_admin.css') ?>">
    <style>
        .order-info { display: flex; gap: 20px; margin-bottom: 30px; border-bottom: 2px solid white; padding-bottom: 20px; }
        .info-box { flex: 1; background: rgba(255,255,255,0.1); padding: 15px; border: 1px solid white; }
        .info-box h3 { color: yellow; margin-top: 0; border-bottom: 1px dashed white; }
        
        .status-form { background: #000040; padding: 15px; border: 2px solid yellow; text-align: center; margin-top: 20px;}
        .status-select { padding: 10px; font-size: 20px; font-family: 'VT323'; background: black; color: white; border: 2px solid white; }
    </style>
</head>
<body>

<div class="bios-container">
    <h1>ORDER DETAILS: #<?= $c->id ?></h1>
    
    <a href="<?= base_url('admin/commandes') ?>" style="color:white; text-decoration:none;">◄ RETOUR AUX COMMANDES</a>

    <?php if(session()->getFlashdata('msg')): ?>
        <div style="background: green; color: white; padding: 10px; text-align: center; border: 2px solid white; margin-top: 15px;">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>

    <div class="order-info" style="margin-top: 20px;">
        <div class="info-box">
            <h3>CLIENT</h3>
            <p><strong>NOM :</strong> <?= esc($c->nom) ?></p>
            <p><strong>EMAIL :</strong> <?= esc($c->email) ?></p>
            <p><strong>ADRESSE :</strong> <?= esc($c->adresse) ?></p>
        </div>
        <div class="info-box">
            <h3>COMMANDE</h3>
            <p><strong>TOTAL :</strong> <span style="color:yellow; font-size: 24px;">$<?= $c->total ?></span></p>
            
            <p><strong>STATUT ACTUEL :</strong> 
                <?php if(!empty($c->statut)): ?>
                    <span style="color: cyan;"><?= strtoupper($c->statut) ?></span>
                <?php else: ?>
                    <span style="color: red;">NON DÉFINI</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <h3>LISTE DES ITEMS</h3>
    <table class="bios-table">
        <thead>
            <tr>
                <th>IMG</th>
                <th>PRODUIT</th>
                <th>TYPE</th>
                <th>PRIX UNIT.</th>
                <th>QTE</th>
                <th>SOUS-TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lignes as $ligne): ?>
            <tr>
                <td><img src="<?= base_url('assets/produits/'.$ligne->image_url) ?>" style="height: 50px; border: 1px solid white;"></td>
                <td><?= esc($ligne->nom) ?></td>
                <td><?= esc($ligne->type_produit) ?></td>
                <td>$<?= $ligne->prix_unitaire ?></td>
                <td>x <?= $ligne->quantite ?></td>
                <td style="color: yellow;">$<?= $ligne->prix_unitaire * $ligne->quantite ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="status-form">
        <form action="<?= base_url('admin/commandes/updateStatut') ?>" method="post">
            <input type="hidden" name="id_commande" value="<?= $c->id ?>">
            
            <label style="color:yellow; font-size: 24px;">METTRE À JOUR LE STATUT : </label>
            
            <select name="statut" class="status-select">
                <option value="validee" <?= $c->statut == 'validee' ? 'selected' : '' ?>>
                    VALIDÉE <?= $c->statut == 'validee' ? '(ACTUEL)' : '' ?>
                </option>
                <option value="expediee" <?= $c->statut == 'expediee' ? 'selected' : '' ?>>
                    EXPÉDIÉE <?= $c->statut == 'expediee' ? '(ACTUEL)' : '' ?>
                </option>
                <option value="terminee" <?= $c->statut == 'terminee' ? 'selected' : '' ?>>
                    TERMINÉE <?= $c->statut == 'terminee' ? '(ACTUEL)' : '' ?>
                </option>
                <option value="annulee" <?= $c->statut == 'annulee' ? 'selected' : '' ?>>
                    ANNULÉE <?= $c->statut == 'annulee' ? '(ACTUEL)' : '' ?>
                </option>
            </select>

            <button type="submit" class="btn-add" style="display:inline-block; margin-left: 20px; font-size: 20px;">UPDATE</button>
        </form>
    </div>

</div>

</body>
</html>