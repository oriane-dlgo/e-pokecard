<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ADMIN - USERS</title>
    <link rel="stylesheet" href="<?= base_url('css/style_admin.css') ?>">
    <style>
        .role-badge { font-weight: bold; padding: 2px 5px; }
        .role-admin { color: yellow; text-shadow: 1px 1px 0 #000; }
        .role-client { color: #00ff00; } /* Vert fluo */
        
        .role-select {
            background: black; color: white; border: 1px solid white; 
            font-family: 'VT323'; font-size: 16px;
        }
    </style>
</head>
<body>

<div class="bios-container">
    <h1>USER DATABASE</h1>
    
    <div class="admin-nav">
        <a href="<?= base_url('admin') ?>">DASHBOARD</a>
        <a href="<?= base_url('admin/produits') ?>">PRODUITS</a>
        <a href="<?= base_url('admin/commandes') ?>">COMMANDES</a>
        <a href="<?= base_url('admin/users') ?>" class="active">UTILISATEURS</a>
    </div>

    <?php if(session()->getFlashdata('msg')): ?>
        <div style="background: green; color: white; padding: 10px; text-align: center; border: 2px solid white; margin-bottom: 20px;">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div style="background: red; color: white; padding: 10px; text-align: center; border: 2px solid white; margin-bottom: 20px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/users') ?>" method="get" class="admin-search-bar">
        <span style="color: yellow;">FILTRES :</span>
        
        <input type="text" name="q" placeholder="Nom, Email..." value="<?= esc($filters['q']) ?>" style="width: 250px;">
        
        <select name="role">
            <option value="">TOUS RÔLES</option>
            <option value="admin" <?= $filters['role'] == 'admin' ? 'selected' : '' ?>>ADMINISTRATEUR</option>
            <option value="client" <?= $filters['role'] == 'client' ? 'selected' : '' ?>>CLIENT</option>
        </select>

        <button type="submit">SEARCH</button>
        
        <?php if(!empty($filters['q']) || !empty($filters['role'])): ?>
            <a href="<?= base_url('admin/users') ?>">RESET</a>
        <?php endif; ?>
    </form>

    <table class="bios-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>IDENTITÉ</th>
                <th>EMAIL</th>
                <th>ADRESSE</th>
                <th>RÔLE ACTUEL</th>
                <th>ACTIONS (MODIFIER RÔLE)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
                <td>#<?= $u->id ?></td>
                <td>
                    <strong><?= esc($u->nom) ?> <?= esc($u->prenom) ?></strong><br>
                    <small>Identifiant : <?= esc($u->login) ?></small>
                </td>
                <td><?= esc($u->email) ?></td>
                <td style="font-size: 0.8em;"><?= esc($u->adresse) ?></td>
                
                <td>
                    <?php if($u->role == 'admin'): ?>
                        <span class="role-badge role-admin">★ ADMIN</span>
                    <?php else: ?>
                        <span class="role-badge role-client">CLIENT</span>
                    <?php endif; ?>
                </td>

                <td>
                    <div style="display: flex; align-items: center; gap: 10px; height: 100%;">
                        
                        <form action="<?= base_url('admin/users/updateRole') ?>" method="post" style="display:flex; gap:5px; margin:0;">
                            <input type="hidden" name="user_id" value="<?= $u->id ?>">
                            <select name="role" class="role-select">
                                <option value="client" <?= $u->role == 'client' ? 'selected' : '' ?>>Client</option>
                                <option value="admin" <?= $u->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                            <button type="submit" class="btn-action btn-edit" style="cursor:pointer;">OK</button>
                        </form>

                        <a href="<?= base_url('admin/users/delete/'.$u->id) ?>" 
                           class="btn-action btn-delete"
                           onclick="return confirm('ATTENTION : Voulez-vous vraiment bannir/supprimer cet utilisateur ?');">
                           X
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>