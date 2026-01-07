<?= $this->extend('layouts/base_retro') ?> 

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url("css/connexion_retro.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

    <div class="container">
        <div class="form_area">
            
            <p class="title">LOGIN</p> 
            <?php if(session()->getFlashdata('success')):?>
                <div style="background: #ccffcc; color: #005500; border: 2px solid #005500; padding: 10px; margin-bottom: 15px; font-weight: bold; text-transform: uppercase;">
                     <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif;?>

            <?php if(session()->getFlashdata('msg')):?>
                <div style="background: #ffcccc; color: red; border: 2px solid red; padding: 10px; margin-bottom: 15px; font-weight: bold; text-transform: uppercase;">
                     <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif;?>

            <form action="<?= base_url('connexion/auth') ?>" method="post">
                <div class="group_form">
                    <label class="sub_title" for="username">Identifiant</label>
                    <input type="text" id="username" class="form_style" name="login" required>
                </div>
                <div class="group_form">
                    <label class="sub_title" for="password">Mot de passe</label>
                    <input type="password" id="password" class="form_style" name="password" required>
                </div>
                <div class="action">
                    <button class="submit">START GAME</button> <p>New Player? <a class="link" href="<?= base_url('inscription') ?>">Insert Coin (Inscription)</a></p>
                </div>
            </form>
        
        </div>
    </div>

<?= $this->endSection() ?>