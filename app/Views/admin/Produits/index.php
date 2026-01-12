<?= $this->extend('layouts/front_admin') ?>
<?= $this->section('title') ?>GESTIONNAIRE DES PRODUITS<?= $this->endSection() ?>

<?= $this->section('contenu') ?>
    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>

    <div class="admin-toolbar">
        <div class="toolbar-filters">
            <form action="<?= base_url('admin/produits') ?>" method="get" class="filter-form">
                <span class="filter-label">FILTRES :</span>
                <input type="text" name="q" class="filter-input" placeholder="Nom..." value="<?= esc($filters['q']) ?>">
                <select name="type" class="filter-select">
                    <option value="">TOUS LES TYPES</option>
                    <option value="carte" <?= $filters['type'] == 'carte' ? 'selected' : '' ?>>CARTE</option>
                    <option value="booster" <?= $filters['type'] == 'booster' ? 'selected' : '' ?>>BOOSTER</option>
                    <option value="coffret" <?= $filters['type'] == 'coffret' ? 'selected' : '' ?>>COFFRET</option>
                </select>
                <select name="stock" class="filter-select">
                    <option value="">TOUT LE STOCK</option>
                    <option value="rupture" <?= $filters['stock'] == 'rupture' ? 'selected' : '' ?>>RUPTURE (0)</option>
                    <option value="faible" <?= $filters['stock'] == 'faible' ? 'selected' : '' ?>>FAIBLE (< 5)</option>
                </select>
                <button type="submit" class="filter-btn">RECHERCHER</button>
                <?php if(!empty($filters['q']) || !empty($filters['type']) || !empty($filters['stock'])): ?>
                    <a href="<?= base_url('admin/produits') ?>" class="reset-link">REINITIALISER</a>
                <?php endif; ?>
            </form>
        </div>
        <div class="toolbar-actions"><a href="<?= base_url('admin/produits/ajouter') ?>" class="btn-add-std">+ AJOUTER ITEM</a></div>
    </div>

    <table class="bios-table">
        <thead>
            <tr>
                <th><a href="<?= base_url('admin/produits?sort=id&order='.($filters['order']=='ASC'?'DESC':'ASC')) ?>" class="sort-link">ID <?= $filters['sort']=='id' ? ($filters['order']=='ASC'?'▲':'▼') : '' ?></a></th>
                <th>IMG</th>
                <th><a href="<?= base_url('admin/produits?sort=nom&order='.($filters['order']=='ASC'?'DESC':'ASC')) ?>" class="sort-link">NOM <?= $filters['sort']=='nom' ? ($filters['order']=='ASC'?'▲':'▼') : '' ?></a></th>
                <th>TYPE / RARETÉ</th>
                <th><a href="<?= base_url('admin/produits?sort=prix&order='.($filters['order']=='ASC'?'DESC':'ASC')) ?>" class="sort-link">PRIX <?= $filters['sort']=='prix' ? ($filters['order']=='ASC'?'▲':'▼') : '' ?></a></th>
                <th><a href="<?= base_url('admin/produits?sort=stock&order='.($filters['order']=='ASC'?'DESC':'ASC')) ?>" class="sort-link">STOCK <?= $filters['sort']=='stock' ? ($filters['order']=='ASC'?'▲':'▼') : '' ?></a></th>
                <th><a href="<?= base_url('admin/produits?sort=nb_ventes&order='.($filters['order']=='ASC'?'DESC':'ASC')) ?>" class="sort-link">VENTES <?= $filters['sort']=='nb_ventes' ? ($filters['order']=='ASC'?'▲':'▼') : '' ?></a></th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($produits)): ?>
                <tr><td colspan="8" class="text-center text-yellow" style="padding: 20px;">AUCUN RÉSULTAT TROUVÉ...</td></tr>
            <?php else: ?>
                <?php foreach ($produits as $p): ?>
                <tr>
                    <td>#<?= $p->id ?></td>
                    <td><img src="<?= base_url('assets/produits/'.$p->image_url) ?>" class="td-img-thumb"></td>
                    <td><?= esc($p->nom) ?><?php if($p->id_promo): ?> <span class="badge-promo-mini">PROMO</span><?php endif; ?></td>
                    <td><?= esc($p->type_produit) ?><br><small class="text-gray"><?= esc($p->rarete) ?></small></td>
                    <td class="text-yellow">$<?= esc($p->prix) ?></td>
                    <td style="<?= $p->stock == 0 ? 'color:white; background:red;' : ($p->stock < 5 ? 'color:orange;' : '') ?>"><?= $p->stock ?></td>
                    <td><?= $p->nb_ventes ?></td>
                    <td>
                        <div class="flex-start flex-gap-5">
                            <a href="<?= base_url('admin/produits/edit/'.$p->id) ?>" class="btn-action btn-edit">MODIFIER</a>
                            <a href="<?= base_url('admin/produits/delete/'.$p->id) ?>" class="btn-action btn-delete" onclick="return confirm('SUPPRIMER ?');">X</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>