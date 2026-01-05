<?= $this->extend('layouts/base') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url("css/connexion.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

    <div class="container">
        <div class="form_area">
            <p class="title">Connexion</p>

            <?php if(session()->getFlashdata('msg')):?>
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                    <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif;?>

            <form action="<?= base_url('connexion/auth') ?>" method="post">
                <div class="group_form">
                    <label class="sub_title" for="username">Identifiant</label>
                    <input type="text" placeholder="Entrez votre identifiant" id="username" class="form_style" name="login">
                </div>
                <div class="group_form">
                    <label class="sub_title" for="password">Mot de passe</label>
                    <input type="password" placeholder="Entrez votre mot de passe" id="password" class="form_style" name="password">
                </div>
                <div>
                    <button class="submit">Se connecter</button>
                    <p>Vous n'avez pas de compte ? <a class="link" href="<?= base_url('inscription') ?>">Inscrivez vous ici !</a></p>
                </div>
            </form>
        
        </div>
    </div>

<?= $this->endSection() ?>