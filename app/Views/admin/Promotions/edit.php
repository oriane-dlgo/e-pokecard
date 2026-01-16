<?= $this->extend('layouts/front_admin') ?>
<?= $this->section('title') ?>ADMIN - ÉDITER PROMO<?= $this->endSection() ?>
<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/admin/forms.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>
<div class="bios-container">
    <div class="admin-header">
        <h1>EDIT PROMO #<?= $p->idPromo ?> <a href="<?= base_url('admin/promotions') ?>" class="btn-back">✖ ANNULER</a></h1>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="flash-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('admin/promotions/update') ?>" method="post">
        <input type="hidden" name="idPromo" value="<?= $p->idPromo ?>">
        <div class="data-column container-narrow">
            <h3 class="column-title title-cyan">CONFIGURATION</h3>
            <div class="form-group promo-box">
                <label>POURCENTAGE DE RÉDUCTION (%)</label>
                <input type="number" name="tauxPromo" required min="1" max="90" value="<?= intval($p->tauxPromo * 100) ?>" class="input-promo-rate">
            </div>
            <div class="form-row">
                <div class="form-group"><label>DATE DE DÉBUT</label><input type="date" name="dateDebut" required value="<?= $p->dateDebut ?>"></div>
                <div class="form-group"><label>DATE DE FIN</label><input type="date" name="dateFin" required value="<?= $p->dateFin ?>"></div>
            </div>
        </div>
        <div class="btn-save-wrapper"><button type="submit" class="btn-save"> METTRE À JOUR</button></div>
    </form>
</div>
<?= $this->endSection() ?>