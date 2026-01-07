<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ADMIN - GESTION PRODUITS</title>
    <link rel="stylesheet" href="<?= base_url('css/style_admin.css') ?>">
</head>
<body>

<div class="bios-container">
    <h1>DATABASE MANAGEMENT : PRODUITS</h1>
    
    <div class="admin-nav">
        <a href="<?= base_url('admin') ?>">DASHBOARD</a>
        <a href="<?= base_url('admin/produits') ?>" class="active">PRODUITS</a>
        <a href="<?= base_url('admin/commandes') ?>">COMMANDES</a>
        <a href="<?= base_url('admin/users') ?>">UTILISATEURS</a>
    </div>

    <?php if(session()->getFlashdata('msg')): ?>
        <div style="background: green; color: white; padding: 10px; text-align: center; border: 2px solid white; margin-bottom: 20px;">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="<?= base_url('admin/produits/ajouter') ?>" class="btn-add" style="margin: 0;">+ AJOUTER ITEM</a>
        
        <form action="<?= base_url('admin/produits') ?>" method="get" class="admin-search-bar">
            <span>FILTRES :</span>
            
            <input type="text" name="q" placeholder="Nom..." value="<?= esc($filters['q']) ?>">
            
            <select name="type">
                <option value="">ALL TYPES</option>
                <option value="carte" <?= $filters['type'] == 'carte' ? 'selected' : '' ?>>CARTE</option>
                <option value="booster" <?= $filters['type'] == 'booster' ? 'selected' : '' ?>>BOOSTER</option>
                <option value="coffret" <?= $filters['type'] == 'coffret' ? 'selected' : '' ?>>COFFRET</option>
            </select>

            <select name="stock">
                <option value="">ALL STOCKS</option>
                <option value="rupture" <?= $filters['stock'] == 'rupture' ? 'selected' : '' ?>>RUPTURE (0)</option>
                <option value="faible" <?= $filters['stock'] == 'faible' ? 'selected' : '' ?>>FAIBLE (< 5)</option>
            </select>

            <button type="submit">SEARCH</button>
            
            <?php if(!empty($filters['q']) || !empty($filters['type']) || !empty($filters['stock'])): ?>
                <a href="<?= base_url('admin/produits') ?>">RESET</a>
            <?php endif; ?>
        </form>
    </div>

    <table class="bios-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>IMG</th>
                <th>NOM</th>
                <th>TYPE</th>
                <th>PRIX</th>
                <th>STOCK</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($produits)): ?>
                <tr>
                    <td colspan="7" style="text-align:center; padding: 20px; color: yellow;">
                        AUCUN RÉSULTAT TROUVÉ...
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($produits as $p): ?>
                <tr>
                    <td>#<?= $p->id ?></td>
                    <td>
                        <img src="<?= base_url('assets/produits/'.$p->image_url) ?>" style="height: 40px; border: 1px solid white;">
                    </td>
                    <td><?= esc($p->nom) ?></td>
                    <td><?= esc($p->type_produit) ?></td>
                    <td style="color: yellow;">$<?= esc($p->prix) ?></td>
                    
                    <td style="<?= $p->stock == 0 ? 'color:white; background:red; font-weight:bold;' : 
                        ($p->stock < 5 ? 'color:orange;' : 
                        ($p->stock > 15 ? 'color:white; background:green;' : ''))?>">
                        <?= $p->stock ?>
                    </td>

                    <td>
                        <a href="<?= base_url('admin/produits/edit/'.$p->id) ?>" class="btn-action btn-edit">EDIT</a>
                        
                        <a href="<?= base_url('admin/produits/delete/'.$p->id) ?>" 
                           class="btn-action btn-delete"
                           onclick="return confirm('CONFIRM DELETION ? Cette action est irréversible !');">
                           DEL
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>