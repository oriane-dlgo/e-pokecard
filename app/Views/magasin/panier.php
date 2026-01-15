<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url("css/pages/panier.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="cart-retro-container">
    <div class="trainer-header">
        <h1>PANIER</h1>
    </div>

    <?php if(session()->getFlashdata('msg')):?>
        <div class="alert alert-error" style="color: red; background: #ffe6e6; padding: 10px; border: 2px solid red; margin-bottom: 20px;">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif;?>

    <?php if (empty($articles)): ?>
        <div class="empty-cart-retro">
            <p>VOTRE PANIER EST VIDE !</p>
            <a href="<?= base_url('/') ?>" class="btn-retro btn-edit">RETOUR À LA BOUTIQUE</a>
        </div>
    <?php else: ?>

        <?= view('partials/tableau_articles', [
            'items' => $articles, 
            'editable' => true // C'est ici qu'on active le mode Panier
        ]) ?>

        <div class="cart-summary">
            
            <div class="menu-box">
                <a href="<?= base_url('panier/vider') ?>" class="btn-retro btn-logout">VIDER TOUT</a>
                <a href="<?= base_url('panier/valider') ?>" class="btn-retro btn-save">VALIDER</a>
            </div>

            <div class="total-display">
                TOTAL: <?= number_format($total_global, 2) ?>€ 
            </div>
        </div>

    <?php endif; ?>
</div>

<?= $this->endSection() ?>