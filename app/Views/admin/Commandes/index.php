<?= $this->extend('layouts/front_admin') ?>
<?= $this->section('title') ?>GESTIONNAIRE DES COMMANDES<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>

    <div class="admin-toolbar">
        <div class="toolbar-filters">
            <form action="<?= base_url('admin/commandes') ?>" method="get" class="filter-form">
                <span class="filter-label">FILTRES :</span>
                <input type="text" name="q" class="filter-input input-w-250" placeholder="Client ou N°..." value="<?= esc($filters['q']) ?>">
                <select name="statut" class="filter-select">
                    <option value="">TOUS STATUTS</option>
                    <option value="validee" <?= $filters['statut'] == 'validee' ? 'selected' : '' ?>>VALIDÉE</option>
                    <option value="expediee" <?= $filters['statut'] == 'expediee' ? 'selected' : '' ?>>EXPÉDIÉE</option>
                    <option value="terminee" <?= $filters['statut'] == 'terminee' ? 'selected' : '' ?>>TERMINÉE</option>
                    <option value="annulee" <?= $filters['statut'] == 'annulee' ? 'selected' : '' ?>>ANNULÉE</option>
                </select>
                <button type="submit" class="filter-btn">SEARCH</button>
                <?php if(!empty($filters['q']) || !empty($filters['statut'])): ?>
                    <a href="<?= base_url('admin/commandes') ?>" class="reset-link">RESET</a>
                <?php endif; ?>
            </form>
        </div>
        <div class="toolbar-actions">
             <a href="<?= base_url('admin/commandes/ajouter') ?>" class="btn-add-std">+ CRÉER COMMANDE</a>
        </div>
    </div>

    <table class="bios-table">
        <thead>
            <tr><th>ID</th><th>CLIENT</th><th>TOTAL</th><th>STATUT</th><th>ACTION</th></tr>
        </thead>
        <tbody>
            <?php if(empty($commandes)): ?>
                <tr><td colspan="5" class="text-center text-yellow" style="padding: 30px; font-size: 24px;">AUCUNE COMMANDE TROUVÉE...</td></tr>
            <?php else: ?>
                <?php foreach ($commandes as $c): ?>
                <tr>
                    <td>#<?= $c->id ?></td>
                    <td><?= esc($c->client_nom) ?><br><small class="text-gray" style="font-size: 0.8em;"><?= esc($c->client_email) ?></small></td>
                    <td class="text-yellow">$<?= number_format($c->total, 2) ?></td>
                    <td>
                        <?php 
                            $badgeClass = 'badge-terminee'; 
                            $badgeText = strtoupper($c->statut);
                            if($c->statut == 'validee')  $badgeClass = 'badge-validee';
                            if($c->statut == 'expediee') $badgeClass = 'badge-expediee';
                            if($c->statut == 'annulee')  $badgeClass = 'badge-annulee';
                            if(empty($c->statut)) { $badgeClass = 'badge-vide'; $badgeText = 'VIDE'; }
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span>
                    </td>
                    <td><a href="<?= base_url('admin/commandes/detail/'.$c->id) ?>" class="btn-detail">VOIR DÉTAIL</a></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>