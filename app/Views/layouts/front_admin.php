<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="<?= base_url('assets/pokeball.png') ?>">

    <link rel="stylesheet" href="<?= base_url("css/admin/style.css") ?>">
    <?= $this->renderSection('css') ?>
    <title>E-POKECARD - ADMIN</title>
</head>
<body>

<div class="bios-container"> 
    
    <h1>
        <div class="header-left">
            <a href="<?= base_url('/') ?>">◄ RETOUR SITE</a>
        </div>

        <div class="header-center">
            ADMINISTRATEUR SYSTÈME<br>
            <span style="color: white; font-size: 0.7em;">
                &gt; <?= $this->renderSection('title') ?>_
            </span>
        </div>

        <div class="header-right">
            Statut du système: <span class="status-blink">EN LIGNE</span>
        </div>
    </h1>

    <div class="admin-nav">
        <?php $uri = service('uri'); ?>
        <a href="<?= base_url('admin/dashboard') ?>" class="<?= $uri->getSegment(2) == 'dashboard' ? 'active' : '' ?>">TABLEAU DE BORD</a>
        <a href="<?= base_url('admin/produits') ?>" class="<?= $uri->getSegment(2) == 'produits' ? 'active' : '' ?>">PRODUITS</a>
        <a href="<?= base_url('admin/promotions') ?>" class="<?= $uri->getSegment(2) == 'promotions' ? 'active' : '' ?>">PROMOTIONS</a>
        <a href="<?= base_url('admin/commandes') ?>" class="<?= $uri->getSegment(2) == 'commandes' ? 'active' : '' ?>">COMMANDES</a>
        <a href="<?= base_url('admin/users') ?>" class="<?= $uri->getSegment(2) == 'users' ? 'active' : '' ?>">UTILISATEURS</a>
    </div>

    <?= $this->renderSection('contenu') ?>

</div> 
</body>
</html>