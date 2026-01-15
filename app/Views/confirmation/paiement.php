<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('contenu') ?>
    
    <div class="payment-container">
        
        <div class="section-title">
            <h2> Terminal de Paiement</h2>
        </div>

        <?php if(session()->getFlashdata('msg')):?>
            <div class="alert alert-error">
                 <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif;?>

        <div class="total-due-display">
            TOTAL DÛ : <span class="blink"><?= number_format($total_global, 2) ?>€</span>
        </div>

        <div class="payment-grid">

            <div class="payment-card card-credit">
                <div class="payment-title">[ CARTE DE CRÉDIT ]</div>
                
                <form action="<?= base_url('paiement/process') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="commande_id" value="<?= $commande->id ?>">
                    <input type="hidden" name="type_paiement" value="card">

                    <label>NUMÉRO DE CARTE</label>
                    <input type="text" name="cc_num" inputmode = "numeric" pattern="[0-9]{16}" placeholder="XXXX XXXX XXXX XXXX" class="pay-input" required>
                    
                    <div class="pay-row">
                        <div style="flex:1">
                            <label>EXP</label>
                            <input type="month" name="cc_exp" placeholder="MM/YY" pattern = "[01-12]{2}/[25-60]{2}"class="pay-input" required>
                        </div>
                        <div style="flex:1">
                            <label>CVV</label>
                            <input type="text" inputmode= "numeric" pattern = "[0-9]{3}" name="cc_cvv" placeholder="123" class="pay-input" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-pay-action btn-cc">
                        CONFIRMER LA CARTE
                    </button>
                </form>
            </div>

            <div class="payment-card card-paypal">
                <div class="payment-title">[ CONNEXION PAYPAL ]</div>
                
                <form action="<?= base_url('paiement/process') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="commande_id" value="<?= $commande->id ?>">
                    <input type="hidden" name="type_paiement" value="paypal">

                    <label>EMAIL PAYPAL</label>
                    <input type="email" name="paypal_email" placeholder="ASH@KETO.CH" class="pay-input">
                    
                    <label>MOT DE PASSE</label>
                    <input type="password" name="paypal_pass" placeholder="******" class="pay-input">

                    <button type="submit" class="btn-pay-action btn-pp">
                        SE CONNECTER & PAYER
                    </button>
                </form>
            </div>

        </div>

        <div style="text-align: center;">
            <a href="<?= base_url('panier') ?>" class="link-back">
                &lt; RETOUR À L'INVENTAIRE
            </a>
        </div>
    </div>

<?= $this->endSection() ?>