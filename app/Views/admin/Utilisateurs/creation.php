<?= $this->extend('layouts/front_admin') ?>
<?= $this->section('title') ?>ADMIN - NOUVEL UTILISATEUR<?= $this->endSection() ?>
<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/admin/forms.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>
<div class="bios-container">
    <div class="admin-header">
        <h1 class="header-title-large mb-0 text-yellow">NOUVEL UTILISATEUR <a href="<?= base_url('admin/users') ?>" class="btn-back flex-shrink-0">✖ ANNULER</a></h1>
    </div>

    <?php if(session()->getFlashdata('error')):?>
        <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif;?>

    <form action="<?= base_url('admin/users/save') ?>" method="post">
        <div class="admin-grid">
            <div class="data-column" style="grid-column: span 2;"> 
                <h3 class="column-title title-cyan">IDENTITÉ & CONNEXION</h3>
                <div class="form-row">
                    <div class="form-group"><label>IDENTIFIANT (LOGIN)</label><input type="text" name="login" required value="<?= old('login') ?>"></div>
                    <div class="form-group"><label>MOT DE PASSE</label><input type="password" name="password" required></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>NOM</label><input type="text" name="nom" required value="<?= old('nom') ?>"></div>
                    <div class="form-group"><label>PRÉNOM</label><input type="text" name="prenom" required value="<?= old('prenom') ?>"></div>
                </div>
                <div class="form-group"><label>EMAIL</label><input type="email" name="email" required value="<?= old('email') ?>"></div>

                <h3 class="column-title title-yellow mt-20">ADRESSE & RÔLE</h3>
                
                <div class="form-group"><label>ADRESSE POSTALE</label><input type="text" name="adresse" value="<?= old('adresse') ?>"></div>
                <div class="form-row">
                    <div class="form-group"><label>CODE POSTAL</label><input type="text" name="cp" value="<?= old('cp') ?>"></div>
                    <div class="form-group"><label>VILLE</label><input type="text" name="ville" value="<?= old('ville') ?>"></div>
                </div>
                <div class="form-group promo-box">
                    <label>RÔLE SYSTÈME</label>
                    <select name="role">
                        <option value="client">CLIENT (Standard)</option>
                        <option value="admin">ADMINISTRATEUR (Accès total)</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="btn-save-wrapper"><button type="submit" class="btn-save">✚ CRÉER L'UTILISATEUR</button></div>
    </form>
</div>
<?= $this->endSection() ?>