<?= $this->extend('layouts/base2') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/profil.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="profil-container">
    <h1>Mon Espace Dresseur</h1>

    <div class="profil-grid">
        <div class="profil-card info-card">
            <h2>Mes Informations</h2>
            <div class="info-row">
                <span class="label">Identifiant :</span>
                <span class="value"><?= esc($user->login) ?></span>
            </div>
            <div class="info-row">
                <span class="label">Nom complet :</span>
                <span class="value"><?= esc($user->prenom . ' ' . $user->nom) ?></span>
            </div>
            <div class="info-row">
                <span class="label">Email :</span>
                <span class="value"><?= esc($user->email) ?></span>
            </div>
            <div class="info-row">
                <span class="label">Rôle :</span>
                <span class="value badge"><?= esc($user->role) ?></span>
            </div>

            <div class="actions">
                <a href="<?= base_url('deconnexion') ?>" class="btn-logout">Se déconnecter</a>
            </div>
        </div>

        <div class="profil-card history-card">
            <h2>Mes Dernières Commandes</h2>
            <p>Aucune commande passée pour le moment.</p>
            </div>
    </div>
</div>

<?= $this->endSection() ?>