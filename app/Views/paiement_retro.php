<?= $this->extend('layouts/base_retro') ?>

<?= $this->section('contenu') ?>
    <div class="cart-retro-container">
        <div class="trainer-header">
            <h1>PAYMENT TERMINAL</h1>
        </div>

        <?php if(session()->getFlashdata('msg')):?>
            <div style="background: #ffcccc; color: red; border: 4px solid red; padding: 10px; margin: 15px 0; font-weight: bold; text-align: center; text-transform: uppercase; font-family: monospace;">
                ⚠️ <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif;?>

        <div class="total-display" style="text-align:center; margin: 20px 0; font-size: 1.5rem; font-weight: bold; color: #ffcc00;">
            TOTAL DUE: $<?= number_format($total_global, 2) ?>
        </div>

        <div style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center;">

            <div style="border: 4px solid #fff; padding: 20px; background: #111; width: 320px; box-shadow: 8px 8px 0px #444;">
                <h3 style="color: #0f0; margin-bottom: 15px; text-transform: uppercase;">[ CREDIT CARD ]</h3>
                <form action="<?= base_url('paiement/process') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="commande_id" value="<?= $commande->id ?>">
                    <input type="hidden" name="type_paiement" value="card">

                    <input type="text" name="cc_num" placeholder="CARD NUMBER" style="width:100%; margin-bottom:10px; background: #000; border: 2px solid #fff; color: #0f0; padding: 8px; font-family: monospace;">
                    <div style="display:flex; gap: 10px;">
                        <input type="text" name="cc_exp" placeholder="MM/YY" style="width:50%; background: #000; border: 2px solid #fff; color: #0f0; padding: 8px; font-family: monospace;">
                        <input type="text" name="cc_cvv" placeholder="CVV" style="width:50%; background: #000; border: 2px solid #fff; color: #0f0; padding: 8px; font-family: monospace;">
                    </div>

                    <button type="submit" class="btn-retro btn-save" style="width:100%; margin-top:20px; padding: 10px; cursor: pointer;">CONFIRM CARD</button>
                </form>
            </div>

            <div style="border: 4px solid #0070ba; padding: 20px; background: #111; width: 320px; box-shadow: 8px 8px 0px #003d66;">
                <h3 style="color: #0070ba; margin-bottom: 15px; text-transform: uppercase;">[ PAYPAL LOGIN ]</h3>
                <form action="<?= base_url('paiement/process') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="commande_id" value="<?= $commande->id ?>">
                    <input type="hidden" name="type_paiement" value="paypal">

                    <input type="text" name="paypal_email" placeholder="TRAINER EMAIL" style="width:100%; margin-bottom:10px; background: #000; border: 2px solid #0070ba; color: #0070ba; padding: 8px; font-family: monospace;">
                    <input type="password" name="paypal_pass" placeholder="PASSWORD" style="width:100%; margin-bottom:10px; background: #000; border: 2px solid #0070ba; color: #0070ba; padding: 8px; font-family: monospace;">

                    <button type="submit" class="btn-retro btn-edit" style="width:100%; margin-top:20px; background: #0070ba; color: white; border: none; padding: 10px; cursor: pointer;">LOGIN & PAY</button>
                </form>
            </div>

        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="<?= base_url('panier') ?>" style="color: #666; font-family: monospace; text-decoration: none;">&lt; RETURN TO INVENTORY</a>
        </div>
    </div>
<?= $this->endSection() ?>