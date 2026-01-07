<?= $this->extend('layouts/base_retro') ?>

<?= $this->section('css') ?>
<style>
    .confirm-container {
        max-width: 600px;
        margin: 40px auto;
        background: #e0e0e0;
        border: 4px solid #111;
        padding: 20px;
        box-shadow: 10px 10px 0px rgba(0,0,0,0.5);
        text-align: center;
        font-family: 'VT323', monospace;
    }
    .success-icon { font-size: 60px; color: #2ecc71; text-shadow: 2px 2px 0px black; }
    .order-title { font-size: 40px; text-transform: uppercase; border-bottom: 2px dashed #555; margin-bottom: 20px; }
    
    .receipt-box {
        background: #fff;
        border: 2px solid #555;
        padding: 15px;
        text-align: left;
        margin-bottom: 20px;
        font-size: 20px;
    }
    .receipt-row { display: flex; justify-content: space-between; border-bottom: 1px dotted #ccc; padding: 5px 0; }
    .receipt-total { display: flex; justify-content: space-between; font-weight: bold; font-size: 24px; border-top: 2px solid black; margin-top: 10px; padding-top: 5px; }
    
    .btn-home {
        display: inline-block;
        background: #3498db;
        color: white;
        text-decoration: none;
        font-size: 24px;
        padding: 10px 30px;
        border: 4px solid #1f618d;
        box-shadow: 4px 4px 0px black;
    }
    .btn-home:hover { transform: translate(-2px, -2px); box-shadow: 6px 6px 0px black; }
</style>
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