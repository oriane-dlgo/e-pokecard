<?= $this->extend('layouts/front_admin') ?>
<?= $this->section('title') ?>GESTIONNAIRE DES UTILISATEURS<?= $this->endSection() ?>

<?= $this->section('contenu') ?>
    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>

    <div class="admin-toolbar">
        <div class="toolbar-filters">
            <form action="<?= base_url('admin/users') ?>" method="get" class="filter-form">
                <span class="filter-label">FILTRES :</span>
                <input type="text" name="q" class="filter-input input-w-250" placeholder="Nom, Email..." value="<?= esc($filters['q']) ?>">
                <select name="role" class="filter-select">
                    <option value="">TOUS RÔLES</option>
                    <option value="admin" <?= $filters['role'] == 'admin' ? 'selected' : '' ?>>ADMINISTRATEUR</option>
                    <option value="client" <?= $filters['role'] == 'client' ? 'selected' : '' ?>>CLIENT</option>
                </select>
                <button type="submit" class="filter-btn">SEARCH</button>
                <?php if(!empty($filters['q']) || !empty($filters['role'])): ?>
                    <a href="<?= base_url('admin/users') ?>" class="reset-link">RESET</a>
                <?php endif; ?>
            </form>
        </div>
        <div class="toolbar-actions"><a href="<?= base_url('admin/users/ajouter') ?>" class="btn-add-std">+ CRÉER UTILISATEUR</a></div>
    </div>

    <table class="bios-table">
        <thead><tr><th>ID</th><th>IDENTITÉ</th><th>EMAIL</th><th>RÔLE ACTUEL</th><th>ACTIONS (MODIFIER RÔLE)</th></tr></thead>
        <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
                <td>#<?= $u->id ?></td>
                <td><strong><?= esc($u->nom) ?> <?= esc($u->prenom) ?></strong><br><small>Login : <?= esc($u->login) ?></small></td>
                <td><?= esc($u->email) ?></td>
                <td>
                    <?php if($u->role == 'admin'): ?> <span class="role-badge role-admin">★ ADMIN</span>
                    <?php else: ?> <span class="role-badge role-client">CLIENT</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="flex-start flex-gap-10">
                        <form action="<?= base_url('admin/users/updateRole') ?>" method="post" class="flex-start flex-gap-5 mb-0">
                            <input type="hidden" name="user_id" value="<?= $u->id ?>">
                            <select name="role" class="role-select">
                                <option value="client" <?= $u->role == 'client' ? 'selected' : '' ?>>Client</option>
                                <option value="admin" <?= $u->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                            <button type="submit" class="btn-action btn-edit">OK</button>
                        </form>
                        <a href="<?= base_url('admin/users/delete/'.$u->id) ?>" class="btn-action btn-delete" onclick="return confirm('ATTENTION : Voulez-vous vraiment supprimer cet utilisateur ?');">X</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>