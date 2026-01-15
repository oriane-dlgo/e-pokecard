<?= $this->extend('layouts/front_admin') ?>
<?= $this->section('title') ?>ADMIN - NOUVELLE PROMO<?= $this->endSection() ?>
<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/admin/forms.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>
<div class="bios-container">
    <div class="admin-header">
        <h1>NOUVELLE PROMO <a href="<?= base_url('admin/promotions') ?>" class="btn-back">✖ ANNULER</a></h1>
    </div>

    <?php if(session()->getFlashdata('error')):?>
        <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif;?>

    <form action="<?= base_url('admin/promotions/save') ?>" method="post">
        <div class="admin-grid admin-grid-single"> 
            <div class="data-column container-medium">
                <h3 class="column-title title-cyan">CONFIGURATION DE L'OFFRE</h3>
                <div class="form-group promo-box">
                    <label>POURCENTAGE DE RÉDUCTION (%)</label>
                    <input type="number" name="tauxPromo" required min="1" max="100" placeholder="Ex: 20" class="input-promo-rate">
                </div>
                <div class="form-row">
                    <div class="form-group"><label>DATE DE DÉBUT</label><input type="date" name="dateDebut" required value="<?= date('d-m-Y') ?>"></div>
                    <div class="form-group"><label>DATE DE FIN</label><input type="date" name="dateFin" required></div>
                </div>
            </div>
        </div>
        <div class="btn-save-wrapper"><button type="submit" class="btn-save">✚ ACTIVER LA PROMOTION</button></div>
    </form>
</div>
<?= $this->endSection() ?>