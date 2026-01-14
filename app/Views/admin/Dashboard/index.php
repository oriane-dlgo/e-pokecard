<?= $this->extend('layouts/front_admin') ?>

<?= $this->section('title') ?>
    TABLEAU DE BORD
<?= $this->endSection() ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/admin/forms.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

    <div class="dash-grid">
        
        <div class="dash-card">
            <h3 style="margin:0; color:#aaa;">CHIFFRE D'AFFAIRES</h3>
            <div class="dash-number text-green"><?= number_format($ca, 2) ?>€</div>
            <small>Total cumulé</small>
        </div>

        <div class="dash-card" style="<?= $pending > 0 ? 'border-color:red;' : '' ?>">
            <h3 style="margin:0; color:#aaa;">COMMANDES À TRAITER</h3>
            <div class="dash-number <?= $pending > 0 ? 'text-red alert-blink' : 'text-white' ?>">
                <?= $pending ?>
            </div>
            <?php if($pending > 0): ?>
                <a href="<?= base_url('admin/commandes?statut=validee') ?>" style="color:yellow;">VOIR MAINTENANT</a>
            <?php else: ?>
                <small style="color:lime;">Tout est à jour !</small>
            <?php endif; ?>
        </div>

        <div class="dash-card">
            <h3 style="margin:0; color:#aaa;">ALERTE STOCK</h3>
            <div class="dash-number text-yellow"><?= $lowStock ?></div>
            <a href="<?= base_url('admin/produits?stock=faible') ?>" style="color:white; text-decoration:underline;">Produits < 3</a>
        </div>

        <div class="dash-card">
            <h3 style="margin:0; color:#aaa;">UTILISATEURS</h3>
            <div class="dash-number text-cyan"><?= $usersCount ?></div>
            <small>Inscrits au total</small>
        </div>
    </div>

    <div class="admin-panel panel-glass" style="margin-top: 30px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
            <h3 class="panel-title title-white" style="margin:0; border:none;">DERNIÈRES ACTIVITÉS</h3>
            <a href="<?= base_url('admin/commandes') ?>" class="btn-add-std" style="font-size:16px; padding:5px 15px;">TOUT VOIR</a>
        </div>

        <table class="bios-table" style="width:100%;">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>CLIENT</th>
                    <th>DATE</th>
                    <th>TOTAL</th>
                    <th>STATUT</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($latestOrders)): ?>
                    <tr><td colspan="6" style="text-align:center; padding:20px;">Aucune activité récente.</td></tr>
                <?php else: ?>
                    <?php foreach($latestOrders as $ord): ?>
                    <tr>
                        <td>#<?= $ord->id ?></td>
                        <td><?= esc($ord->client_nom) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($ord->date_creation ?? 'now')) ?></td>
                        <td class="text-yellow"><?= number_format($ord->total, 2) ?>€</td>
                        <td>
                            <?php 
                                $color = 'white';
                                if($ord->statut == 'validee') $color = '#00ff00'; // Vert (à traiter)
                                if($ord->statut == 'expediee') $color = 'orange';
                                if($ord->statut == 'annulee') $color = 'red';
                            ?>
                            <span style="color:<?= $color ?>; font-weight:bold;"><?= strtoupper($ord->statut) ?></span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/commandes/detail/'.$ord->id) ?>" style="color:cyan;">DÉTAIL ►</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="admin-panel" style="margin-top: 10px; border-color: #555;">
        <h4 style="font-size:24px; 
        color:#aaa; border-bottom:1px dashed #555; padding-bottom:5px;">RACCOURCIS RAPIDES</h4>
        <div style="display:flex; gap:15px; margin-top:15px;">
            <a href="<?= base_url('admin/produits/ajouter') ?>" class="btn-save" style="width:auto; min-width:auto; font-size:18px;">+ PRODUIT</a>
            <a href="<?= base_url('admin/promotions/ajouter') ?>" class="btn-save" style="width:auto; min-width:auto; font-size:18px; background:#aa0000; border-color:red;">+ PROMOTION</a>
            <a href="<?= base_url('admin/users/ajouter') ?>" class="btn-save" style="width:auto; min-width:auto; font-size:18px; background:#0000aa; border-color:cyan;">+ UTILISATEUR</a>
        </div>
    </div>

<?= $this->endSection() ?>