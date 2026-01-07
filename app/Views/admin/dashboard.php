<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ADMIN PANEL - BIOS V1.0</title>
    <link rel="stylesheet" href="<?= base_url('css/style_admin.css') ?>">
</head>
<body>

<div class="bios-container">
    <h1>PKMN TRADER - SYSTEM ADMINISTRATOR</h1>
    
    <div class="admin-nav">
        <a href="<?= base_url('admin') ?>" class="active">DASHBOARD</a>
        <a href="<?= base_url('admin/produits') ?>">PRODUITS</a>
        <a href="<?= base_url('admin/commandes') ?>">COMMANDES</a>
        <a href="<?= base_url('admin/users') ?>">UTILISATEURS</a>
    </div>

    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
         </div>

    <div style="text-align: center; margin-top: 50px;">
        <p>SYSTEM STATUS: ONLINE</p>
        <a href="<?= base_url('/') ?>" style="color:white;">◄ RETOUR AU SITE</a>
    </div>
</div>

</body>
</html>