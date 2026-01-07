<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ADMIN - COMMANDES</title>
    <link rel="stylesheet" href="<?= base_url('css/style_admin.css') ?>">
    <style>
        .badge { padding: 5px 10px; color: white; font-weight: bold; border: 1px solid white; }
        .badge-validee { background: #008000; } 
        .badge-expediee { background: #ffa500; color: black; } 
        .badge-terminee { background: #808080; } 
        .badge-annulee { background: #ff0000; } 
    </style>
</head>
<body>

<div class="bios-container">
    <h1>ORDER TRACKING SYSTEM</h1>
    
    <div class="admin-nav">
        <a href="<?= base_url('admin') ?>">DASHBOARD</a>
        <a href="<?= base_url('admin/produits') ?>">PRODUITS</a>
        <a href="<?= base_url('admin/commandes') ?>" class="active">COMMANDES</a>
        <a href="<?= base_url('admin/users') ?>">UTILISATEURS</a>
    </div>

    <?php if(session()->getFlashdata('msg')): ?>
        <div style="background: green; color: white; padding: 10px; text-align: center; border: 2px solid white; margin-bottom: 20px;">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/commandes') ?>" method="get" class="admin-search-bar" style="margin-bottom: 20px;">
        <span style="color: yellow;">FILTRES :</span>
        
        <input type="text" name="q" placeholder="Client ou N°..." value="<?= esc($filters['q']) ?>" style="width: 250px;">
        
        <select name="statut">
            <option value="">TOUS STATUTS</option>
            <option value="validee" <?= $filters['statut'] == 'validee' ? 'selected' : '' ?>>VALIDÉE</option>
            <option value="expediee" <?= $filters['statut'] == 'expediee' ? 'selected' : '' ?>>EXPÉDIÉE</option>
            <option value="terminee" <?= $filters['statut'] == 'terminee' ? 'selected' : '' ?>>TERMINÉE</option>
            <option value="annulee" <?= $filters['statut'] == 'annulee' ? 'selected' : '' ?>>ANNULÉE</option>
        </select>

        <button type="submit">SEARCH</button>
        
        <?php if(!empty($filters['q']) || !empty($filters['statut'])): ?>
            <a href="<?= base_url('admin/commandes') ?>">RESET</a>
        <?php endif; ?>
    </form>

    <table class="bios-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>CLIENT</th>
                <th>TOTAL</th>
                <th>STATUT</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($commandes)): ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding: 30px; color: yellow; font-size: 24px;">
                        AUCUNE COMMANDE TROUVÉE...
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($commandes as $c): ?>
                <tr>
                    <td>#<?= $c->id ?></td>
                    <td>
                        <?= esc($c->client_nom) ?><br>
                        <small style="font-size: 0.8em; color: #ccc;"><?= esc($c->client_email) ?></small>
                    </td>
                    <td style="color: yellow;">$<?= number_format($c->total, 2) ?></td>
                    
                    <td>
                        <?php 
                            $badgeClass = 'badge-terminee';
                            $badgeText = 'INCONNU';

                            if (!empty($c->statut)) {
                                $badgeText = strtoupper($c->statut);
                                if($c->statut == 'validee') $badgeClass = 'badge-validee';
                                if($c->statut == 'expediee') $badgeClass = 'badge-expediee';
                                if($c->statut == 'annulee') $badgeClass = 'badge-annulee';
                            } else {
                                $badgeText = "VIDE";
                                $badgeClass = "badge-annulee"; 
                            }
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span>
                    </td>

                    <td>
                        <a href="<?= base_url('admin/commandes/detail/'.$c->id) ?>" class="btn-action btn-add" style="font-size: 16px; margin:0; width:auto; display:inline-block;">
                            VOIR DÉTAIL
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