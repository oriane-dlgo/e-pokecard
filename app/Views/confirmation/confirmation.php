<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/pages/confirmation.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="confirm-container">
    <div class="success-icon">★ MISSION COMPLETE ★</div>
    <h1 class="order-title">COMMANDE VALIDÉE</h1>

    <p style="font-size: 20px;">Merci dresseur ! Vos objets seront livrés par Pidgey Express.</p>

    <div class="receipt-box">
        <div style="text-align:center; margin-bottom:10px;">--- REÇU DE TRANSACTION ---</div>
        
        <div class="receipt-row">
            <span>NO. COMMANDE:</span>
            <span>#<?= str_pad($commande->id, 6, '0', STR_PAD_LEFT) ?></span>
        </div>
        <div class="receipt-row">
            <span>DATE:</span>
            <span><?= date('d/m/Y H:i', strtotime($commande->date_creation)) ?></span>
        </div>

        <div style="margin-top: 15px; font-weight:bold; border-bottom: 2px solid black;">ITEMS:</div>
        
        <?php foreach ($lignes as $ligne): ?>
        <div class="receipt-row">
            <span><?= esc($ligne->nom) ?> (x<?= $ligne->quantite ?>)</span>
            <span>$<?= number_format($ligne->prix_unitaire * $ligne->quantite, 2) ?></span>
        </div>
        <?php endforeach; ?>

        <div class="receipt-total">
            <span>TOTAL PAYÉ:</span>
            <span style="color:#D32F2F;">$<?= esc($commande->total) ?></span>
        </div>
    </div>

    <a href="<?= base_url('/') ?>" class="btn-home">RETOUR ACCUEIL</a>
</div>

<?= $this->endSection() ?>