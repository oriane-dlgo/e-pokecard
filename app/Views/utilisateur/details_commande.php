<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/pages/profil.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/panier.css') ?>"> 
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="profil-container">
    
    <div class="trainer-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h1>COMMANDE #<?= str_pad($commande->id, 4, '0', STR_PAD_LEFT) ?></h1>
        <a href="<?= base_url('profil') ?>" class="btn-retro">RETOUR AU PROFIL</a>
    </div>

    <div class="profil-card info-card" style="margin-bottom: 2rem;">
        <div class="card-title">INFORMATIONS</div>
        <div class="info-list" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; padding: 1rem;">
            <div class="info-row">
                <span class="label">DATE :</span>
                <span class="value"><?= date('d/m/Y H:i', strtotime($commande->date_creation)) ?></span>
            </div>
            <div class="info-row">
                <span class="label">TOTAL :</span>
                <span class="value"><?= number_format($commande->total, 2) ?> €</span>
            </div>
            <div class="info-row">
                <span class="label">STATUT :</span>
                <?php if ($commande->statut != "") :?>
                    <span class="value badge-retro"><?= strtoupper($commande->statut) ?></span>
                <?php endif; ?>
                ---
            </div>
            <div class="info-row">
                <span class="label">PAIEMENT :</span>
                <span class="value"><?= strtoupper($commande->type_paiement ?? 'Non défini') ?></span>
            </div>
        </div>
    </div>

    <div class="profil-card history-card">
        <div class="card-title">CONTENU DU COLIS</div>
        
        <?= view('partials/tableau_articles', [
            'items' => $lignes, 
            'editable' => false // Mode Lecture seule
        ]) ?>
        
        <<div class="total-display">
                TOTAL: <?= number_format($commande->total, 2) ?>€ 
            </div>
    </div>

</div>

<?= $this->endSection() ?>