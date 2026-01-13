<?= $this->extend('layouts/front_admin') ?>
<?= $this->section('title') ?>GESTIONNAIRE DES PROMOTIONS<?= $this->endSection() ?>

<?= $this->section('contenu') ?>
    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>

    <div class="admin-toolbar">
        <div class="toolbar-filters">
            <form action="<?= base_url('admin/promotions') ?>" method="get" class="filter-form">
                <span class="filter-label">FILTRES :</span>
                <input type="text" name="q" class="filter-input input-w-100" placeholder="ID..." value="<?= esc($filters['q'] ?? '') ?>">
                <select name="statut" class="filter-select">
                    <option value="">TOUS LES STATUTS</option>
                    <option value="active" <?= ($filters['statut'] ?? '') == 'active' ? 'selected' : '' ?>>EN COURS</option>
                    <option value="future" <?= ($filters['statut'] ?? '') == 'future' ? 'selected' : '' ?>>PROGRAMMÉE</option>
                    <option value="expired" <?= ($filters['statut'] ?? '') == 'expired' ? 'selected' : '' ?>>TERMINÉE</option>
                </select>
                <button type="submit" class="filter-btn">RECHERCHER</button>
                <?php if(!empty($filters['statut']) || !empty($filters['q'])): ?>
                    <a href="<?= base_url('admin/promotions') ?>" class="reset-link">REINITIALISER</a>
                <?php endif; ?>
            </form>
        </div>
        <div class="toolbar-actions"><a href="<?= base_url('admin/promotions/ajouter') ?>" class="btn-add-std">+ AJOUTER PROMO</a></div>
    </div>

    <table class="bios-table">
        <thead><tr><th>ID</th><th>TAUX</th><th>DÉBUT</th><th>FIN</th><th>ÉTAT</th><th>ACTIONS</th></tr></thead>
        <tbody>
            <?php if(empty($promotions)): ?>
                <tr><td colspan="6" class="text-center text-yellow" style="padding: 30px; font-size: 24px;">AUCUNE PROMOTION TROUVÉE...</td></tr>
            <?php else: ?>
            <?php foreach($promotions as $p): 
                $now = date('Y-m-d');
                $isExpired = $p->dateFin < $now;
                $isFuture = $p->dateDebut > $now;
            ?>
            <tr class="<?= $isExpired ? 'row-disabled' : '' ?>">
                <td>#<?= $p->idPromo ?></td>
                <td class="text-yellow" style="font-size: 24px;">-<?= intval($p->tauxPromo * 100) ?>%</td>
                <td><?= date('d/m/Y', strtotime($p->dateDebut)) ?></td>
                <td><?= date('d/m/Y', strtotime($p->dateFin)) ?></td>
                <td>
                    <?php if($isExpired): ?> <span class="status-expired">TERMINÉE</span>
                    <?php elseif($isFuture): ?> <span class="status-future">PROGRAMMÉE</span>
                    <?php else: ?> <span class="status-active">EN COURS</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url('admin/promotions/edit/'.$p->idPromo) ?>" class="btn-action btn-edit">MODIFIER</a>
                    <a href="<?= base_url('admin/promotions/delete/'.$p->idPromo) ?>" class="btn-action btn-delete" onclick="return confirm('Supprimer cette promo ?');">X</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="pagination-container" style="margin-top: 20px; display: flex; justify-content: center;">
        <?= $pager->links('default', 'pagination') ?>
    </div>

<?= $this->endSection() ?>