<?= $this->extend('layouts/base2') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url("css/connexion.css") ?>">
    <style>
        .error-text { color: red; font-size: 0.8em; display: block; margin-top: 5px; }
        .success-msg { color: green; text-align: center; font-weight: bold; }
    </style>
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="container">
    <div class="form_area" style="margin-top: 50px;"> <p class="title">Inscription</p>
        
        <?php if(isset($validation)):?>
            <div style="color: red; text-align: center; margin-bottom: 15px;">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif;?>

        <form action="<?= base_url('inscription/register') ?>" method="post">
            
            <div class="group_form">
                <label class="sub_title" for="login">Identifiant</label>
                <input type="text" name="login" id="login" class="form_style" value="<?= set_value('login') ?>">
            </div>

            <div class="group_form">
                <label class="sub_title" for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form_style" value="<?= set_value('prenom') ?>">
            </div>

            <div class="group_form">
                <label class="sub_title" for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="form_style" value="<?= set_value('nom') ?>">
            </div>

            <div class="group_form">
                <label class="sub_title" for="email">Email</label>
                <input type="email" name="email" id="email" class="form_style" value="<?= set_value('email') ?>">
            </div>

            <div class="group_form">
                <label class="sub_title" for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form_style">
            </div>

            <div>
                <button class="submit">S'inscrire</button>
                <p>Déjà un compte ? <a class="link" href="<?= base_url('connexion') ?>">Connectez-vous ici !</a></p>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>